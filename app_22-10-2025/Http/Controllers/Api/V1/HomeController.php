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

        if ($sort =="featured") {
            $properties = $properties->orderBy('properties.is_featured', 'desc')->orderBy('properties.order', 'asc');
        }
//        if ($sort =="latest") {
//            $properties = $properties->orderBy('properties.created_at', 'desc');
//        }
        if ($sort =="latest") {
            $properties = $properties->orderBy('properties.order', 'asc');
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
            $data[$key]['is_featured']  = $val->is_featured;
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
            $data['is_featured']  = $property->is_featured;

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
        $data['id_card'] = $user->id_card ? aws_asset_path($user->id_card) : '';
        $data['cr'] = $user->cr ? aws_asset_path($user->cr) : '';
        $data['authorized_signatory'] = $user->authorized_signatory ? aws_asset_path($user->authorized_signatory) : '';
        $data['professional_practice_certificate'] = $user->professional_practice_certificate ? aws_asset_path($user->professional_practice_certificate) : '';
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
            $data[$key]['is_featured']  = $val->is_featured;

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

    public function get_agency_details(Request $request)
    {
        $user = Auth::user();

        // Check if user is an agency (role 4)
        if ($user->role != 4) {
            return response()->json([
                'message' => 'Access denied. Only agencies can access this endpoint.',
            ], 403);
        }

        // Get agency profile details
        $agency_profile = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
            'state' => $user->state,
            'postal_code' => $user->postal_code,
            'country_id' => $user->country_id,
            'country_name' => $user->country->name ?? '',
            'image' => $user->image ? aws_asset_path($user->image) : asset('').'front-assets/images/avatar/profile-icon.png',
            'license' => $user->license ? aws_asset_path($user->license) : '',
            'id_card' => $user->id_card ? aws_asset_path($user->id_card) : '',
            'cr' => $user->cr ? aws_asset_path($user->cr) : '',
            'real_estate_license' => $user->real_estate_license ? aws_asset_path($user->real_estate_license) : '',
            'professional_practice_certificate' => $user->professional_practice_certificate ? aws_asset_path($user->professional_practice_certificate) : '',
            'created_at' => $user->created_at ? $user->created_at->toISOString() : '',
            'updated_at' => $user->updated_at ? $user->updated_at->toISOString() : '',
        ];

        // Get list of employees (agents) related to this agency
        $employees = User::where('agency_id', $user->id)
            ->where('role', 3) // Agent role
            ->select('id', 'name', 'email', 'phone', 'image', 'license', 'id_card', 'created_at', 'active')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($agent) {
                return [
                    'id' => $agent->id,
                    'name' => $agent->name,
                    'email' => $agent->email,
                    'phone' => $agent->phone,
                    'image' => $agent->image ? aws_asset_path($agent->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                    'license' => $agent->license ? aws_asset_path($agent->license) : '',
                    'id_card' => $agent->id_card ? aws_asset_path($agent->id_card) : '',
                    'created_at' => $agent->created_at ? $agent->created_at->toISOString() : '',
                    'active' => $agent->active,
                ];
            });

        // Get agent IDs for this agency
        $agentIds = $employees->pluck('id')->toArray();

        // Get visit schedules for agents in this agency
        $visit_schedules = \App\Models\VisiteSchedule::with(['agent', 'project'])
            ->whereIn('agent_id', $agentIds)
            ->orderBy('visit_time', 'desc')
            ->get()
            ->map(function($visit) {
                return [
                    'id' => $visit->id,
                    'client_name' => $visit->client_name,
                    'client_email_address' => $visit->client_email_address,
                    'client_phone_number' => $visit->client_phone_number,
                    'client_id' =>  $visit->client_id ? aws_asset_path($visit->client_id) : '',
                    'visit_time' => $visit->visit_time ? $visit->visit_time->toISOString() : '',
                    'notes' => $visit->notes,
                    'visit_purpose' => $visit->visit_purpose,
                    'agent' => [
                        'id' => $visit->agent->id,
                        'name' => $visit->agent->name,
                        'email' => $visit->agent->email,
                    ],
                    'project' => [
                        'id' => $visit->project->id,
                        'name' => $visit->project->name,
                    ],
                    'unit_type' => $visit->unit_type,
                    'created_at' => $visit->created_at ? $visit->created_at->toISOString() : '',
                ];
            });

        // Get reservations for agents in this agency
        $reservations = \App\Models\Reservation::with(['agent', 'property.project', 'property.property_type'])
            ->whereIn('agent_id', $agentIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($reservation) {
                return [
                    'id' => $reservation->id,
                    'status' => $reservation->status,
                    'commission' => $reservation->commission,
                    'agent' => [
                        'id' => $reservation->agent->id,
                        'name' => $reservation->agent->name,
                        'email' => $reservation->agent->email,
                    ],
                    'property' => [
                        'id' => $reservation->property->id,
                        'name' => $reservation->property->name,
                        'price' => $reservation->property->price,
                        'apartment_no' => $reservation->property->apartment_no,
                        'area' => $reservation->property->area,
                        'project' => [
                            'id' => $reservation->property->project->id,
                            'name' => $reservation->property->project->name,
                        ],
                        'property_type' => [
                            'id' => $reservation->property->property_type->id,
                            'name' => $reservation->property->property_type->name,
                        ],
                    ],
                    'created_at' => $reservation->created_at ? $reservation->created_at->toISOString() : '',
                ];
            });

        $data = [
            'agency_profile' => convert_all_elements_to_string($agency_profile),
            'employees' => convert_all_elements_to_string($employees),
            'visit_schedules' => convert_all_elements_to_string($visit_schedules),
            'reservations' => convert_all_elements_to_string($reservations),
            'summary' => convert_all_elements_to_string([
                'total_employees' => $employees->count(),
                'total_visit_schedules' => $visit_schedules->count(),
                'total_reservations' => $reservations->count(),
                'total_reservations' => $reservations->count(),
            ])
        ];

        return response()->json([
            'message' => 'Agency Details Retrieved Successfully',
            'data' => $data
        ], 200);
    }

    public function get_reservation_by_id(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated.',
                ], 401);
            }

            // Validate reservation ID
            $rules = [
                'reservation_id' => 'required|integer|exists:reservations,id',
            ];
            $messages = [
                'reservation_id.required' => 'Reservation ID is required',
                'reservation_id.integer' => 'Reservation ID must be a valid integer',
                'reservation_id.exists' => 'Reservation not found',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $errors = $validator->messages();
                return response()->json([
                    'error' => $errors,
                ], 403);
            }

            $reservationId = $request->reservation_id;

            // Get reservation with relationships
            $reservation = \App\Models\Reservation::with([
                'agent',
                'property.project',
                'property.property_type',
                'property.images'
            ])->find($reservationId);

            if (!$reservation) {
                return response()->json([
                    'message' => 'Reservation not found',
                ], 404);
            }

            // Check access permissions based on user role
            if ($user->role == 4) {
                // Agency: Check if the reservation belongs to any of their agents
                $agentIds = User::where('agency_id', $user->id)
                    ->where('role', 3)
                    ->pluck('id')
                    ->toArray();

                if (!in_array($reservation->agent_id, $agentIds)) {
                    return response()->json([
                        'message' => 'Access denied. This reservation does not belong to your agency.',
                    ], 403);
                }
            } elseif ($user->role == 3) {
                // Agent: Check if the reservation belongs to them
                if ($reservation->agent_id != $user->id) {
                    return response()->json([
                        'message' => 'Access denied. This reservation does not belong to you.',
                    ], 403);
                }
            } else {
                // Other roles (customers, etc.)
                return response()->json([
                    'message' => 'Access denied. Only agencies and agents can access this endpoint.',
                ], 403);
            }

            // Format reservation data
            $reservationData = [
                'id' => $reservation->id,
                'status' => $reservation->status,
                'commission' => $reservation->commission,
                'created_at' => $reservation->created_at ? $reservation->created_at->toISOString() : '',
                'updated_at' => $reservation->updated_at ? $reservation->updated_at->toISOString() : '',
                'agent' => [
                    'id' => $reservation->agent->id,
                    'name' => $reservation->agent->name,
                    'email' => $reservation->agent->email,
                    'phone' => $reservation->agent->phone,
                    'image' => $reservation->agent->image ? aws_asset_path($reservation->agent->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                ],
                'property' => [
                    'id' => $reservation->property->id,
                    'name' => $reservation->property->name,
                    'price' => $reservation->property->price,
                    'apartment_no' => $reservation->property->apartment_no,
                    'area' => $reservation->property->area,
                    'bedrooms' => $reservation->property->bedrooms,
                    'bathrooms' => $reservation->property->bathrooms,
                    'floor_no' => $reservation->property->floor_no,
                    'description' => $reservation->property->description,
                    'short_description' => $reservation->property->short_description,
                    'location' => $reservation->property->location,
                    'location_link' => $reservation->property->location_link,
                    'video_link' => $reservation->property->video_link,
                    'link_360' => $reservation->property->link_360,
                    'unit_layout' => $reservation->property->unit_layout,
                    'floor_plan' => $reservation->property->floor_plan ? aws_asset_path($reservation->property->floor_plan) : '',
                    'gross_area' => $reservation->property->gross_area,
                    'balcony_size' => $reservation->property->balcony_size,
                    'sale_type' => $reservation->property->sale_type,
                    'is_featured' => $reservation->property->is_featured,
                    'images' => $reservation->property->images->map(function($image) {
                        return [
                            'id' => $image->id,
                            'image' => aws_asset_path($image->image),
                            'type' => $image->type,
                            'order' => $image->order,
                        ];
                    }),
                    'project' => [
                        'id' => $reservation->property->project->id,
                        'name' => $reservation->property->project->name,
                        'location' => $reservation->property->project->location,
                        'description' => $reservation->property->project->description,
                        'image' => $reservation->property->project->app_image ? aws_asset_path($reservation->property->project->app_image) : ($reservation->property->project->image ? aws_asset_path($reservation->property->project->image) : ''),
                    ],
                    'property_type' => [
                        'id' => $reservation->property->property_type->id,
                        'name' => $reservation->property->property_type->name,
                    ],
                ],
            ];

            // Add sale type label
            if($reservation->property->sale_type == 1 || $reservation->property->sale_type == 3){
                $reservationData['property']['sale_type_label'] = __('messages.buy');
            }
            if($reservation->property->sale_type == 2 || $reservation->property->sale_type == 3){
                $reservationData['property']['sale_type_label'] = __('messages.rent');
            }

            return response()->json([
                'message' => 'Reservation Details Retrieved Successfully',
                'data' => convert_all_elements_to_string($reservationData)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function get_reservations_list(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated.',
                ], 401);
            }

            // Check if user is agency or agent
            if ($user->role != 4 && $user->role != 3) {
                return response()->json([
                    'message' => 'Access denied. Only agencies and agents can access this endpoint.',
                ], 403);
            }

            // Pagination parameters
            $limit = isset($request->limit) ? (int)$request->limit : 10;
            $page = isset($request->page) ? (int)$request->page : 1;
            $offset = ($page - 1) * $limit;

            // Status filter
            $status = $request->status ?? '';

            // Build query based on user role
            $query = \App\Models\Reservation::with([
                'agent',
                'property.project',
                'property.property_type',
                'property.images'
            ]);

            if ($user->role == 4) {
                // Agency: Get reservations from all their agents
                $agentIds = User::where('agency_id', $user->id)
                    ->where('role', 3)
                    ->pluck('id')
                    ->toArray();

                if (empty($agentIds)) {
                    // No agents under this agency
                    $reservations = collect();
                    $totalReservations = 0;
                } else {
                    $query->whereIn('agent_id', $agentIds);
                }
            } else {
                // Agent: Get only their own reservations
                $query->where('agent_id', $user->id);
            }

            // Apply status filter if provided
            if ($status) {
                $query->where('status', $status);
            }

            // Get total count for pagination
            $totalReservations = $query->count();
            $totalPages = ceil($totalReservations / $limit);
            $hasNextPage = $page < $totalPages;

            // Get reservations with pagination
            $reservations = $query->orderBy('created_at', 'desc')
                ->limit($limit)
                ->skip($offset)
                ->get()
                ->filter(function($reservation) {
                    // Only include reservations with valid relationships
                    return $reservation->property && $reservation->agent;
                })
                ->map(function($reservation) {
                    return [
                        'id' => $reservation->id,
                        'status' => $reservation->status,
                        'commission' => $reservation->commission,
                        'created_at' => $reservation->created_at ? $reservation->created_at->toISOString() : '',
                        'updated_at' => $reservation->updated_at ? $reservation->updated_at->toISOString() : '',
                        'agent' => [
                            'id' => $reservation->agent->id ?? '',
                            'name' => $reservation->agent->name ?? '',
                            'email' => $reservation->agent->email ?? '',
                            'phone' => $reservation->agent->phone ?? '',
                            'image' => $reservation->agent->image ? aws_asset_path($reservation->agent->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                        ],
                        'property' => [
                            'id' => $reservation->property->id ?? '',
                            'name' => $reservation->property->name ?? '',
                            'price' => $reservation->property->price ?? 0,
                            'apartment_no' => $reservation->property->apartment_no ?? '',
                            'area' => $reservation->property->area ?? '',
                            'bedrooms' => $reservation->property->bedrooms ?? '',
                            'bathrooms' => $reservation->property->bathrooms ?? '',
                            'floor_no' => $reservation->property->floor_no ?? '',
                            'location' => $reservation->property->location ?? '',
                            'sale_type' => $reservation->property->sale_type ?? '',
                            'is_featured' => $reservation->property->is_featured ?? '',
                            'image' => ($reservation->property->images && $reservation->property->images->first()) ? aws_asset_path($reservation->property->images->first()->image) : '',
                            'project' => [
                                'id' => $reservation->property->project->id ?? '',
                                'name' => $reservation->property->project->name ?? '',
                                'location' => $reservation->property->project->location ?? '',
                            ],
                            'property_type' => [
                                'id' => $reservation->property->property_type->id ?? '',
                                'name' => $reservation->property->property_type->name ?? '',
                            ],
                        ],
                    ];
                });

            // Add sale type labels
            $reservations = $reservations->map(function($reservation) {
                if(isset($reservation['property']['sale_type'])) {
                    if($reservation['property']['sale_type'] == 1 || $reservation['property']['sale_type'] == 3){
                        $reservation['property']['sale_type_label'] = __('messages.buy');
                    }
                    if($reservation['property']['sale_type'] == 2 || $reservation['property']['sale_type'] == 3){
                        $reservation['property']['sale_type_label'] = __('messages.rent');
                    }
                }
                return $reservation;
            });

            // Calculate summary statistics
            $summaryQuery = \App\Models\Reservation::query();
            if ($user->role == 4) {
                $agentIds = User::where('agency_id', $user->id)
                    ->where('role', 3)
                    ->pluck('id')
                    ->toArray();
                if (!empty($agentIds)) {
                    $summaryQuery->whereIn('agent_id', $agentIds);
                }
            } else {
                $summaryQuery->where('agent_id', $user->id);
            }

            $summary = [
                'total_reservations' => $summaryQuery->count(),
                'total_commission' => $summaryQuery->sum('commission'),
                'status_breakdown' => [
                    'waiting_approval' => $summaryQuery->clone()->where('status', 'waitingApproval')->count(),
                    'reserved' => $summaryQuery->clone()->where('status', 'Reserved')->count(),
                    'preparing_document' => $summaryQuery->clone()->where('status', 'PreparingDocument')->count(),
                    'closed_deal' => $summaryQuery->clone()->where('status', 'ClosedDeal')->count(),
                ]
            ];

            $pagination = [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalReservations,
                'has_next_page' => $hasNextPage,
                'limit' => $limit,
            ];

            return response()->json([
                'message' => 'Reservations List Retrieved Successfully',
                'data' => convert_all_elements_to_string($reservations),
                'summary' => convert_all_elements_to_string($summary),
                'pagination' => convert_all_elements_to_string($pagination)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function get_visit_schedules_list(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated.',
                ], 401);
            }

            // Check if user is agency or agent
            if ($user->role != 4 && $user->role != 3) {
                return response()->json([
                    'message' => 'Access denied. Only agencies and agents can access this endpoint.',
                ], 403);
            }

            // Pagination parameters
            $limit = isset($request->limit) ? (int)$request->limit : 10;
            $page = isset($request->page) ? (int)$request->page : 1;
            $offset = ($page - 1) * $limit;

            // Build query based on user role
            $query = \App\Models\VisiteSchedule::with([
                'agent',
                'project'
            ]);

            if ($user->role == 4) {
                // Agency: Get visit schedules from all their agents
                $agentIds = User::where('agency_id', $user->id)
                    ->where('role', 3)
                    ->pluck('id')
                    ->toArray();

                if (empty($agentIds)) {
                    // No agents under this agency
                    $visitSchedules = collect();
                    $totalVisitSchedules = 0;
                } else {
                    $query->whereIn('agent_id', $agentIds);
                }
            } else {
                // Agent: Get only their own visit schedules
                $query->where('agent_id', $user->id);
            }

            // Get total count for pagination
            $totalVisitSchedules = $query->count();
            $totalPages = ceil($totalVisitSchedules / $limit);
            $hasNextPage = $page < $totalPages;

            // Get visit schedules with pagination
            $visitSchedules = $query->orderBy('visit_time', 'desc')
                ->limit($limit)
                ->skip($offset)
                ->get()
                ->filter(function($visitSchedule) {
                    // Only include visit schedules with valid relationships
                    return $visitSchedule->project && $visitSchedule->agent;
                })
                ->map(function($visitSchedule) {
                    return [
                        'id' => $visitSchedule->id,
                        'client_name' => $visitSchedule->client_name ?? '',
                        'client_email_address' => $visitSchedule->client_email_address ?? '',
                        'client_phone_number' => $visitSchedule->client_phone_number ?? '',
                        'client_id' => $visitSchedule->client_id ? aws_asset_path($visitSchedule->client_id) : '',
                        'visit_time' => $visitSchedule->visit_time ? $visitSchedule->visit_time->toISOString() : '',
                        'notes' => $visitSchedule->notes ?? '',
                        'visit_purpose' => $visitSchedule->visit_purpose ?? '',
                        'unit_type' => $visitSchedule->unit_type ?? '',
                        'created_at' => $visitSchedule->created_at ? $visitSchedule->created_at->toISOString() : '',
                        'updated_at' => $visitSchedule->updated_at ? $visitSchedule->updated_at->toISOString() : '',
                        'agent' => [
                            'id' => $visitSchedule->agent->id ?? '',
                            'name' => $visitSchedule->agent->name ?? '',
                            'email' => $visitSchedule->agent->email ?? '',
                            'phone' => $visitSchedule->agent->phone ?? '',
                            'image' => $visitSchedule->agent->image ? aws_asset_path($visitSchedule->agent->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                        ],
                        'project' => [
                            'id' => $visitSchedule->project->id ?? '',
                            'name' => $visitSchedule->project->name ?? '',
                            'name_ar' => $visitSchedule->project->name_ar ?? '',
                            'location' => $visitSchedule->project->location ?? '',
                            'location_ar' => $visitSchedule->project->location_ar ?? '',
                        ],
                    ];
                });

            // Calculate summary statistics
            $summaryQuery = \App\Models\VisiteSchedule::query();
            if ($user->role == 4) {
                $agentIds = User::where('agency_id', $user->id)
                    ->where('role', 3)
                    ->pluck('id')
                    ->toArray();
                if (!empty($agentIds)) {
                    $summaryQuery->whereIn('agent_id', $agentIds);
                }
            } else {
                $summaryQuery->where('agent_id', $user->id);
            }

            $summary = [
                'total_visit_schedules' => $summaryQuery->count()
            ];

            $pagination = [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalVisitSchedules,
                'has_next_page' => $hasNextPage,
                'limit' => $limit,
            ];

            return response()->json([
                'message' => 'Visit Schedules List Retrieved Successfully',
                'data' => convert_all_elements_to_string($visitSchedules),
                'summary' => convert_all_elements_to_string($summary),
                'pagination' => convert_all_elements_to_string($pagination)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function get_visit_schedule_by_id(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated.',
                ], 401);
            }

            // Validate visit schedule ID
            $rules = [
                'visit_schedule_id' => 'required|integer|exists:visite_schedules,id',
            ];
            $messages = [
                'visit_schedule_id.required' => 'Visit Schedule ID is required',
                'visit_schedule_id.integer' => 'Visit Schedule ID must be a valid integer',
                'visit_schedule_id.exists' => 'Visit Schedule not found',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $errors = $validator->messages();
                return response()->json([
                    'error' => $errors,
                ], 403);
            }

            $visitScheduleId = $request->visit_schedule_id;

            // Get visit schedule with relationships
            $visitSchedule = \App\Models\VisiteSchedule::with([
                'agent',
                'project'
            ])->find($visitScheduleId);

            if (!$visitSchedule) {
                return response()->json([
                    'message' => 'Visit Schedule not found',
                ], 404);
            }

            // Check access permissions based on user role
            if ($user->role == 4) {
                // Agency: Check if the visit schedule belongs to any of their agents
                $agentIds = User::where('agency_id', $user->id)
                    ->where('role', 3)
                    ->pluck('id')
                    ->toArray();

                if (!in_array($visitSchedule->agent_id, $agentIds)) {
                    return response()->json([
                        'message' => 'Access denied. This visit schedule does not belong to your agency.',
                    ], 403);
                }
            } elseif ($user->role == 3) {
                // Agent: Check if the visit schedule belongs to them
                if ($visitSchedule->agent_id != $user->id) {
                    return response()->json([
                        'message' => 'Access denied. This visit schedule does not belong to you.',
                    ], 403);
                }
            } else {
                // Other roles (customers, etc.)
                return response()->json([
                    'message' => 'Access denied. Only agencies and agents can access this endpoint.',
                ], 403);
            }

            // Format visit schedule data
            $visitScheduleData = [
                'id' => $visitSchedule->id,
                'client_name' => $visitSchedule->client_name,
                'client_email_address' => $visitSchedule->client_email_address,
                'client_phone_number' => $visitSchedule->client_phone_number,
                'client_id' => $visitSchedule->client_id,
                'visit_time' => $visitSchedule->visit_time ? $visitSchedule->visit_time->toISOString() : '',
                'notes' => $visitSchedule->notes,
                'visit_purpose' => $visitSchedule->visit_purpose,
                'unit_type' => $visitSchedule->unit_type,
                'created_at' => $visitSchedule->created_at ? $visitSchedule->created_at->toISOString() : '',
                'updated_at' => $visitSchedule->updated_at ? $visitSchedule->updated_at->toISOString() : '',
                'agent' => [
                    'id' => $visitSchedule->agent->id,
                    'name' => $visitSchedule->agent->name,
                    'email' => $visitSchedule->agent->email,
                    'phone' => $visitSchedule->agent->phone,
                    'image' => $visitSchedule->agent->image ? aws_asset_path($visitSchedule->agent->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                ],
                'project' => [
                    'id' => $visitSchedule->project ? $visitSchedule->project->id : null,
                    'name' => $visitSchedule->project ? $visitSchedule->project->name : 'N/A',
                    'name_ar' => $visitSchedule->project ? $visitSchedule->project->name_ar : 'N/A',
                    'location' => $visitSchedule->project ? $visitSchedule->project->location : null,
                    'location_ar' => $visitSchedule->project ? $visitSchedule->project->location_ar : null,
                    'description' => $visitSchedule->project ? $visitSchedule->project->description : null,
                    'image' => $visitSchedule->project && $visitSchedule->project->app_image ? aws_asset_path($visitSchedule->project->app_image) : ($visitSchedule->project && $visitSchedule->project->image ? aws_asset_path($visitSchedule->project->image) : ''),
                ],
            ];

            return response()->json([
                'message' => 'Visit Schedule Details Retrieved Successfully',
                'data' => convert_all_elements_to_string($visitScheduleData)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function get_agents_by_agency(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated.',
                ], 401);
            }

            // Check if user is agency or agent
            if ($user->role != 4) {
                return response()->json([
                    'message' => 'Access denied. Only agencies and agents can access this endpoint.',
                ], 403);
            }

            // Pagination parameters
            $limit = isset($request->limit) ? (int)$request->limit : 10;
            $page = isset($request->page) ? (int)$request->page : 1;
            $offset = ($page - 1) * $limit;

            // Status filter
            $status = $request->status ?? '';

            // Determine agency ID based on user role
            $agencyId = null;
            if ($user->role == 4) {
                // Agency: Get agents from their own agency
                $agencyId = $user->id;
            } elseif ($user->role == 3) {
                // Agent: Get agents from their agency
                $agencyId = $user->agency_id;
            }

            if (!$agencyId) {
                return response()->json([
                    'message' => 'No agency found for this user.',
                ], 404);
            }

            // Build query for agents in the same agency
            $query = User::where('agency_id', $agencyId)
                ->where('role', 3) // Only agents
                ->select('id', 'name', 'email', 'phone', 'image', 'license', 'id_card', 'created_at', 'updated_at', 'active', 'agency_id');

            // Apply status filter if provided
            if ($status) {
                $query->where('active', $status === 'active' ? 1 : 0);
            }

            // Get total count for pagination
            $totalAgents = $query->count();
            $totalPages = ceil($totalAgents / $limit);
            $hasNextPage = $page < $totalPages;

            // Get agents with pagination
            $agents = $query->orderBy('created_at', 'desc')
                ->limit($limit)
                ->skip($offset)
                ->get()
                ->map(function($agent) {
                    return [
                        'id' => $agent->id,
                        'name' => $agent->name,
                        'email' => $agent->email,
                        'phone' => $agent->phone,
                        'image' => $agent->image ? aws_asset_path($agent->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                        'license' => $agent->license ? aws_asset_path($agent->license) : '',
                        'id_card' => $agent->id_card ? aws_asset_path($agent->id_card) : '',
                        'active' => $agent->active,
                        'agency_id' => $agent->agency_id,
                        'created_at' => $agent->created_at ? $agent->created_at->toISOString() : '',
                        'updated_at' => $agent->updated_at ? $agent->updated_at->toISOString() : '',
                    ];
                });

            // Get agency information
            $agency = User::where('id', $agencyId)
                ->where('role', 4)
                ->select('id', 'name', 'email', 'phone', 'image', 'address', 'city', 'state', 'postal_code', 'country_id')
                ->first();

            $agencyInfo = null;
            if ($agency) {
                $agencyInfo = [
                    'id' => $agency->id,
                    'name' => $agency->name,
                    'email' => $agency->email,
                    'phone' => $agency->phone,
                    'image' => $agency->image ? aws_asset_path($agency->image) : asset('').'front-assets/images/avatar/profile-icon.png',
                    'address' => $agency->address,
                    'city' => $agency->city,
                    'state' => $agency->state,
                    'postal_code' => $agency->postal_code,
                    'country_id' => $agency->country_id,
                    'country_name' => $agency->country->name ?? '',
                ];
            }

            // Calculate summary statistics
            $summaryQuery = User::where('agency_id', $agencyId)->where('role', 3);
            $summary = [
                'total_agents' => $summaryQuery->count(),
                'active_agents' => $summaryQuery->clone()->where('active', 1)->count(),
                'inactive_agents' => $summaryQuery->clone()->where('active', 0)->count(),
            ];

            $pagination = [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalAgents,
                'has_next_page' => $hasNextPage,
                'limit' => $limit,
            ];

            return response()->json([
                'message' => 'Agents Retrieved Successfully',
                'data' => convert_all_elements_to_string($agents),
                'agency_info' => convert_all_elements_to_string($agencyInfo),
                'summary' => convert_all_elements_to_string($summary),
                'pagination' => convert_all_elements_to_string($pagination)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Add a new visit schedule
     * Only agents (role 3) can create visit schedules
     */
    public function add_visit_schedule(Request $request)
    {
        try {
            $user = Auth::user();

            // Check if user is authenticated
            if (!$user) {
                return response()->json([
                    'message' => 'Unauthorized. Please login first.',
                ], 401);
            }

            // Check if user is an agent (role 3)
            if ($user->role != 3 && $user->role != 4) {
                return response()->json([
                    'message' => 'Access denied. Only agencies and agents can create visit schedules.',
                ], 403);
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'agent_id' => 'nullable|integer|exists:users,id',
                'client_name' => 'required|string|max:255',
                'client_phone_number' => 'required|string|max:20',
                'client_email_address' => 'nullable|email|max:255',
                'client_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'project_id' => 'required|integer|exists:projects,id',
                'unit_type' => 'nullable|string|max:255',
                'visit_date' => 'required|date|after_or_equal:today',
                'visit_time' => 'required|date_format:H:i',
                'notes' => 'nullable|string|max:1000',
                'visit_purpose' => 'required|array|min:1',
                'visit_purpose.*' => 'in:buy,rent',
            ], [
                'agent_id.integer' => 'Agent ID must be a valid integer',
                'agent_id.exists' => 'Selected agent does not exist',
                'client_name.required' => 'Client name is required',
                'client_phone_number.required' => 'Client phone number is required',
                'client_email_address.email' => 'Please provide a valid email address',
                'client_id.file' => 'Client ID must be a file',
                'client_id.mimes' => 'Client ID file must be jpg, jpeg, png, or pdf',
                'client_id.max' => 'Client ID file size must not exceed 5MB',
                'project_id.required' => 'Project selection is required',
                'project_id.exists' => 'Selected project does not exist',
                'visit_date.required' => 'Visit date is required',
                'visit_date.after_or_equal' => 'Visit date cannot be in the past',
                'visit_time.required' => 'Visit time is required',
                'visit_time.date_format' => 'Please provide a valid time format (HH:MM)',
                'visit_purpose.required' => 'Visit purpose is required',
                'visit_purpose.array' => 'Visit purpose must be an array',
                'visit_purpose.min' => 'At least one visit purpose must be selected',
                'visit_purpose.*.in' => 'Visit purpose must be either buy or rent',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Determine which agent ID to use
            $agentId = $user->id; // Default to current user
            
            // If agent_id is provided, validate permissions
            if ($request->agent_id) {
                if ($user->role == 4) {
                    // Agency can assign to any of their agents
                    $agent = User::where('id', $request->agent_id)
                        ->where('role', 3)
                        ->where('agency_id', $user->id)
                        ->first();
                    
                    if (!$agent) {
                        return response()->json([
                            'message' => 'Selected agent does not belong to your agency or does not exist',
                        ], 403);
                    }
                    
                    $agentId = $request->agent_id;
                } else {
                    // Agents cannot assign to other agents
                    return response()->json([
                        'message' => 'Only agencies can assign visit schedules to other agents',
                    ], 403);
                }
            }

            // Check if project exists and is active
            $project = \App\Models\Projects::where('id', $request->project_id)
                ->where('active', 1)
                ->where('deleted', 0)
                ->first();

            if (!$project) {
                return response()->json([
                    'message' => 'Selected project is not available',
                ], 404);
            }

            // Handle client ID file upload
            $clientIdFileName = null;
            if ($request->hasFile('client_id')) {
                $response = image_upload($request, 'visit_schedule', 'client_id');
                if ($response['status']) {
                    $clientIdFileName = $response['link'];
                }
            }

            // Combine date and time
            $visitDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->visit_date . ' ' . $request->visit_time);

            // Check for conflicting visit schedules for the same agent
            $existingVisit = \App\Models\VisiteSchedule::where('agent_id', $agentId)
                ->where('visit_time', $visitDateTime)
                ->first();

            if ($existingVisit) {
                return response()->json([
                    'message' => 'This agent already has a visit scheduled at this time',
                ], 409);
            }

            // Create the visit schedule
            $visitSchedule = \App\Models\VisiteSchedule::create([
                'agent_id' => $agentId,
                'client_name' => $request->client_name,
                'client_phone_number' => $request->client_phone_number,
                'client_email_address' => $request->client_email_address,
                'client_id' => $clientIdFileName,
                'project_id' => $request->project_id,
                'unit_type' => $request->unit_type,
                'visit_time' => $visitDateTime,
                'notes' => $request->notes,
                'visit_purpose' => is_array($request->visit_purpose) ? implode(',', $request->visit_purpose) : $request->visit_purpose,
            ]);

            // Load relationships for response
            $visitSchedule->load(['agent', 'project']);

            // Format the response data
            $responseData = [
                'id' => $visitSchedule->id,
                'client_name' => $visitSchedule->client_name,
                'client_email_address' => $visitSchedule->client_email_address,
                'client_phone_number' => $visitSchedule->client_phone_number,
                'client_id' => $visitSchedule->client_id,
                'client_id_url' => $visitSchedule->client_id ? aws_asset_path($visitSchedule->client_id) : null,
                'visit_time' => $visitSchedule->visit_time ? $visitSchedule->visit_time->toISOString() : '',
                'notes' => $visitSchedule->notes,
                'visit_purpose' => $visitSchedule->visit_purpose,
                'unit_type' => $visitSchedule->unit_type,
                'agent' => [
                    'id' => $visitSchedule->agent->id,
                    'name' => $visitSchedule->agent->name,
                    'email' => $visitSchedule->agent->email,
                ],
                'project' => [
                    'id' => $visitSchedule->project ? $visitSchedule->project->id : null,
                    'name' => $visitSchedule->project ? $visitSchedule->project->name : 'N/A',
                    'name_ar' => $visitSchedule->project ? $visitSchedule->project->name_ar : 'N/A',
                    'location' => $visitSchedule->project ? $visitSchedule->project->location : null,
                ],
                'created_at' => $visitSchedule->created_at ? $visitSchedule->created_at->toISOString() : '',
                'updated_at' => $visitSchedule->updated_at ? $visitSchedule->updated_at->toISOString() : '',
            ];

            return response()->json([
                'message' => 'Visit schedule created successfully',
                'data' => convert_all_elements_to_string($responseData)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating visit schedule: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ], 500);
        }
    }


}
