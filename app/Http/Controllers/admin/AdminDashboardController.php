<?php

namespace App\Http\Controllers\admin;

use App\Models\BannerModel;


use App\Http\Controllers\Controller;
use App\Models\OrdersModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminDashboardController extends Controller
{
    function dashboard()
    {
        $yearlyMemberships = OrdersModel::select(
            DB::raw("year(created_at) as year"),
            DB::raw("month(created_at) as month"),
            DB::raw("SUM(price) as price"),
            DB::raw("COUNT(price) as count_sale"))
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTH(created_at)"))
            ->get();
//        $monthly_sales;
        $now = Carbon::now();
        foreach ($yearlyMemberships as $key => $value) {
            if($value->year == $now->year)
            {
                $monthly_sales[$key] = [$value->year, $value->month, (int)$value->price, (int)$value->count_sale];
            }
        }
        for($a = 1; $a <= 12; $a++)
        {
            $haveVal = false;
            foreach($monthly_sales as $val)
            {
                if($a == $val[1])
                {
                    $haveVal = true;
                    $monthly_sale[$a] = $val[2];
                    break;
                }
            }
            if(!$haveVal)
            {
                $monthly_sale[$a] = 0;
            }
        }
        $data['monthly_sale'] = $monthly_sale;
        return view('admin.dashboard', $data);
    }

/**Banner functions starts*/
    function banner()
    {
        $banner = BannerModel::get();
        return view('admin.banners.banner-list',compact('banner'));
    }
    function banner_add()
    {
        return view('admin.banners.banner-add');
    }
    function banner_edit($id)
    {
        $banner = BannerModel::where('id',$id)->first();
        return view('admin.banners.banner-edit',compact('banner'));
    }
    function banner_delete(BannerModel $banner)
    {
        $banner->delete();
        return back()->with('delete','Deleted Successfully');
    }
    function banner_add_edit_data(Request $request,BannerModel $banner)
    {
        $create = 1;
        (isset($banner->id) and $banner->id>0)?$create=0:$create=1;
        if($request->hasFile('title'))
        {
            /***for deleting file*/
            $destinationPath = public_path('/uploads/banners');
            File::delete($destinationPath.'/'.$banner->title);
            /***for uploading new file*/
            $imageName = time().'.'.$request->title->getClientOriginalExtension();
            $request->title->move(public_path('/uploads/banners'), $imageName);
            $banner->title = $imageName;
        }
//        $banner->status = $request->status;
        $banner->save();
        if($create == 0)
        {
            return back()->with('update','Updated Successfully');
        }
        else
        {
            return back()->with('success','Added Successfully');
        }
    }
/**Banner functions ends*/


}
