<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Reviews;

class AboutUsController extends Controller
{
    //

    public function index()
    { 
        $page_heading = "About Us";
       
        return view('front_end.about_us',compact('page_heading'));
    }


    // public function privacy_policy()
    // { 
    //     $page_heading = "Privacy Policy";
    //     $data = Pages::where(['pages.deleted' => 0,'slug'=>'privacy-policy'])->first();
    //     if($data){
    //         if(session('sys_lang')=="es"){
    //             $data->description = $data->description_es ?? $data->description;
    //             $data->name = $data->name_es ?? $data->name;
    //         }
    //     }
    //     return view('front_end.privacy_policy',compact('page_heading','data'));
    // }


    // public function terms_of_use()
    // { 
    //     $page_heading = "Terms of Use";
    //     $data = Pages::where(['pages.deleted' => 0,'slug'=>'terms-of-use'])->first();
    //     if($data){
    //         if(session('sys_lang')=="es"){
    //             $data->description = $data->description_es ?? $data->description;
    //             $data->name = $data->name_es ?? $data->name;
    //         }
    //     }
    //     return view('front_end.terms_of_use',compact('page_heading','data'));
    // }
    // public function faq()
    // { 
    //     $page_heading = "FAQ";
    //     return view('front_end.faq',compact('page_heading'));
    // }
}
