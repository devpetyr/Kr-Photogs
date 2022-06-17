<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FAQModel;
use Illuminate\Http\Request;

class AdminFaqsController extends Controller
{
    function faqs_list()
    {
        $faq = FAQModel::get();
        return view('admin.faqs.list',compact('faq'));
    }
    function faqs_add()
    {
        return view('admin.faqs.create');
    }
    function faqs_edit($id)
    {
        $faq = FAQModel::where('id',$id)->first();
        return view('admin.faqs.edit',compact('faq'));
    }
    function faqs_delete(FAQModel $faq)
    {
        $faq->delete();
        return back()->with('delete','Deleted Successfully');
    }
    function faqs_add_edit_data(Request $request,FAQModel $faq)
    {
        $create = 1;
        (isset($faq->id) and $faq->id>0)?$create=0:$create=1;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $request->status;
        $faq->save();
        if($create == 0)
        {
            return back()->with('update','Updated Successfully');
        }
        else
        {
            return back()->with('success','Added Successfully');
        }
    }
}
