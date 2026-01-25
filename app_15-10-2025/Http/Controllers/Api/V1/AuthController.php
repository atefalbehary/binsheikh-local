<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
// use Kreait\Firebase\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Database;
use Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public $lang = '';
    public function __construct(Database $database, Request $request)
    {
        $this->database = $database;
    }
    public function login(Request $request)
    {
        $rules = [
            'password' => 'required',
            'email' => 'required|email',
            'fcm_token' => 'required',
            // 'device_type' => 'required',
        ];
        $messages = [
            'password.required' => __('messages.password_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.valid_email'),
            'fcm_token.required' => __('messages.fcm_token_required'),
            'device_type.required' => __('messages.device_type_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);

        }
        $lemail = strtolower($request->email);
        if (Auth::attempt(['email' => $lemail, 'password' => $request->password, 'deleted' => 0])) {
            if (Auth::user()->role == 1) {
                $authUser = Auth::user();
                $authUser->tokens()->delete();
                return response()->json([
                    'message' => __('messages.invalid_credentials'),
                ], 401);
            }

            if (!Auth::user()->active) {
                return response()->json([
                    'message' => __('messages.account_deactivated_by_admin'),
                ], 401);
            }
            if (!Auth::user()->verified) {
                return response()->json(['message' => __('messages.account_need_approve_from_admin')], 401);
            }
            $user = User::find(auth()->user()->id);
            $user->user_device_token = $request->fcm_token;
            $user->user_device_type = $request->device_type;
            $user->social_type = '';
            $user->save();
            $data = [
                    'email' => $user->email,
                    'user_type' => $user->role,
                    'name' => $user->name,
                    'id' => $user->id,
                    'phone' => $user->phone,
                    'image' => $user->image ? aws_asset_path($user->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                    'token' => $user->createToken('binalsheikh')->plainTextToken,
            ];
            return response()->json([
                'message' =>  __('messages.logged_in_successfully'),
                'data' => convert_all_elements_to_string($data),
            ], 200);

        } else {
            return response()->json([
                'message' => __('messages.invalid_credentials'),
            ], 401);
        }
    }

    public function social_login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'name' => 'required',
            // 'device_type' => 'required',
            'fcm_token' => 'required',
        ];
        $messages = [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.valid_email'),
            'name.required' => __('messages.name_required'),
            'fcm_token.required' => __('messages.fcm_token_required'),
            'device_type.required' => __('messages.device_type_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);
        }
        if ($user = User::where('email', $request->email)->where("deleted", 0)->where(function ($query) {
            $query->where('role','!=',1);
        })->first()) {
            $user->user_device_token = $request->fcm_token;
            $user->user_device_type = $request->device_type;
            $user->social_type = $request->social_type;
            $user->active = 1;
            $user->save();
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'social_type' => $request->social_type,
                'user_device_type' => $request->device_type,
                'user_device_token' => $request->fcm_token,
                'password' => bcrypt(uniqid()),
                'role' => 2,
                'active' => 1,
            ]);
            $user->save();
        }

        $data = [
            'email' => $user->email,
            'user_type' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'phone' => $user->phone,
            'image' => $user->image ? aws_asset_path($user->image) : asset('').'front-assets/images/avatar/profile-icon.png',
            'token' => $user->createToken('binalsheikh')->plainTextToken,
        ];
        return response()->json([
            'message' =>  __('messages.logged_in_successfully'),
            'data' => convert_all_elements_to_string($data),
        ], 200);

    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function send_login_otp(Request $request)
    {
        $rules = [
            'phone' => 'required',
        ];
        $messages = [
            'phone.required' => __('messages.phone_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);

        }
        $phone = $request->phone;
        $phone = ltrim($phone, '+');
        $user = User::whereRaw("REPLACE(phone, '+', '') = ?", [$phone])->first();
        if($user){
            $otp = rand(100000,999999);
            $otp_token = Str::random(60);
            $user->otp = $otp;
            $user->otp_token = $otp_token;
            $user->otp_time = gmdate('Y-m-d H:i:s');
            $user->save();
            $mailbody = View::make('front_end.otp_mail', compact('otp'))->render();
            if(send_email($user->email,'Your OTP Code - Bin Al Sheikh',$mailbody)){
                return response()->json([
                    'message' =>  __('messages.otp_sent_to_mail_and_phone'),
                    'otp_token'=>$otp_token,
                ], 200);
            }else{
                return response()->json([
                    'message' => __('messages.something_went_wrong_try_again'),
                ], 401);
            }
        }else{
            return response()->json([
                'message' => __('messages.no_matching_user_found'),
            ], 401);
        }
    }

    public function verify_login_otp(Request $request)
    {
        $rules = [
            'otp' => 'required',
            'otp_token' => 'required',
        ];
        $messages = [
            'otp.required' => __('messages.otp_required'),
            'otp_token.required' => __('messages.otp_token_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);

        }
        $otp = $request->otp;
        $otp_token = $request->otp_token;
        $user = User::where("otp_token",$otp_token)->where('otp',$otp)->first();
        if($user){
            $user->otp_token = '';
            $user->save();
            $data = [
                'email' => $user->email,
                'user_type' => $user->role,
                'name' => $user->name,
                'id' => $user->id,
                'phone' => $user->phone,
                'image' => $user->image ? aws_asset_path($user->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                'token' => $user->createToken('binalsheikh')->plainTextToken,
            ];
            return response()->json([
                'message' =>  __('messages.logged_in_successfully'),
                'data' => convert_all_elements_to_string($data),
            ], 200);
        }else{
            return response()->json([
                'message' => __('messages.invalid_otp'),
            ], 401);
        }
    }

    public function signup(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'device_type' => 'required',
            'password' => 'required',
            'fcm_token' => 'required',
            'phone' => 'required',
            'user_type'=>'required'
        ];
        $messages = [
            'phone.required' => __('messages.phone_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.valid_email'),
            'name.required' => __('messages.name_required'),
            'password.required' => __('messages.password_required'),
            'fcm_token.required' => __('messages.fcm_token_required'),
            'device_type.required' => __('messages.device_type_required'),
            'user_type.required' => __('messages.user_type_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);
        }

        $lemail = strtolower($request->email);

        if (User::where('email', $lemail)->first() != null) {
            return response()->json([
                'message' => $request->email . " ".__('messages.already_added'),
            ], 401);
        }

        $ins =[
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->user_type,
            'verified' => 0,
            'user_device_type' => $request->device_type,
            'user_device_token' => $request->fcm_token,
            'active' => 1,
        ];
        if ($request->file("image")) {
            $response = image_upload($request, 'profile', 'image');
            if ($response['status']) {
                $ins['image'] = $response['link'];
            }
        }
        if ($request->user_type == 3 || $request->user_type == 4) {
            if ($request->file("license")) {
                $response = image_upload($request, 'profile', 'license');
                if ($response['status']) {
                    $ins['license'] = $response['link'];
                }
            }

            if ($request->file("id_card")) {
                $response = image_upload($request, 'profile', 'id_card');
                if ($response['status']) {
                    $ins['id_card'] = $response['link'];
                }
            }
        }

        if ($request->user_type == 4) {
            if ($request->file("cr")) {
                $response = image_upload($request, 'profile', 'cr');
                if ($response['status']) {
                    $ins['cr'] = $response['link'];
                }
            }

            if ($request->file("real_estate_license")) {
                $response = image_upload($request, 'profile', 'real_estate_license');
                if ($response['status']) {
                    $ins['real_estate_license'] = $response['link'];
                }
            }
        }
        if($request->user_type == 2)
        {
            $ins['verified'] = 1;
        }
        if ($user = User::create($ins)) {
            if($request->user_type == 2)
            {
                $data = [
                    'email' => $user->email,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'id' => $user->id,
                    'image' => asset('').'front-assets/images/avatar/profile-icon.png',
                    'token' => $user->createToken('binalsheikh')->plainTextToken,
                ];
                return response()->json([
                    'message' => __('messages.registration_completed_without_verification'),
                    'data' => convert_all_elements_to_string($data),
                ], 200);
            }
            else
            {
                return response()->json([
                    'message' => __('messages.registration_completed'),
                ], 200);
            }

        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong'),
            ], 401);
        }
    }

    public function logout()
    {
        $authUser = Auth::user();
        $authUser->tokens()->delete();
        return response()->json([
            'message' => 'Logged out',
        ]);
    }
    public function send_forgot_password_otp(Request $request)
    {
        $rules = [
            'email' => 'required',
        ];
        $messages = [
            'email.required' => __('messages.email_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);

        }
        $lemail = strtolower($request->email);
        $user = User::where('email', $lemail)->first();
        if($user){
            $otp = rand(100000,999999);
            $password_token = Str::random(60);
            $user->password_otp = $otp;
            $user->password_token = $password_token;
            $user->password_time = gmdate('Y-m-d H:i:s');
            $user->save();
            $mailbody = View::make('front_end.pswd_otp_mail', compact('otp'))->render();
            if(send_email($user->email,'Your OTP Code - Bin Al Sheikh',$mailbody)){
                return response()->json([
                    'message' =>  __('messages.otp_sent_to_mail_and_phone'),
                    'otp_token'=>$password_token,
                ], 200);
            }else{
                return response()->json([
                    'message' => __('messages.something_went_wrong_try_again'),
                ], 401);
            }
        }else{
            return response()->json([
                'message' => __('messages.no_matching_user_found'),
            ], 401);
        }
    }
    public function reset_forgot_password(Request $request)
    {
        $rules = [
            'otp' => 'required',
            'otp_token' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
        $messages = [
            'password.required' => __('messages.password_required'),
            'otp.required' => __('messages.otp_required'),
            'otp_token.required' => __('messages.otp_token_required'),
            'password.confirmed' => __('messages.password_confirmed'),
            'password_confirmation.required' => __('messages.password_confirmed'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);

        }
        $password_otp = $request->otp;
        $password_token = $request->otp_token;
        $user = User::where("password_token",$password_token)->where('password_otp',$password_otp)->first();
        if($user){
            $user->password = bcrypt($request->password);
            $user->updated_at = gmdate('Y-m-d H:i:s');
            $user->password_token = '';
            $user->save();
            return response()->json([
                'message' =>  __('messages.password_updated'),
                'data' => [],
            ], 200);
        }else{
            return response()->json([
                'message' => __('messages.invalid_otp'),
            ], 401);
        }
    }

    public function change_password(Request $request)
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
            'new_password_confirmation' => 'required',
        ];
        $messages = [
            'old_password.required' => __('messages.old_password_required'),
            'new_password.required' => __('messages.new_password_required'),
            'new_password.confirmed' => __('messages.password_confirmed'),
            'new_password.min' => __('messages.password_min_length'),
            'new_password_confirmation.required' => __('messages.password_confirmation_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);
        }

        $user = Auth::user();
        
        // Verify old password
        if (!password_verify($request->old_password, $user->password)) {
            return response()->json([
                'message' => __('messages.old_password_incorrect'),
            ], 401);
        }

        // Check if new password is different from old password
        if (password_verify($request->new_password, $user->password)) {
            return response()->json([
                'message' => __('messages.new_password_same_as_old'),
            ], 400);
        }

        // Update password
        $user->password = bcrypt($request->new_password);
        $user->updated_at = gmdate('Y-m-d H:i:s');
        $user->save();

        return response()->json([
            'message' => __('messages.password_changed_successfully'),
            'data' => [],
        ], 200);
    }
}
