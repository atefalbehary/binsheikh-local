<?php

namespace App\Http\Controllers\front;
use App\Models\Career;
use App\Models\CareerApplication;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
class ContactUsController extends Controller
{
    //

    public function index()
    {
        $page_heading = "Contact Us";
        $careers = Career::where(['deleted' => 0,'active'=>1])->orderBy('created_at', 'desc')->get();
        return view('front_end.contact_us', compact('page_heading','careers'));
    }
    public function apply_career(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = [];
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ],
            [
                'name.required' => 'Name required',
                'email.required' => 'Email required',
                'phone.required' => 'Phone required',
            ]
        );
        if ($validator->fails()) {
            $status = "0";
            $message = __('messages.validation_error_occurred');
            $errors = $validator->messages();
        }

        $ins = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'job_position' => $request->job_position,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ];
        if ($request->file("cv")) {
            $response = image_upload($request, 'career', 'cv');
            if ($response['status']) {
                $ins['cv'] = $response['link'];
            }
        }
        if (CareerApplication::create($ins)->id) {
            $status = "1";
          
            $message = __('messages.successfully_submitted_contact_soon');
            $errors = '';
        } else {
            $status = "0";
            $message = __('messages.something_went_wrong');
            $errors = '';
        }
        return response()->json(['success' => $status, 'message' => $message, 'errors' => $errors]);
        
    }
}
