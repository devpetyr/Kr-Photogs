<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use App\Models\Coupon_detailModel;
use App\Models\CouponModel;
use App\Models\ForgetPassModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Stripe;
use App\Models\CompetitionModel;
use App\Models\OrdersModel;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use \Carbon\Carbon;
use App\Mail\contactFormEmail;

class UIcontroller extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request)
    {
        Auth::logoutOtherDevices($request->get('password'));
    }
    public function index()
    {
        $competition = CompetitionModel::where('status', 1)->get();
        return view('index', compact('competition'));
    }

    public function password_reset()
    {
        return view('password-reset');
    }
    public function myredeem()
    {
        $data = OrdersModel::with('order_with_comp')->where('user_id', Auth::user()->id)->get();
//        dd($data);
        return view('myredeem', compact('data'));
    }
    public function login()
    {
        return view('login');
    }
    public function schdularCheck()
    {
            $user=new CompetitionModel;
            $user->title= session()->get('serverIP').'xyz23456' ;
            $user->save();
    }
    public function login_post(Request $request)
   {
        $request->validate([
            'Email' => 'required',
            'Pass' => 'min:8|required',
        ]);
        $emails = User::where('email', $request->Email)->where('user_role', 0)->first();
        if ($emails) {
            $softCheck = User::where('email', $request->Email)->where('status', 1)->where('user_role', 0)->where('soft_delete', null)->first();
            if($softCheck)
            {
                $statusCheck = User::where('email', $request->Email)->where('status', 1)->where('user_role', 0)->first();
            if ($statusCheck) {
                if (Hash::check($request->Pass,$emails->password)) {
                    Auth::logoutOtherDevices($request->Pass);
                    Auth::login($emails);
                    if (session()->has('competition')) {
                        return redirect()->route('payment_method');
                    }
                    else
                    {
                        return redirect()->route('index')->with('added', 'login Successfully');
                    }
                } else {
                    session()->flash('passerror');
                    return back()->with('input_pass', $request->log_password);
                }
            }
            else {
                session()->flash('statusCheck');
                return back()->with('input_email', $request->log_email);
                 }
            }
            else
            {
                session()->flash('emailerror');
                return back()->with('input_email', $request->log_email);
            }


        } else {
            session()->flash('emailerror');
            return back()->with('input_email', $request->log_email);
        }
    }




    public function user_logout(Request $request)
    {
//        dd(Auth::user()->id);

//        $user=User::where('id',Auth::user()->id)->first();
//        $user->server_IP=0;
//        $user->update();

        Auth::logout();
        session()->forget('competition');
        return back()->with('failed', 'Logout Successfully');
    }
    public function register()
    {
        return view('register');
    }
    public function register_post(Request $request)
    {
//         dd($request);
        $request->validate([
            'Username' => 'required|min:3|max:15',
            'Email' => 'required',
            'Pass' => 'min:8|required_with:con_Pass|same:con_Pass',
            'con_Pass' => 'required|min:8',
        ]);
        $check=User::where('email',$request->Email)->first();
        if (!$check)
        {
            $user = new User;
            $user->username = $request->Username;
            $user->email = $request->Email;
            $hashed = Hash::make($request->Pass);
            $user->password =$hashed;
            $user->user_role = 0;
            //server IP start
//            $ip=serverIPs();
//            $user->server_IP=$ip;
            $user->save();


            if (session()->has('competition')) {
                // dd(session()->get('competition'));
                Auth::login($user);
                return redirect()->route('payment_method');
            } else {
                // dd('not have a session');
                Auth::login($user);
                return redirect()->route('index')->with('added', 'Register and Login Successfully');
            }
        }
        else
        {
            session()->flash('emailexist');
            return back();
        }


        // return redirect()->route('index');


    }
    public function competition(Request $request)
    {
        $this->validate(
            $request,
            [
                'comp' => 'required|not_in:0',
            ],
            [
                'comp.required' => 'Please select competition.',
            ]
        );
        $com=CompetitionModel::where('id',$request->comp)->first();
//        dd($com);
        session()->put('competition', [
            'id'=>$com->id,
            'title'=>$com->title,
            'date'=>$com->competition_date,
            'amount'=>$com->amount,
            'url'=>$com->url]);
//        $test=session()->get('competition');
//        dd($test['id']);
        return redirect()->route('payment_method');
    }
    public function stripe_form()
    {
        return view('stripe');
    }
    //inside controller
    public function stripe_payment($email, $token, $price, $desc)
    {

        /* stripe */
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $customer = \Stripe\Customer::create(array(
            'email' => $email,
            'source'  => $token
        ));
        $charge = Stripe\Charge::create([
            "customer" => $customer->id,
            "amount" => $price * 100,
            "currency" => "usd",
            "description" => $desc
        ]);
        return $charge;
    }
    //controller

    public function iframe($id)
    {
//        if(session('redeem'))
//        {
            $code = CompetitionModel::where('id',$id)->where('soft_delete',null)->first();
            if($code)
            {
                $iframe = $code->iframe;
                return view('iframe',compact('iframe'));
            }
            else{
                return back()->with('failed','Competition does not exist anymore.');
            }

//        }else
//        {
//            return redirect()->route('ui_redeem_code');
//        }

    }
    public function redeem_code()
    {
        return view('redeem-code');
    }
    public function redeem_code_post(Request $request)
     {
        $request->validate([
            'redeem_code' => 'required|min:24',
        ]);
        $redeem=OrdersModel::where('redeem_code',$request->redeem_code)->first();
        if($redeem)
        {
            $date = Carbon::now();
            // dd($date;

            $code = CompetitionModel::where('id',$redeem->competition_name)
                ->where('competition_date',$date->format('Y-m-d'))->first();
            if ($code)
            {
//                return view('iframe',compact('code'));
//                session()->put('redeem',['code'=>$redeem->redeem_code,'url'=>$redeem->url,'iframe'=>$code->iframe]);
                return redirect()->route('iframe',[$code->id]);
            }
            else
            {
                session()->flash('Redeemerror1');
                return back();
            }
        }
        else
        {
            session()->flash('Redeemerror2');
            return back();
        }

    }
    public function user_profile()
    {
        $data=User::where('id',Auth::user()->id)->first();
//        dd($data);
        return view('profile',compact('data'));
    }

    public function user_profile_post(Request $request)
    {
//        dd($request);
        $user =User::where('id',Auth::user()->id)->first();
        $user->username = $request->Username;
        $user->update();
        return back()->with('added', 'Profile Updated');
    }
    public function reset_password_post(Request $request)
    {
        $request->validate([
            'old_Pass' => 'required|min:8|max:15',
            'Pass' => 'min:8|max:15|same:con_Pass',
            'con_Pass' => 'min:8|max:15',
        ]);
        $user =User::where('id',Auth::user()->id)->first();
         $check=Hash::check($request->old_Pass,$user->password);
        if ($check)
        {
          $hashed = Hash::make($request->Pass);
          $user->password = $hashed;
          $user->update();
          Auth::logout();
          return back()->with('added', 'Profile Updated');
        }
        else
        {
            return back()->with('failed', 'Password not match');
        }
//        dd($password_check);
    }
    public function payment_method()
    {
        return view('payment_method');
    }
    public function comp_ajax(Request  $req)
    {
        $comp_data=CompetitionModel::where('id',$req->name)->first();
        return response()->json([
            'status' => 1,
            'data' => $comp_data->competition_date,
        ]);
    }
    public function mail_post()
    {
        $request=session()->get('sendEmail');
        // dd($request);
        $user=User::where('id',$request['user_id'])->first();
        // dd($user->email);

//        dd(session()->get('sendEmail'));
        $details = [
            'title' => 'Redeem Code :'.$request['redeem_code'],
            'body' => 'Amount is :'.$request['amount'],
        ];

        \Mail::to($user->email)->send(new \App\Mail\MyTestMail($details));
//dd('Mail send');
        return redirect(route('user_myredeem'))->with('added', 'Thank you for purchasing...');
    }
    public function Coupon_discount(Request $request)
    {
        $competition=session()->get('competition');
        $request->validate([
            'code'=>'required',
        ]);
        $code=CouponModel::where('code',$request->code)
            ->where('status',1)
            ->where('quantity','>',0)
            ->where('competition_id',$competition['id'])
            ->first();
        if ($code)
        {
            $check=Coupon_detailModel::where('user_id',Auth::user()->id)
                ->where('coupon_id',$code->id)
                ->first();
            if (!$check)
            {
                $disc_check=CouponModel::where('code',$request->code)
                    ->where('status',1)
                    ->where('quantity','>',0)
                    ->where('competition_id',$competition['id'])
                    ->where('discount',100)
                    ->first();
                if ($disc_check)
                {
                    session()->put('free_coupon','Free Coupon');
                    $competition['code']=$code->code;
                    $competition['amount']=0;
                    $competition['discount']=$code->discount;
                    $competition['coupon_id']=$code->id;
                    session()->put('competition',$competition);
                    return back()->with('added', 'Free Coupon Added...');
                }
                else
                {
                    if (!isset(session()->get('competition')['code']))
                    {

                        $competition['code']=$code->code;
                        $convert=$code->discount/100;
                        $multiply=$convert * $competition['amount'];
                        $dis_price=$competition['amount'] - $multiply;
                        $competition['amount']=$dis_price;
                        $competition['discount']=$code->discount;
                        $competition['coupon_id']=$code->id;
                        session()->put('competition',$competition);
                        return back()->with('added', 'Coupon Added...');
                    }
                    else
                    {
                        return back()->with('failed', 'Sorry coupon can not use...');
                    }
                }




            }
            else
            {
                return back()->with('failed', 'You can use this code only one time...');
            }
        }
        else
        {
            return back()->with('failed', 'Invalid code...');
        }

    }
    public function remove_coupon()
    {
        $session=session()->get('competition');
        $code=CompetitionModel::where('id',$session['id'])->first();
        $session['amount']=$code->amount;
        unset($session['code']);
        unset($session['discount']);
        unset($session['coupon_id']);
        session()->put('competition',$session);
        session()->forget('free_coupon');
        return back()->with('failed', 'Coupon remove...');
    }
    public function free_redeem_code()
    {

        $redeem_code = date('Ymd').time().rand(111111,999999);
        $session=session()->get('competition');
        $orders = new OrdersModel;
//        $orders->payer_id = $arr_body['id'];
        $orders->user_id = Auth::user()->id;
        $orders->price = 0 ;
        $orders->status = "free";
        $orders->redeem_code = $redeem_code;
        $orders->payment_method = "free coupon";
        $orders->competition_name =$session['id'] ;
        $orders->competition_date = $session['date'] ;
        $orders->url = $session['url'] ;
        $comp_name=CompetitionModel::where('id',$session['id'])->first();
        session()->put('sendEmail', [
            'user_id'=>Auth::user()->id,
            'redeem_code'=>$redeem_code,
            'amount'=>$session['amount'],
            'comp_date'=>$session['date'],
            'comp_name'=>$comp_name->title,
        ]);
        if(isset(session()->get('competition')['code']))
        {
            $coupon= new Coupon_detailModel;
            $coupon->user_id=Auth::user()->id;
            $coupon->coupon_id=$session['coupon_id'];
            $subtract=CouponModel::where('id',$session['coupon_id'])->first();
                    $subtract->quantity -= 1;
                    $subtract->save();
            $coupon->save();

        }

        $orders->save();

        // session()->put('redeem_code', $redeem_code);

        session()->forget('competition');
        session()->forget('free_coupon');
        return redirect(route('mail_post'));
    }
    public function mail_post_pass_reset(Request $request)
    {
        $request->validate([
            'mail'=>'required',
        ]);
        $user=User::where('email',$request->mail)->first();
        if ($user)
        {
            $Pass_code = date('Ymd').time().rand(111,999);
            $pass=new ForgetPassModel;
            $pass->user_id=$user->id;
            $pass->code=$Pass_code;
            $pass->status=1;
            $pass->save();
            $details = [
                'title' => 'Rsest Password ',
                'body' => 'Visit our web site ',
                'id'=>$user->id,
                'user'=>$user->username,
                'code'=>$Pass_code,
                'status'=>1,
            ];
//            dd($details);
            \Mail::to($request->mail)->send(new \App\Mail\ResetPassword($details));
            return back()->with('added', 'Pleace visit you mail box...');
        }
        else
        {
            session()->flash('mailerror');
            return back();
        }

    }
    public function forget_password($id , $code)
    {
        $check=ForgetPassModel::where('user_id',$id)
            ->where('code',$code)
            ->where('status',1)
            ->first();
        if ($check)
        {
            return view('reset_password',compact('id','code'));
        }
        else
        {
            return view('linkExpire');
        }
    }
    public function change_password(Request $request,$id,$code)
    {
        $user=User::where('id',$id)->first();
        $request->validate([
            'Pass' => 'min:8|required_with:con_Pass|same:con_Pass',
            'con_Pass' => 'required|min:8',
        ]);
        $hashed = Hash::make($request->Pass);
        $user->password =$hashed;
        $user->update();
        $pass=ForgetPassModel::where('user_id',$id)
            ->where('code',$code)
            ->where('status',1)
            ->first();
        $pass->status=0;
        $pass->update();
        return redirect()->route('user_login')->with('added', 'Password Changed Successfully');

    }
    public function authcheck()
    {
        if(!auth()->check()){
             Auth::logout();
            return response()->json(['status'=>1],200);
        }else{
            return response()->json(['status'=>0]);
        }

    }
    public function emailtest()
    {
        return view('emails.contact-form-email');
    }
    public function contactForm(Request $request)
    {
        $user = User::where('user_role',1)->first();
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];

        \Mail::to($user->email)->send(new contactFormEmail($details));
        \Mail::to('devpetyr911@gmail.com')->send(new contactFormEmail($details));
        return back()->with('added','Submitted Successfully');
    }
}
