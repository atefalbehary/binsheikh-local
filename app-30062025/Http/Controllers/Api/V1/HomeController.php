<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentData;
use App\Models\Projects;
use App\Models\Properties;
use App\Models\Country;
use App\Models\TempBooking;
use App\Models\TempReservation;
use App\Models\User;
use App\Models\FavouriteProperty;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\ProjectCountry;
use App\Models\Settings;
use App\Models\ContactUsModel;
use Carbon\Carbon;
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $lang = '';
    public function __construct()
    {

    }
    public function projects(Request $request)
    {
        $projects = Projects::select('id', 'name', 'name_ar', 'image','location','location_ar','app_image')->where(['active' => '1', 'deleted' => 0]);
        if($request->country_id){
            $projects = $projects->where('country', $request->country_id);
        }
        $projects = $projects->orderBy('created_at', 'desc')->get();
        foreach ($projects as $key => $val) {
            // Get count of apartments for this project
            $apartment_count = Properties::where([
                'project_id' => $val->id,
                'active' => '1',
                'deleted' => 0
            ])->count();

            $projects[$key]->name  = $val->name;
            $projects[$key]->location  = $val->location;
            $projects[$key]->image = $val->app_image ? aws_asset_path($val->app_image) : ($val->image ?aws_asset_path($val->image) : '');
            $projects[$key]->apartment_count = $apartment_count;
            // $projects[$key]->image = $val->image ? aws_asset_path($val->image) : "";
            unset($projects[$key]->name_ar);
            unset($projects[$key]->location_ar);
            unset($projects[$key]->app_image);
        }

        return response()->json(['message' => "Projects", 'data' => convert_all_elements_to_string($projects)], 200);
    }
    public function project_details(Request $request)
    {
        $project = Projects::with(['images'])->where(['id' => $request->id, 'active' => '1', 'deleted' => 0])->first();
        $data    = [];
        if ($project) {
            $data['name']        = $project->name;
            $data['location']    = $project->location;
            $data['description'] = $project->description;
            $data['link_360']    = $project->link_360;
            $data['image']           = $project->app_image ? aws_asset_path($project->app_image) : ($project->image ?aws_asset_path($project->image) : '');
            $data['banner']          = $project->banner ? aws_asset_path($project->banner) : "";
            $data['video']           = $project->video ? aws_asset_path($project->video) : "";
            $data['video_thumbnail'] = $project->video_thumbnail ? aws_asset_path($project->video_thumbnail) : "";
            $data['images'] = $project->images->map(function($imgs) {
                return [
                    'image' => $imgs->image ? aws_asset_path($imgs->image) : "",
                    'type'  => $imgs->type,
                ];
            });

            // Get suggested apartments
            $similar = null;
            if ($project->suggested_apartments) {
                $suggested_apartment_ids = explode(',', $project->suggested_apartments);
                $similar = Properties::with(['property_type', 'images'])
                    ->whereIn('id', $suggested_apartment_ids)
                    ->where(['active' => 1, 'deleted' => 0])
                    ->limit(6)
                    ->get();
            }

            // If no explicitly linked properties or not enough, fall back to the default criteria
            if (!$similar || $similar->count() < 6) {
                $fallbackQuery = Properties::with(['property_type', 'images'])
                    ->where(['active' => '1', 'deleted' => 0, 'project_id' => $project->id]);

                if ($similar) {
                    $fallbackQuery->whereNotIn('id', explode(',', $project->suggested_apartments));
                }

                $fallback = $fallbackQuery->limit(6 - ($similar ? $similar->count() : 0))->get();

                if ($similar) {
                    $similar = $similar->concat($fallback);
                } else {
                    $similar = $fallback;
                }
            }

            if ($similar){
              $suggested_apartments = $similar->map(function($property) {
                    return [
                        'id' => $property->id,
                        'name' => $property->name,
                        'price' => $property->price,
                        'bedrooms' => $property->bedrooms,
                        'bathrooms' => $property->bathrooms,
                        'area' => $property->area,
                        'image' => $property->images->first() ? aws_asset_path($property->images->first()->image) : "",
                    ];
                });
                $data['suggested_apartments'] = $suggested_apartments;
            }
            else
            {
                $data['suggested_apartments'] = [];
            }
        }
        return response()->json(['message' => "Project Details", 'data' => convert_all_elements_to_string($data)], 200);
    }

    public function properties(Request $request)
    {
        $search_text = $request->search_text ?? '';
        $sale_type = $request->sale_type ?? '';
        $property_type = $request->property_type ?? '';
        $bedrooms = $request->bedrooms ?? '';
        $bathrooms = $request->bathrooms ?? '';
        $price_from = $request->price_from ?? '';
        $price_to = $request->price_to ?? '';
        $project_id = $request->project ?? '';
        $location_id = $request->location ?? '';
        $sort = $request->sort ?? 'latest';
        $floor = $request->floor;

        $limit = isset($request->limit) ? (int)$request->limit : 10;
        $page = isset($request->page) ? (int)$request->page : 1;
        $offset = ($page - 1) * $limit;

        $properties = Properties::select('properties.*')->with(['property_type', 'images'])->where(['properties.active' => '1', 'properties.deleted' => 0])->leftjoin('projects','projects.id','properties.project_id');

        if ($sort =="latest") {
            $properties = $properties->orderBy('properties.created_at', 'desc');
        }
        if ($sort == "price_low_to_high") {
            $properties = $properties->orderBy('properties.price', 'asc');
        }
        if ($sort == "price_high_to_low") {
            $properties = $properties->orderBy('properties.price', 'desc');
        }

        if ($sort == "size_low_to_high") {
            $properties = $properties->orderByRaw('CAST(properties.area AS DECIMAL) ASC');
        }
        if ($sort == "size_high_to_low") {
            $properties = $properties->orderByRaw('CAST(properties.area AS DECIMAL) DESC');
        }

        if ($sort == "floor_low_to_high") {
            $properties = $properties->orderByRaw('CAST(properties.floor_no AS DECIMAL) ASC');
        }
        if ($sort == "floor_high_to_low") {
            $properties = $properties->orderByRaw('CAST(properties.floor_no AS DECIMAL) DESC');
        }

        if ($floor) {
            $properties = $properties->whereRaw("CAST(properties.floor_no AS DECIMAL) = $floor");
        }

        if ($search_text) {
            $properties = $properties->whereRaw("(properties.name like '%$search_text%')");
        }
        if ($sale_type) {
            $properties = $properties->whereIn('sale_type', [$sale_type, 3]);
        }
        if ($property_type) {
            $properties = $properties->where('category', $property_type);
        }
        if ($project_id) {
            $properties = $properties->where('project_id', $project_id);
        }
        if ($location_id) {
            $properties = $properties->where('projects.country', $location_id);
        }
        if ($bedrooms) {
            if ($bedrooms == "6+") {
                $properties = $properties->where('bedrooms', '>=', 6);
            } else {
                $properties = $properties->where('bedrooms', $bedrooms);
            }
        }
        if ($bathrooms) {
            if ($bathrooms == "6+") {
                $properties = $properties->where('bathrooms', '>=', 6);
            } else {
                $properties = $properties->where('bathrooms', $bathrooms);
            }
        }
        if ($price_from) {
            $properties = $properties->where('price', '>=', $price_from);
        }
        if ($price_to) {
            $properties = $properties->where('price', '<=', $price_to);
        }
        $totalProperties = $properties->count();
        $properties = $properties->limit($limit)->skip($offset)->get();
        $totalPages = ceil($totalProperties / $limit);
        $hasNextPage = $page < $totalPages;
        $data    = [];
        foreach ($properties as $key => $val) {

            $data[$key]['id']  = $val->id;
            $data[$key]['name']  = $val->name;
            $data[$key]['price']  = moneyFormat($val->price);
            $data[$key]['bedrooms']  = $val->bedrooms;
            $data[$key]['bathrooms']  = $val->bathrooms;
            $data[$key]['location']  = $val->location;
            $data[$key]['location_link']  = $val->location_link;
            $data[$key]['unit_number']  = $val->apartment_no;
            $data[$key]['floor_number']  = $val->floor_no;
            $data[$key]['image']  = $val->images->first() ? aws_asset_path($val->images->first()->image) : '';
            $data[$key]['area']  = $val->area.'m2';
            $data[$key]['property_type']  = $val->property_type->name;

            if($val->sale_type == 1 || $val->sale_type == 3){
                $data[$key]['sale_type']  = __('messages.buy');
            }
            if($val->sale_type == 2 || $val->sale_type == 3){
                $data[$key]['sale_type']  = __('messages.rent');
            }
            $data[$key]['is_fav'] = 0;
            if(Auth::guard('sanctum')->user() && Auth::guard('sanctum')->user()->id){
                if (FavouriteProperty::where(['user_id' => Auth::guard('sanctum')->user()->id, 'property_id' => $val->id])->first()) {
                    $data[$key]['is_fav'] = 1;
                }
            }

        }
        $pagination = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalProperties,
            'has_next_page' => $hasNextPage,
        ];

        return response()->json(['message' => "Properties", 'data' => convert_all_elements_to_string($data), 'pagination' => convert_all_elements_to_string($pagination)], 200);
    }
    public function property_details(Request $request)
    {
        $property = Properties::with(['property_type', 'images', 'amenities'])->where(['id' => $request->id, 'active' => '1', 'deleted' => 0])->first();
        $data    = [];
        if ($property) {

            $data['id']  = $property->id;
            $data['name']  = $property->name;
            $data['price']  = moneyFormat($property->price);
            $data['bedrooms']  = $property->bedrooms;
            $data['bathrooms']  = $property->bathrooms;
            $data['floor_number']  = $property->floor_no;

            $data['gross_area']  = $property->gross_area ? $property->gross_area.'m2' : '';
            $data['net_area']  = $property->area.'m2';
            $data['balcony_size']  = $property->balcony_size;

            $data['description']  = $property->description;
            $data['short_description']  = $property->short_description;
            $data['video_link']  = $property->video_link;
            $data['link_360']  = $property->link_360;
            $data['unit_layout']  = $property->unit_layout;
            $data['floor_plan']  = $property->floor_plan ? aws_asset_path($property->floor_plan) : '';

            $data['location']  = $property->location;
            $data['location_link']  = $property->location_link;
            $data['image'] = $property->images->first() ? aws_asset_path($property->images->first()->image) : '';
            $data['area']  = $property->area.'m2';
            $data['property_type']  = $property->property_type->name;
            $data['images'] = $property->images->pluck('image')->map(fn($image) => aws_asset_path($image))->toArray();

            if($property->sale_type == 1 || $property->sale_type == 3){
                $data['sale_type']  = __('messages.buy');
            }
            if($property->sale_type == 2 || $property->sale_type == 3){
                $data['sale_type']  = __('messages.rent');
            }
            $data['amenities'] = $property->amenities->map(function($amt) {
                return [
                    'name' => $amt->amnety->name,
                    'icon' => $amt->amnety->icon,
                    'icon_image' => $amt->amnety->icon_image ?  aws_asset_path($amt->amnety->icon_image) : '',
                ];
            });
            $data['is_fav'] = 0;

            if(Auth::guard('sanctum')->user() && Auth::guard('sanctum')->user()->id){
                if (FavouriteProperty::where(['user_id' => Auth::guard('sanctum')->user()->id, 'property_id' => $property->id])->first()) {
                    $data['is_fav'] = 1;
                }
            }
            $settings = Settings::find(1);

            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            $total = $property->price + $ser_amt;

            $data['unit_number']  = $property->apartment_no;
            $data['management_fees']  = moneyFormat($ser_amt);
            $data['total']  = moneyFormat($total);

            $data['price_plain']  = $property->price;
            $data['management_fees_plain']  = $ser_amt;
            $data['total_plain']  = $total;




            $cur_month = Carbon::now();
            $cur_month->startOfMonth();
            if(isset($property->project->end_date) && $property->project->end_date){
                $targetDate = Carbon::createFromFormat('Y-m', $property->project->end_date)->endOfMonth();;
                $monthsDifference = $cur_month->diffInMonths($targetDate);
            }else{
                $monthsDifference = $settings->month_count;
            }
            $data['available_months'] = $monthsDifference;

            if($property->sale_type == 1){
                $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
                $total = $property->price + $ser_amt;
                $full_price_calc = $property->price;
                $down_payment = ($settings->advance_perc / 100) * $full_price_calc;
                $pending_amt = $full_price_calc - $down_payment;
                $data['down_payment_plain']  = $down_payment;

                $payableEmiAmount = $pending_amt;
                $monthCount = $monthsDifference;//$settings->month_count;
                $monthlyPayment = $payableEmiAmount / $monthCount;
                $percentageRate = (100 - $settings->advance_perc) / $monthCount;

                $months = [];
                $totalPercentage = $settings->advance_perc;
                $remainingAmount = $payableEmiAmount;
                $months[0]['month'] = date('M-y');
                $months[0]['type'] = __('messages.down_payment');
                $months[0]['payment'] = moneyFormat($down_payment);
                $months[0]['total_percentage'] = $settings->advance_perc.'%';
                $months[1]['month'] = date('M-y');
                $months[1]['type'] = __('messages.management_fees');
                $months[1]['payment'] = moneyFormat($ser_amt);
                $months[1]['total_percentage'] = '';
                for ($i = 0; $i < $monthCount; $i++) {
                    $remainingAmount -= $monthlyPayment;
                    $totalPercentage += $percentageRate;
                    $month = $cur_month->addMonth()->format('M-y');
                    $months[$i+2]['month'] = $month;
                    $months[$i+2]['type'] = $this->getOrdinalSuffix($i + 1). ' '.__('messages.installment');
                    $months[$i+2]['payment'] = moneyFormat($monthlyPayment);
                    $months[$i+2]['total_percentage'] = round($totalPercentage, 2).'%';
                }
                $data['payment_plan'] = $months;
            }else{
                $data['payment_plan'] = [];
            }

        }

        return response()->json(['message' => "Property Details", 'data' => convert_all_elements_to_string($data)], 200);
    }
    public function getOrdinalSuffix($number)
    {
        if (in_array($number % 100, [11, 12, 13])) {
            return $number . 'th';
        }

        switch ($number % 10) {
            case 1:return $number . 'st';
            case 2:return $number . 'nd';
            case 3:return $number . 'rd';
            default:return $number . 'th';
        }
    }
    public function my_profile()
    {
        $user = Auth::user();
        $data['name'] = $user->name;
        $data['user_type'] = $user->role;
        $data['phone'] = $user->phone;
        $data['email'] = $user->email;
        $data['license'] = $user->license ? aws_asset_path($user->license) : '';
        $data['address'] = $user->address;
        $data['city'] = $user->city;
        $data['state'] = $user->state;
        $data['postal_code'] = $user->postal_code;
        $data['country_id'] = $user->country_id;
        $data['country_name'] = $user->country->name ?? '';
        $data['image'] = $user->image ? aws_asset_path($user->image) : asset('').'front-assets/images/avatar/profile-icon.png';

        return response()->json(['message' => "My Profile", 'data' => convert_all_elements_to_string($data)], 200);
    }
    public function countries()
    {
        $countries = Country::orderBy('name', 'asc')->select('name','name_ar', 'code_iso')->get();
        $data = $countries->map(function($country) {
            return [
                'name' => $country->name,
                'id' => $country->code_iso,
            ];
        })->toArray();

        return response()->json([
            'message' => 'Countries',
            'data' => convert_all_elements_to_string($data)
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_type = Auth::user()->role;
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state'=>'required',
            'postal_code'=>'required',
            'country_id'=>'required',
        ];
        $messages = [
            'phone.required' => __('messages.phone_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.valid_email'),
            'name.required' => __('messages.name_required'),
            'address.required' => __('messages.enter_address'),
            'city.required' => __('messages.enter_city'),
            'postal_code.required' => __('messages.enter_postal_code'),
            'country_id.required' => __('messages.select_country'),
            'state.required' => __('messages.enter_state'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);
        }

        if (User::where('email', $request->email)->where('id', '!=', $user_id)->first() != null) {
            return response()->json([
                'message' => $request->email . " ".__('messages.already_added'),
            ], 401);
        }


        $ins = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,

            'country_id' => $request->country_id,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];
        if ($request->file("image")) {
            $response = image_upload($request, 'profile', 'image');
            if ($response['status']) {
                $ins['image'] = $response['link'];
            }
        }
        if ($user_type == 3 || $user_type == 4) {
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

        if ($user_type == 4) {
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
        if ($request->password) {
            $ins['password'] = bcrypt($request->password);
        }

        if (User::where('id', $user_id)->update($ins)) {
            return response()->json([
                'message' => __('messages.successfully_updated'),
                'data' => convert_all_elements_to_string([]),
            ], 200);


        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong'),
            ], 401);
        }
    }
    public function fav_unfav_property(Request $request)
    {
        if ($fav = FavouriteProperty::where(['user_id' => Auth::user()->id, 'property_id' => $request->prop_id])->first()) {
            $fav->delete();
            return response()->json([
                'message' => __('messages.removed_from_favourites'),
                'type' => 'rem',
                'data' => convert_all_elements_to_string([]),
            ], 200);
        } else {
            $ins['user_id'] = Auth::user()->id;
            $ins['property_id'] = $request->prop_id;
            $ins['created_at'] = gmdate('Y-m-d H:i:s');
            FavouriteProperty::create($ins);
            return response()->json([
                'message' => __('messages.added_to_favourites'),
                'type' => 'add',
                'data' => convert_all_elements_to_string([]),
            ], 200);
        }
    }
    public function favorite()
    {
        $properties = Properties::select('properties.*')->where(['properties.active' => '1', 'properties.deleted' => 0, 'favourite_properties.user_id' => Auth::user()->id])->rightjoin('favourite_properties', 'favourite_properties.property_id', 'properties.id')->orderBy('favourite_properties.created_at', 'desc')->get();
        $data = $properties->map(function($val) {
            return [
                'name' => $val->name,
                'id' => $val->id,
                'price' => moneyFormat($val->price),
                'image' => $val->images->first() ? aws_asset_path($val->images->first()->image) : '',
            ];
        });
        return response()->json([
            'message' => 'Properties',
            'data' => convert_all_elements_to_string($data),
        ], 200);
    }

    public function my_bookings()
    {
        $bookings = Properties::with('project')->select('properties.*','bookings.created_at as booking_date')->where(['bookings.user_id' => Auth::user()->id,'type'=>'Down Payment'])->rightjoin('bookings', 'bookings.property_id', 'properties.id')->orderBy('bookings.created_at', 'desc')->get();
        $settings = Settings::find(1);
        $cur_month = Carbon::now();
        $cur_month->startOfMonth();
        $data = [];
        foreach($bookings as $key=>$val){
            $ser_amt = ($settings->service_charge_perc / 100) * $val->price;
            $total = $val->price + $ser_amt;

            $data[$key]['id']  = $val->id;
            $data[$key]['name']  = $val->name;
            $data[$key]['price']  = moneyFormat($val->price);
            $data[$key]['floor_number']  = $val->floor_no;

            $data[$key]['gross_area']  = $val->gross_area ? $val->gross_area.'m2' : '';
            $data[$key]['net_area']  = $val->area.'m2';
            $data[$key]['balcony_size']  = $val->balcony_size;

            $data[$key]['unit_layout']  = $val->unit_layout;
            $data[$key]['floor_plan']  = $val->floor_plan ? aws_asset_path($val->floor_plan) : '';

            $data[$key]['image'] = $val->images->first() ? aws_asset_path($val->images->first()->image) : '';
            $data[$key]['area']  = $val->area.'m2';
            $data[$key]['property_type']  = $val->property_type->name;

            if($val->sale_type == 1 || $val->sale_type == 3){
                $data[$key]['sale_type']  = __('messages.buy');
            }
            if($val->sale_type == 2 || $val->sale_type == 3){
                $data[$key]['sale_type']  = __('messages.rent');
            }


            $data[$key]['unit_number']  = $val->apartment_no;
            $data[$key]['management_fees']  = moneyFormat($ser_amt);
            $data[$key]['total']  = moneyFormat($total);


            $paid_mount = Booking::where(['bookings.user_id' => Auth::user()->id,'property_id'=>$val->id])->sum('amount');

            $data[$key]['paid_mount'] = moneyFormat($paid_mount);
            $data[$key]['remaining_mount'] = moneyFormat($total-$paid_mount);

            $down_payment = ($settings->advance_perc / 100) * $total;
            $pending_amt = $total - $down_payment;
            if($val->sale_type == 1){
                if(isset($val->project->end_date) && $val->project->end_date){
                    $targetDate = Carbon::createFromFormat('Y-m', $val->project->end_date)->endOfMonth();;
                    $monthsDifference = $cur_month->diffInMonths($targetDate);
                }else{
                    $monthsDifference = $settings->month_count;
                }


                $payableEmiAmount = $pending_amt;
                $monthCount = $monthsDifference;//$settings->month_count;
                $monthlyPayment = $payableEmiAmount / $monthCount;
                $percentageRate = (100 - $settings->advance_perc) / $monthCount;

                $months = [];
                $totalPercentage = $settings->advance_perc;
                $remainingAmount = $payableEmiAmount;
                $months[0]['month'] = date('M-y');
                $months[0]['type'] = __('messages.down_payment');
                $months[0]['payment'] = moneyFormat($down_payment);
                $months[0]['total_percentage'] = $settings->advance_perc.'%';
                for ($i = 1; $i <= $monthCount; $i++) {
                    $remainingAmount -= $monthlyPayment;
                    $totalPercentage += $percentageRate;
                    $month = $cur_month->addMonth()->format('M-y');
                    $months[$i]['month'] = $month;
                    $months[$i]['type'] = $this->getOrdinalSuffix($i + 1). ' '.__('messages.installment');
                    $months[$i]['payment'] = moneyFormat($monthlyPayment);
                    $months[$i]['total_percentage'] = round($totalPercentage, 2).'%';
                }
                $data[$key]['payment_plan'] = $months;
            }else{
                $data[$key]['payment_plan'] = [];
            }



        }
        return response()->json(['message' => "Bookings", 'data' => convert_all_elements_to_string($data)], 200);
    }
    public function project_countries()
    {
        $countries = ProjectCountry::select('id', 'name','name_ar')->where(['active' => '1', 'deleted' => 0])->orderBy('created_at', 'desc')->get();
        $data = $countries->map(function($country) {
            return [
                'name' => $country->name,
                'id' => $country->id,
            ];
        })->toArray();

        return response()->json([
            'message' => 'Project Countries',
            'data' => convert_all_elements_to_string($data)
        ], 200);
    }
    public function property_types()
    {
        $property_types = Categories::where(['deleted' => 0])->orderBy('name', 'asc')->get();
        $data = $property_types->map(function($prop) {
            return [
                'name' => $prop->name,
                'id' => $prop->id,
            ];
        })->toArray();

        return response()->json([
            'message' => 'Property Pypes',
            'data' => convert_all_elements_to_string($data)
        ], 200);
    }
    public function save_contact_us(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',

        ];
        $messages = [
            'phone.required' => __('messages.phone_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.valid_email'),
            'name.required' => __('messages.name_required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return response()->json([
                'error' => $errors,
            ], 403);
        }

        $ins = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ];

        if (ContactUsModel::insert($ins)) {
            return response()->json([
                'message' => __('messages.successfully_submitted_contact_soon'),
                'data' => convert_all_elements_to_string([]),
            ], 200);


        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong'),
            ], 401);
        }
    }
    public function book_now(Properties $property,Request $request)
    {
        if($request->type=="book"){
            $property = Properties::find($request->prop_id);
            $with_management_fee = $request->with_management_fee;
            $settings = Settings::find(1);

            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            $total = $property->price + $ser_amt;
            if($with_management_fee){
                $down_payment = (($settings->advance_perc+$settings->service_charge_perc) / 100) * $property->price;
            }else{
                $down_payment = ($settings->advance_perc/100) * $property->price;
            }

            $amount_to_pay = $down_payment;
            // $amount_to_pay = 0.01;
            $pending_amt = $total - $amount_to_pay;

            $gatewayId = "015995941";
            $secretKey = "LRhchdhRxSGUxzt5";
            $amount = number_format((float) $amount_to_pay, 2, '.', '');
            $referenceId = $this->generateReferenceId();
            $hashable_string = "gatewayId=" . $gatewayId . ",amount=" . $amount . ",referenceId=" . $referenceId;
            $signature = base64_encode(hash_hmac('sha256', $hashable_string, $secretKey, true));
            $returnUrl = url('api/v1/qib_payment_status');

            $temp['user_id'] = Auth::user()->id;
            $temp['property_id'] = $property->id;
            $temp['payment_ref_id'] = $referenceId;
            $temp['amount'] = $amount_to_pay;
            $temp['with_management_fee'] = $with_management_fee;
            $temp['pending_amt'] = $pending_amt;

            TempBooking::insert($temp);



            $redirect = url('qib');

            $data['signature'] = $signature;
            $data['gatewayId'] = $gatewayId;
            $data['referenceId'] = $referenceId;
            $data['hashable_string'] = $hashable_string;
            $data['secretKey'] = $secretKey;
            $data['amount'] = $amount;
            $data['returnUrl'] = $returnUrl;
            $data['redirect'] = $redirect;
            $data['type'] = "book";

            $uid                    = $this->uniqidReal();
            $paymentData            = new PaymentData();
            $paymentData->id        = $uid;
            $paymentData->user_id   = Auth::user()->id;
            $paymentData->payment_mode = "QIB";
            $paymentData->data      = json_encode($data);
            $paymentData->save();


            $status = 200;
            $message = 'Redirecting to payment page';
            return response()->json(['message' => $message,'data'=>[], 'redirect' => url('api/v1/qib-init/'. $uid)], $status);

        }else{
            $page_heading = "Reserve Now";
            $amount_to_pay =  10000;
            $gatewayId = "015995941";
            $secretKey = "LRhchdhRxSGUxzt5";
            $amount = number_format((float) $amount_to_pay, 2, '.', '');
            $referenceId = $this->generateReferenceId();
            $hashable_string = "gatewayId=" . $gatewayId . ",amount=" . $amount . ",referenceId=" . $referenceId;
            $signature = base64_encode(hash_hmac('sha256', $hashable_string, $secretKey, true));
            $returnUrl = url('qib_reserve_payment_status');

            $temp['user_id'] = Auth::user()->id;
            $temp['property_id'] = $property->id;
            $temp['payment_ref_id'] = $referenceId;
            $temp['amount'] = $amount_to_pay;
            TempReservation::insert($temp);
            return view('front_end.qib', compact('gatewayId', 'secretKey', 'amount', 'referenceId', 'hashable_string', 'signature', 'returnUrl'));
        }
    }
    public function qibInit($uid)
    {


        $pd = PaymentData::where('id', $uid)->first();
        $data = json_decode($pd->data);
        $user_id = $pd->user_id;
        $user = User::find($user_id);
        $signature = $data->signature;
        $gatewayId = $data->gatewayId;
        $referenceId = $data->referenceId;
        $amount = $data->amount;
        $returnUrl = $data->returnUrl;
        $country = Country::where("code_iso",$user->country_id)->first();
        $country_id = $country->code??"QA";
        return view('front_end.qib_app', compact('signature', 'gatewayId', 'referenceId', 'amount', 'returnUrl', 'user','country_id'));
    }
    public function qib_payment_status(Request $request)
    {
        if ($request->status == "success") {
            $referenceId = $request->referenceId;
            $temp_booking = TempBooking::where(['payment_ref_id' => $referenceId])->first();
            $user_id = $temp_booking->user_id;
            $temp_id = $user_id . uniqid() . time();
            $booking = new Booking();
            $booking->user_id = $user_id;
            $booking->property_id = $temp_booking->property_id;
            $booking->payment_ref_id = $referenceId;
            $booking->amount = $temp_booking->amount;
            $booking->type = "Down Payment";
            $booking->created_at = gmdate('Y-m-d H:i:s');
            $booking->payment_return = json_encode($request->all());
            $booking->payment_mode = "QIB";
            $booking->invoice_id = $temp_id;
            $booking->with_management_fee = $temp_booking->with_management_fee;
            $booking->pending_amt = $temp_booking->pending_amt;

            $booking->save();

            $booking->booking_no = 'PROP-' . date(date('Ymd', strtotime($booking->created_at))) . $booking->id;
            $booking->save();
            $temp_booking->delete();
            return response()->json(['message' => __('messages.booking_successfully_completed'),'data'=>[]], 200);
        } else {
            return response()->json(['error' => $request->reason], 401);
        }
    }
    public function generateReferenceId()
    {
        $length = rand(10, 20);
        // $characters = '0123456789';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $referenceId = '';
        for ($i = 0; $i < 19; $i++) {
            $referenceId .= $characters[rand(0, strlen($characters) - 1)];
        }
        return strtoupper($referenceId);
    }
    protected function uniqidReal($lenght = 13)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }


}
