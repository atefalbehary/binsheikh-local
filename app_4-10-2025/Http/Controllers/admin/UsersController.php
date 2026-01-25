<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UsersController extends Controller
{

    public function change_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $status = "0";
            $message = "";
            $errors = [];
            $validator = Validator::make($request->all(),
                [
                    'cur_pswd' => 'required',
                    'new_pswd' => 'required',
                ],
                [
                    'cur_pswd.required' => 'Current password required',
                    'new_pswd.required' => 'New password required',
                ]
            );
            if ($validator->fails()) {
                $status = "0";
                $message = "Validation error occured";
                $errors = $validator->messages();
            } else {
                $cur_pswd = $request->cur_pswd;
                $new_pswd = $request->new_pswd;
                $user_id = session("user_id");
                if (Auth::attempt(['id' => $user_id, 'password' => $cur_pswd])) {
                    $up['password'] = bcrypt($new_pswd);
                    // if ($request->file("image")) {
                    //     $response = image_upload($request, 'user', 'image');
                    //     if ($response['status']) {
                    //         $up['image'] = $response['link'];
                    //     }
                    // }
                    // dd($up);
                    $up['updated_on'] = gmdate('Y-m-d H:i:s');
                    if (User::update_password($user_id, $new_pswd)) {
                        $status = "1";
                        $message = "Password successfully changed";
                        $errors = '';
                    } else {
                        $status = "0";
                        $message = "Unable to change password. Please try again later";
                        $errors = '';
                    }
                } else {
                    $status = "0";
                    $message = "Invalid Current Password";
                    $errors = '';
                }

            }
            echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
        } else {
            $page_heading = "Change Password";
            return view("admin.users.change_password", compact('page_heading'));
        }

    }
    public function change_user_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $status = "0";
            $message = "";
            $errors = [];
            $validator = Validator::make($request->all(),
                [
                    'password' => 'required',
                    'id' => 'required',
                ],
                [
                    'password.required' => 'password required',
                    'id.required' => 'User ID required',
                ]
            );
            if ($validator->fails()) {
                $status = "0";
                $message = "Validation error occured";
                $errors = $validator->messages();
            } else {
                $new_pswd = $request->password;
                $user_id = $request->id;
                if (User::update_password($user_id, $new_pswd)) {
                    $status = "1";
                    $message = "Password successfully changed";
                    $errors = '';
                } else {
                    $status = "0";
                    $message = "Unable to change password. Please try again later";
                    $errors = '';
                }

            }
            echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
        } else {
            $page_heading = "Change Password";
            return view("admin.users.change_password", compact('page_heading'));
        }

    }

}
