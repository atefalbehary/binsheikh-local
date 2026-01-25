<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Folder;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\Categories;
use App\Models\ContactUsModel;
use App\Models\Country;
use App\Models\FavouriteProperty;
use App\Models\Photo;
use App\Models\Popup;
use App\Models\Projects;
use App\Models\ProjectCountry;
use App\Models\Properties;
use App\Models\Service;
use App\Models\Settings;
use App\Models\Subscriber;
use App\Models\TempBooking;
use App\Models\TempReservation;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;
use PDF;
use Exception;

class HomeController extends Controller
{
    //
    public $lang = 'en';
    public function __construct()
    {
        $this->lang = session('sys_lang');
        $this->thmx_currency_convert();
    }
    public function checkAvailability(Request $request)
    {
        $post = $request->all();
        $field = $post['field'];
        $value = $post[$field];
        $exclude = $request->exclude;
        $count = User::where($field, $value);
        if ($exclude) {
            $count = $count->where($field, '!=', $exclude);
        }
        $count = $count->get()->count();
        if ($count) {
            dd('');
        } else {
            header("HTTP/1.1 200 Ok");
        }
    }
    public function google_callback(Request $request){
        try {
            $googleUser = Socialite::driver('Google')->stateless()->user();
            if(!$googleUser){
                return redirect('/');
            }
            if ($user = User::where('email', $googleUser->getEmail())->where("deleted", 0)->where('role','!=',1)->first()) {
                $user->name = $googleUser->getName();
                $user->social_type = "google";
                $user->active = 1;
                $user->save();
            } else {
                $user = new User([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'social_type' => "google",
                    'password' => bcrypt(uniqid()),
                    'role' => 2,
                    'active' => 1,
                ]);
                $user->save();
            }
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
    public function facebook_callback(Request $request){
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->redirect();
            if (method_exists($facebookUser, 'getEmail') && $facebookUser->getEmail()) {
                if ($user = User::where('email', $facebookUser->getEmail())->where("deleted", 0)->where('role','!=',1)->first()) {
                    $user->name = $facebookUser->getName();
                    $user->social_type = "facebook";
                    $user->active = 1;
                    $user->save();
                } else {
                    $user = new User([
                        'name' => $facebookUser->getName(),
                        'email' => $facebookUser->getEmail(),
                        'social_type' => "facebook",
                        'password' => bcrypt(uniqid()),
                        'role' => 2,
                        'active' => 1,
                    ]);
                    $user->save();
                }
                Auth::login($user);
                return redirect('/');
            } else {
                return redirect('/')->with('error', 'Something went wrong..');
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Facebook login failed: ' . $e->getMessage());
        }
    }
    function changeLang($langcode){
        App::setLocale($langcode);
        Session::put('locale', $langcode);
        return redirect()->back();
    }
    public function getProjects(Request $request)
    {
        $query = Projects::where(['active' => '1', 'deleted' => 0]);

        if ($request->location_id) {
            $query->where('country', $request->location_id);
        }

        $r = $query->get();
        return response()->json(['data' => $r, 'status' => 200], 200);
    }

    public function check_sms(Request $request)
    {
        $page_heading = "Check SMS";
        if($request->mobile){
            $mobile = $request->mobile;
            $url = 'https://messaging.ooredoo.qa/bms/soap/Messenger.asmx';
            $code = 123456;
            $messageBody = '<?xml version="1.0" encoding="utf-8"?>
                <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                    <soap:Body>
                        <HTTP_SendSms xmlns="http://pmmsoapmessenger.com/">
                            <customerID>6480</customerID>
                            <userName>BinAlSheikh</userName>
                            <userPassword>Bsb@2#3$0%</userPassword>
                            <originator>BinAlSheikh</originator>
                            <smsText>Your OTP is ' . $code . '</smsText>
                            <recipientPhone>' . $mobile . '</recipientPhone>
                            <messageType>Latin</messageType>
                            <defDate>' . gmdate('Ymdhis') . '0</defDate>
                            <blink>false</blink>
                            <flash>false</flash>
                            <Private>false</Private>
                        </HTTP_SendSms>
                    </soap:Body>
                </soap:Envelope>';

            $client = new Client();
            $create = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8',
                    'SOAPAction' => "http://pmmsoapmessenger.com/HTTP_SendSms"
                ],
                'body' => $messageBody
            ]);
            dd($create);
        }
        return view('front_end.check_sms', compact('page_heading'));
    }
    public function index()
    {
        $page_heading = "Home";
        $categories = Categories::where(['deleted' => 0])->orderBy('name', 'asc')->get();
        $recommended = Properties::with(['property_type', 'images'])->where(['is_recommended' => 1, 'active' => '1', 'deleted' => 0])->orderBy('order')->limit(3)->get();
        foreach ($recommended as $key => $val) {
            $recommended[$key]->is_fav = 0;
            if (Auth::check() && (Auth::user()->role != '1')) {
                if (FavouriteProperty::where(['user_id' => Auth::user()->id, 'property_id' => $val->id])->first()) {
                    $recommended[$key]->is_fav = 1;
                }
            }
        }
        $recommended_prj = Projects::where(['is_recommended' => 1, 'active' => '1', 'deleted' => 0])->orderBy('created_at', 'desc')->limit(6)->get();

        // Add unit counts for each project
        foreach ($recommended_prj as $key => $project) {
            // Total units left
            $total_units = Properties::where(['active' => '1', 'deleted' => 0, 'project_id' => $project->id])
                ->count();
            $recommended_prj[$key]->total_units = $total_units;

            // Units for rent
            $rent_units = Properties::where(['active' => '1', 'deleted' => 0, 'project_id' => $project->id])->whereIn('sale_type', [2, 3])
                ->count();
            $recommended_prj[$key]->rent_units = $rent_units;

            // Units for sale
            $buy_units = Properties::where(['active' => '1', 'deleted' => 0, 'project_id' => $project->id])
                ->whereIn('sale_type', [1, 3])
                ->count();
            $recommended_prj[$key]->buy_units = $buy_units;
        }

        $recommended_ser = Service::where(['is_recommended' => 1, 'active' => '1', 'deleted' => 0])->orderBy('created_at', 'desc')->limit(6)->get();

        $prj = Projects::select('id', 'name','name_ar')->where(['active' => '1', 'deleted' => 0])->orderBy('created_at', 'desc')->get();

        $locations = ProjectCountry::select('id', 'name','name_ar')->where(['active' => '1', 'deleted' => 0])->orderBy('created_at', 'desc')->get();

        $reviews = Reviews::where(['deleted' => 0, 'active' => 1])->limit(10)->latest()->get();

        // Get active popup for home page if not shown in this session
        $popup = null;
        if (!Session::has('popup_shown')) {
            $popup = Popup::where('is_active', 1)->latest()->first();
            if ($popup) {
                Session::put('popup_shown', true);
            }
        }

        return view('front_end.index', compact('page_heading', 'recommended', 'categories', 'recommended_prj', 'recommended_ser', 'prj','locations','reviews', 'popup'));
    }

    public function property_listing()
    {
        $page_heading = "Properties";
        $search_text = $_GET['search_text'] ?? '';
        $sale_type = $_GET['sale_type'] ?? '';
        $property_type = $_GET['property_type'] ?? '';
        $bedrooms = $_GET['bedrooms'] ?? '';
        $bathrooms = $_GET['bathrooms'] ?? '';
        $price_from = $_GET['price_from'] ?? '';
        $price_to = $_GET['price_to'] ?? '';
        $project_id = $_GET['project'] ?? '';
        $location_id = $_GET['location'] ?? '';
        $sort = $_GET['sort'] ?? 'order';
        $unit_number = $_GET['unit_number'] ?? '';
        $type = $_GET['filter'] ?? 'BUY_RENT';
        $pr_text = __('messages.price');

        $properties = Properties::select('properties.*')->where(['properties.active' => '1', 'properties.deleted' => 0])->leftjoin('projects','projects.id','properties.project_id');
        if (isset($type) && $type != 'BUY_RENT') {
            //Log::info(Properties::saleType[$type]);
            //$properties = $properties->where('sale_type',Properties::saleType[$type]);
            $properties = $properties->whereIn('sale_type', [Properties::saleType[$type], 3]);
        }
        if ($unit_number) {
            $properties = $properties->whereRaw("(properties.apartment_no like '%$unit_number%')");
        }
        if ($sort =="latest") {
            $properties = $properties->orderBy('properties.created_at', 'desc')->orderBy('properties.order', 'asc');
        }
        if ($sort == "price_low_to_high") {
            $properties = $properties->orderBy('properties.price', 'asc')->orderBy('properties.order', 'asc');
        }
        if ($sort == "price_high_to_low") {
            $properties = $properties->orderBy('properties.price', 'desc')->orderBy('properties.order', 'asc');
        }

        if ($sort == "size_low_to_high") {
            $properties = $properties->orderByRaw('CAST(properties.area AS DECIMAL) ASC, properties.order ASC');
        }
        if ($sort == "size_high_to_low") {
            $properties = $properties->orderByRaw('CAST(properties.area AS DECIMAL) DESC, properties.order ASC');
        }

        if ($sort == "floor_low_to_high") {
            $properties = $properties->orderByRaw('CAST(properties.floor_no AS DECIMAL) ASC, properties.order ASC');
        }
        if ($sort == "floor_high_to_low") {
            $properties = $properties->orderByRaw('CAST(properties.floor_no AS DECIMAL) DESC, properties.order ASC');
        }
        if ($sort =="order") {
            $properties = $properties->orderBy('properties.is_featured', 'desc')->orderBy('properties.order', 'asc');
        }
        // Apply default ordering by order field

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
        if (isset($bedrooms) && $bathrooms) {
            $bed_bath_text = ($bedrooms == "0" ? __('messages.studio') : $bedrooms . ' '.__('messages.beds')) . ' & ' . $bathrooms . ' '.__('messages.baths');
        } else if (isset($bedrooms)) {
            $bed_bath_text = $bedrooms == "0" ? __('messages.studio') : $bedrooms . ' '.__('messages.beds');
        } else if ($bathrooms) {
            $bed_bath_text = $bathrooms . ' '.__('messages.baths');
        }

//        if (isset($bedrooms)) {
//            if ($bedrooms == "6+") {
//                $properties = $properties->where('bedrooms', '>=', 6);
//            } else {
//                $properties = $properties->where('bedrooms', $bedrooms);
//            }
//        }
        if (isset($bedrooms) && $bedrooms != '') {
            if ($bedrooms == "6+") {
                $properties = $properties->where('bedrooms', '>=', 6);
            } else {
                if($bedrooms == '0')
                    $properties = $properties->where('bedrooms', $bedrooms);
                else
                {
                    if($bedrooms)
                    {
                        $properties = $properties->where('bedrooms', $bedrooms);
                    }
                }
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
        $properties = $properties->paginate(9);

        foreach ($properties as $key => $val) {
            $properties[$key]->is_fav = 0;
            if (Auth::check() && (Auth::user()->role != '1')) {
                if (FavouriteProperty::where(['user_id' => Auth::user()->id, 'property_id' => $val->id])->first()) {
                    $properties[$key]->is_fav = 1;
                }
            }
        }

        $categories = Categories::where(['deleted' => 0])->orderBy('name', 'asc')->get();
        $prj = Projects::select('id', 'name')->where(['active' => '1', 'deleted' => 0,'country'=>$location_id])->orderBy('created_at', 'desc')->get();
        $locations = ProjectCountry::select('id', 'name','name_ar')->where(['active' => '1', 'deleted' => 0])->orderBy('created_at', 'desc')->get();

        $bed_bath_text = __('messages.room_baths');
        if (isset($bedrooms) && $bathrooms) {
            $bed_bath_text = ($bedrooms == "0" ? __('messages.studio') : $bedrooms . ' '.__('messages.beds')) . ' & ' . $bathrooms . ' '.__('messages.baths');
        } else if (isset($bedrooms)) {
            $bed_bath_text = $bedrooms == "0" ? __('messages.studio') : $bedrooms . ' '.__('messages.beds');
        } else if ($bathrooms) {
            $bed_bath_text = $bathrooms . ' '.__('messages.baths');
        }
        if ($price_from || $price_to) {
            $pr_text = $price_from . ' - ' . $price_to;
        }

        return view('front_end.properties', compact('page_heading', 'properties', 'categories', 'prj', 'sale_type', 'property_type', 'bedrooms', 'bathrooms', 'price_from', 'price_to', 'project_id', 'bed_bath_text', 'pr_text','locations','location_id','sort','unit_number'));
    }

    public function property_details($slug)
    {
        $property = Properties::with(['property_type', 'images', 'amenities'])->where(['slug' => $slug, 'active' => '1', 'deleted' => 0])->first();
        if (!$property) {
            abort(404);
        }

        // First try to get explicitly linked similar properties
        $similar = null;
        if ($property->similar_properties) {
            $similar = Properties::with(['property_type', 'images'])
                ->whereIn('id', explode(',', $property->similar_properties))
                ->where(['active' => '1', 'deleted' => 0])
                ->limit('6')
                ->get();
        }

        // If no explicitly linked properties or not enough, fall back to the default criteria
//        if (!$similar || $similar->count() < 6) {
//            $fallback = Properties::with(['property_type', 'images'])
//                ->where(['active' => '1', 'deleted' => 0, 'sale_type' => $property->sale_type, 'category' => $property->category])
//                ->where('id', '!=', $property->id);
//
//            if ($similar) {
//                $fallback->whereNotIn('id', explode(',', $property->similar_properties));
//            }
//
//            $fallback = $fallback->limit(6 - ($similar ? $similar->count() : 0))->get();
//
//            if ($similar) {
//                $similar = $similar->concat($fallback);
//            } else {
//                $similar = $fallback;
//            }
//        }
        if($similar) {
            foreach ($similar as $key => $val) {
                $similar[$key]->is_fav = 0;
                if (Auth::check() && (Auth::user()->role != '1')) {
                    if (FavouriteProperty::where(['user_id' => Auth::user()->id, 'property_id' => $val->id])->first()) {
                        $similar[$key]->is_fav = 1;
                    }
                }
            }
        }
        $page_heading = $property->name;
        $settings = Settings::find(1);

        $cur_month = Carbon::now();
        $cur_month->startOfMonth();
        if(isset($property->project->end_date) && $property->project->end_date){
            $targetDate = Carbon::createFromFormat('Y-m', $property->project->end_date)->endOfMonth();;
            $monthsDifference = $cur_month->diffInMonths($targetDate);
        }else{
            $monthsDifference = $settings->month_count;
        }


        $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
        $total = $property->price + $ser_amt;
        $full_price_calc = $property->price;
        $down_payment = ($settings->advance_perc / 100) * $full_price_calc;
        $pending_amt = $full_price_calc - $down_payment;

        $payableEmiAmount = $pending_amt;
        $monthCount = $monthsDifference;//$settings->month_count;
        $monthlyPayment = $payableEmiAmount / $monthCount;
        $percentageRate = (100 - $settings->advance_perc) / $monthCount;

        $months = [];
        $totalPercentage = $settings->advance_perc;
        $remainingAmount = $payableEmiAmount;

        for ($i = 0; $i < $monthCount; $i++) {
            $remainingAmount -= $monthlyPayment;
            $totalPercentage += $percentageRate;
            $month = $cur_month->addMonth()->format('M-y');
            $months[$i]['month'] = $month;
            $months[$i]['month_list'] = $formatted_date = Carbon::createFromFormat('M-y', $month)->format('F - Y');;
            $months[$i]['val'] = $i+1;
            $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
            $months[$i]['payment'] = round($monthlyPayment, 2);
            $months[$i]['remaining_amount'] = round($remainingAmount, 2);
            $months[$i]['total_percentage'] = round($totalPercentage, 2);
        }
        return view('front_end.property_details', compact('page_heading', 'property', 'similar', 'settings', 'months','monthCount'));

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

    public function project_details($slug)
    {
        $project = Projects::with(['images'])->where(['slug' => $slug, 'active' => '1', 'deleted' => 0])->first();
        if (!$project) {
            abort(404);
        }
        $floors = Properties::where([
            'active' => '1',
            'deleted' => 0,
            'project_id' => $project->id
        ])
            ->whereNotNull('floor_no')
            ->where('floor_no', '!=', '')
            ->distinct('floor_no')
            ->orderByRaw('CAST(floor_no AS UNSIGNED) ASC')
            ->pluck('floor_no')
            ->toArray();

        $floors_with_properties = [];

        foreach ($floors as $k=>$floor_no) {
            $properties = Properties::where([
                'active' => '1',
                'deleted' => 0,
                'floor_no' => $floor_no,
                'project_id' => $project->id
            ])->get(['id', 'name','name_ar', 'slug', 'floor_no', 'apartment_no', 'sale_type']);
            $floors_with_properties[$k]['floor'] = $floor_no;
            $floors_with_properties[$k]['prop'] = $properties;
        }
        // First try to get explicitly linked similar properties
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



        $page_heading = $project->name;
        return view('front_end.project_details', compact('page_heading', 'project', 'similar','floors','floors_with_properties'));
    }
    public function project_listing()
    {
        $projects = Projects::where(['active' => '1', 'deleted' => 0])->get();
        foreach ($projects as $key => $project) {
            // Total units left
            $total_units = Properties::where(['active' => '1', 'deleted' => 0, 'project_id' => $project->id])
                ->count();
            $projects[$key]->total_units = $total_units;

            // Units for rent
            $rent_units = Properties::where(['active' => '1', 'deleted' => 0, 'project_id' => $project->id])->whereIn('sale_type', [2, 3])
                ->count();
            $projects[$key]->rent_units = $rent_units;

            // Units for sale
            $buy_units = Properties::where(['active' => '1', 'deleted' => 0, 'project_id' => $project->id])
                ->whereIn('sale_type', [1, 3])
                ->count();
            $projects[$key]->buy_units = $buy_units;
        }

        $page_heading = "Projects";
        return view('front_end.project_listing', compact('page_heading', 'projects'));
    }
    public function service_details($slug)
    {

        $service = Service::with(['highlights'])->where(['slug' => $slug, 'active' => '1', 'deleted' => 0])->first();
        if (!$service) {
            abort(404);
        }
        $page_heading = $service->name;
        return view('front_end.service_details', compact('page_heading', 'service'));

    }
    public function services()
    {
        $services = Service::where(['active' => '1', 'deleted' => 0])->get();
        $page_heading = "Services";
        return view('front_end.services', compact('page_heading', 'services'));
    }
    public function photos()
    {
        $page_heading = "Photos";
        //$photos = Photo::where(['deleted' => 0, 'active' => 1])->latest()->get();
        $folders = Folder::where(['deleted' => 0])->orderBy('is_pinned','DESC')->get();

        // Add has_photos, has_videos, and has_blogs properties to each folder
        foreach ($folders as $folder) {
            $folder->has_photos = Photo::where(['folder_id' => $folder->id, 'deleted' => 0])->exists();
            $folder->has_videos = Video::where(['folder_id' => $folder->id, 'deleted' => 0, 'active' => 1])->exists();
            $folder->has_blogs = Blog::where(['folder_id' => $folder->id, 'deleted' => 0, 'active' => 1])->exists();
        }

        // Get the filter parameter from the URL (default to 'photos' if not provided)
        $filter = request()->get('filter', 'photos');

        return view('front_end.photos', compact('page_heading', 'folders', 'filter'));
    }

    public function videos()
    {
        $page_heading = "Videos";
        $videos = Video::where(['deleted' => 0, 'active' => 1])->latest()->get();
        return view('front_end.videos', compact('page_heading', 'videos'));
    }
    public function privacy_policy()
    {
        $page_heading = "Privacy Policy";
        return view('front_end.privacy_policy', compact('page_heading'));
    }
    public function data_deletion()
    {
        $page_heading = "Data Deletion";
        return view('front_end.data_deletion', compact('page_heading'));
    }

    public function blogs()
    {
        $page_heading = "Blogs";
        $blog = Blog::where(['deleted' => 0, 'active' => 1])->latest()->paginate(10);
        // foreach ($blog as $key => $val) {
        //     if (session('sys_lang') == "es") {
        //         $blog[$key]->name = $val->name_es;
        //     }
        // }
        return view('front_end.blogs', compact('page_heading', 'blog'));
    }

    public function blog_details($slug)
    {
        $blog = Blog::where('active', 1)->where('deleted', 0)->where('slug', $slug)->first();
        if (!$blog) {
            abort(404);
        }

        // if ($blog) {
        //     if (session('sys_lang') == "es") {
        //         $blog->name = $blog->name_es ?? $blog->name;
        //         $blog->description = $blog->description_es ?? $blog->description;
        //     }
        // }
        $page_heading = "Blog";
        return view('front_end.blog_details', compact('page_heading', 'blog'));
    }

    public static function sendMail($to, $sub, $body)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "mail.dtstourism.com";
        $mail->SMTPAuth = true;
        $mail->Username = "noreply@dtstourism.com";
        $mail->Password = "Dts@TotisN0r";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        //begin - remove these if https is enabled
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true,
        //     ),
        // );
        //end
        $mail->setFrom("noreply@dtstourism.com", "Diplomatic Travel Services");
        $mail->addAddress($to);
        $mail->Subject = $sub;
        $mail->isHTML(true);
        $mail->Body = $body;
        if (!$mail->send()) {
            return 0;
            // dd('afaf');
        } else {
            return 1;
        }
    }

    public function save_contact_us(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = '';
        $ins = $request->all();
        unset($ins['_token']);

        $ins['created_at'] = gmdate('Y-m-d H:i:s');
        if ($insertedId = ContactUsModel::insertGetId($ins)) {

            $mail_title = "Thanks for your inquiry. Your Inquiry has been received by DTS Tourism.";
            $name = $ins['name'];
            $body = view('front_end.mail', compact('mail_title', 'name'));
            $this->sendMail($ins['email'], "Thanks for your inquiry", $body);

            $body = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; ">
    <div
        style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="background: #000;
     color: #ffffff; padding: 10px; text-align: center;">
            <img src="https://www.dtstourism.com/front-assets/images/logo.png" alt="" style="height: 80px;">
        </div>
        <div style="padding: 20px;">
            <h2 style="color: #000; margin-bottom: 0px; margin-top: 0px;">' . $ins['name'] . '</h2>
            <p style="line-height: 26px; color: #000;">' . $ins['phone'] . ' | ' . $ins['email'] . '

            </p>
            <table
                style="width:100%; margin-top: 10px; font-size: 14px; border-collapse: collapse;   border: 1px solid black; margin-bottom: 20px;">
                <tr>
                    <td style="  border: 1px solid black; padding: 5px;">Address: <b>' . $ins['address'] . '</b></td>
                    <td style="  border: 1px solid black; padding: 5px;">Remarks: <b>' . $ins['message'] . '</b></td>
                </tr>
            </table>
            <div style="background-color: #000; padding: 10px; text-align: center; font-size: 12px; color: #fff;">
                <p style="margin: 5px 0; font-weight: bold; font-size: 18px; ">Get to know more:</p>
                <p style="margin: 5px 0;"><a href="https://dtstourism.com/" target="_blank" style="color: #de9f16; text-decoration: none;">dtstourism.com</a></p>
            </div>
        </div>
</body>
</html>';

            $to = "operation@diplomatics.net";
            if ($ins['destination'] == "UAE") {
                $to = "incoming@dtstourism.com";
            }
            $this->sendMail($to, "New Contact Us - DTS", $body);

            $status = "1";
            $message = __('messages.successfully_submitted_contact_soon');

        } else {
            $status = "0";
            $message = __('messages.something_went_wrong');
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }

    public function save_subscribe(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = '';
        $ins = $request->all();
        unset($ins['_token']);
        if (!Subscriber::where('email', $ins['email'])->first()) {
            $ins['created_at'] = gmdate('Y-m-d H:i:s');
            if ($insertedId = Subscriber::insertGetId($ins)) {
                // $body = view('front_end.sub_mail');
                // $this->sendMail($ins['email'], "Thanks for subscribing to our newsletter", $body);

                $status = "1";
                $message = __('messages.successfully_submitted');

            } else {
                $status = "0";
                $message = __('messages.something_went_wrong');
            }
        } else {
            $status = "0";
            $message = __('messages.already_subscribed');
        }

        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }

    public function check_login(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = [];
        $validator = Validator::make($request->all(),
            [
                'email' => ['required', 'email'],
                'password' => 'required',
            ],
            [
                'email.email' => 'Invalid email',
                'email.required' => 'Email required',
                'password.required' => 'Password required',
            ]
        );
        if ($validator->fails()) {
            $status = "0";
            $message = __('messages.validation_error_occurred');
            $errors = $validator->messages();
            return response()->json(['status' => 0, 'message' => __('messages.validation_error_occurred'), 'errors' => $errors]);
        }

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Check if user account is deleted
        if (Auth::user()->deleted == 1) {
            session()->pull("user_id");
            Auth::logout();
            return response()->json(['status' => 0, 'message' => __('messages.account_deleted')]);
        }
        
        // Check if user is admin (role 1) - admins cannot login via frontend
        if (Auth::user()->role == 1) {
            session()->pull("user_id");
            Auth::logout();
            return response()->json(['status' => 0, 'message' => __('messages.invalid_credentials')]);
        }
        
        // Check if account is active
        if (!Auth::user()->active) {
            session()->pull("user_id");
            Auth::logout();
            return response()->json(['status' => 0, 'message' => __('messages.account_deactivated_by_admin')]);
        }
        
        // Check if account is verified/approved (only for agents role 3 and agencies role 4, not regular users role 2)
        if ((Auth::user()->role == 3 || Auth::user()->role == 4) && !Auth::user()->verified) {
            session()->pull("user_id");
            Auth::logout();
            return response()->json(['status' => 0, 'message' => __('messages.account_need_approve_from_admin')]);
        }

        $request->session()->put('user_id', Auth::user()->id);
        if ($request->timezone) {
            $request->session()->put('user_timezone', $request->timezone);
        }
        return response()->json(['status' => 1, 'message' => __('messages.logged_in_successfully')]);

    }

    return response()->json(['status' => 0, 'message' => __('messages.invalid_credentials')]);
    }
    public function signup(Request $request)
    {
        if ($request->isMethod('post')) {
            $status = "0";
            $message = "";
            $errors = [];
            $validator = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'phone' => 'required',
                    'agency_id' => 'nullable|exists:users,id',
                ],
                [
                    'name.required' => 'Name required 4444',
                    'email.required' => 'Email required',
                    'password.required' => 'Password required',
                    'phone.required' => 'Phone required',
                    'agency_id.exists' => 'Selected agency is invalid',
                ]
            );
            if ($validator->fails()) {
                $status = "0";
                $message = __('messages.validation_error_occurred');
                $errors = $validator->messages();
            }
            // if ($request->password != $request->cpassword) {
            if (1 != 1) {
                $status = "0";
                $message = "Password Not Matching";
                return response()->json(['success' => $status,'status' => $status, 'message' => $message, 'errors' => $errors]);
            } else {

                if($request->user_type == 2)
                {
                    if(Session::get('phone_verified') != $request->phone)
                    {
                        $status = "0";
                        $message = __('messages.you_should_verify_the_otp');
                        $errors['phone'] = $request->phone . " ".__('messages.you_should_verify_the_otp');
                        return response()->json(['success' => 0,'status' => $status, 'message' => $message,'errors' => $errors  ]);
//
//                        $message = __('messages.you_should_verify_the_otp');
//                        $errors['phone'] = $request->phone . " ".__('messages.you_should_verify_the_otp');
                    }

                }
                $check_exist = User::where('email', $request->email)->get()->toArray();
                if ($check_exist) {
                    $status = "0";
                    $message = "Email should be unique";
                    $errors['email'] = $request->email . " ".__('messages.already_added');
                    return response()->json(['success' => $status,'status' => $status, 'message' => $message, 'errors' => $errors]);
                    //  echo json_encode(['status' => $status, 'errors' => $errors]);die();
                }

                $ins = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'role' => $request->user_type,
                    'active' => 1,
                    'verified' => 0,
                    'created_at' => gmdate('Y-m-d H:i:s'),
                ];

                // Add agency_id for agents
                if ($request->user_type == 3 && $request->agency_id) {
                    $ins['agency_id'] = $request->agency_id;
                }
                if ($request->file("image")) {
                    $response = image_upload($request, 'profile', 'image');
                    if ($response['status']) {
                        $ins['image'] = $response['link'];
                    }
                }


                if ($request->user_type == 3 ) {
                    $ins['id_no'] = $request->id_no??'';
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
                    $ins['id_no'] = $request->id_no??'';
                    if ($request->file("professional_practice_certificate")) {
                        $response = image_upload($request, 'profile', 'professional_practice_certificate');
                        if ($response['status']) {
                            $ins['professional_practice_certificate'] = $response['link'];
                        }
                    }

                    if ($request->file("authorized_signatory")) {
                        $response = image_upload($request, 'profile', 'authorized_signatory');
                        if ($response['status']) {
                            $ins['authorized_signatory'] = $response['link'];
                        }
                    }

                    if ($request->file("cr")) {
                        $response = image_upload($request, 'profile', 'cr');
                        if ($response['status']) {
                            $ins['cr'] = $response['link'];
                        }
                    }

                    if ($request->file("license")) {
                        $response = image_upload($request, 'profile', 'license');
                        if ($response['status']) {
                            $ins['license'] = $response['link'];
                        }
                    }
                }

                // if ($request->user_type == 4) {
                //     if ($request->file("cr")) {
                //         $response = image_upload($request, 'profile', 'cr');
                //         if ($response['status']) {
                //             $ins['cr'] = $response['link'];
                //         }
                //     }

                //     if ($request->file("real_estate_license")) {
                //         $response = image_upload($request, 'profile', 'real_estate_license');
                //         if ($response['status']) {
                //             $ins['real_estate_license'] = $response['link'];
                //         }
                //     }
                // }

                if($request->user_type == 2)
                {
                    $ins['verified'] = 1;
                }
                if ($user_id = User::create($ins)->id) {
                    $status = "1";
                    if($request->user_type == 2)
                    {
                        Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => $request->user_type]);
                        $request->session()->put('user_id', Auth::user()->id);
                        if ($request->timezone) {
                            $request->session()->put('user_timezone', $request->timezone);
                        }
                        $message = __('messages.registration_completed_without_verification');
                        $errors = '';
                    }
                    else {
                        $message = __('messages.registration_completed');
                        $errors = '';
                    }
                } else {
                    $status = "0";
                    $message = __('messages.something_went_wrong');
                    $errors = '';
                }
            }
            return response()->json(['success' => $status, 'message' => $message, 'errors' => $errors]);
        } else {
            return response()->json(['success' => 0, 'message' => "__('messages.invalid_attempt')"]);
        }

    }
    public function logout()
    {
        session()->pull("user_id");
        Auth::logout();
        return redirect()->route('home');
    }
    public function my_profile()
    {
        $user_id = Auth::user()->id;
        $page_heading = "My Profile";
        $countries = Country::orderBy('name', 'asc')->select('name','name_ar', 'code_iso')->get();
        return view('front_end.my_profile', compact('page_heading', 'countries'));
    }
    public function update_profile(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_type = Auth::user()->role;
        if ($request->isMethod('post')) {
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
            } else {

                $check_exist = User::where('email', $request->email)->where('id', '!=', $user_id)->get()->toArray();
                if ($check_exist) {
                    $status = "0";
                    $message = "Email should be unique 1111";
                    $errors['email'] = $request->email . " ".__('messages.already_added');
                    echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
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
//                if ($user_type == 3 || $user_type == 4) {
//                    $ins['id_no'] = $request->id_no??'';
//                    if ($request->file("professional_practice_certificate")) {
//                        $response = image_upload($request, 'profile', 'professional_practice_certificate');
//                        if ($response['status']) {
//                            $ins['professional_practice_certificate'] = $response['link'];
//                        }
//                    }
//                }

                if ($request->user_type == 3 || $request->user_type == 4) {
                    $ins['id_no'] = $request->id_no??'';
                    if ($request->file("professional_practice_certificate")) {
                        $response = image_upload($request, 'profile', 'professional_practice_certificate');
                        if ($response['status']) {
                            $ins['professional_practice_certificate'] = $response['link'];
                        }
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
                // if ($request->password) {
                //     $ins['password'] = bcrypt($request->password);
                // }

                if (User::where('id', $user_id)->update($ins)) {
                    $status = "1";
                    $message = __('messages.successfully_updated');
                    $errors = '';
                } else {
                    $status = "0";
                    $message = __('messages.something_went_wrong');
                    $errors = '';
                }
            }
            echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
        } else {
            abort(404);
        }

    }

    public function favorite()
    {
        $properties = Properties::select('properties.*')->where(['properties.active' => '1', 'properties.deleted' => 0, 'favourite_properties.user_id' => Auth::user()->id])->rightjoin('favourite_properties', 'favourite_properties.property_id', 'properties.id')->orderBy('favourite_properties.created_at', 'desc')->get();
        $page_heading = "Favourite Properties";
        return view('front_end.favorite', compact('page_heading', 'properties'));
    }
    public function my_bookings()
    {
        $page_heading = "My Bookings";
        $bookings = Properties::with('project')->select('properties.*','bookings.created_at as booking_date')->where(['bookings.user_id' => Auth::user()->id,'type'=>'Down Payment'])->rightjoin('bookings', 'bookings.property_id', 'properties.id')->orderBy('bookings.created_at', 'desc')->get();
        $settings = Settings::find(1);
        $cur_month = Carbon::now();
        $cur_month->startOfMonth();

        foreach($bookings as $key=>$val){
            $paid_mount = Booking::where(['bookings.user_id' => Auth::user()->id,'property_id'=>$val->id])->sum('amount');
            $ser_amt = ($settings->service_charge_perc / 100) * $val->price;
            $total = $val->price + $ser_amt;
            $down_payment = ($settings->advance_perc / 100) * $total;
            $pending_amt = $total - $down_payment;

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

            for ($i = 0; $i < $monthCount; $i++) {
                $remainingAmount -= $monthlyPayment;
                $totalPercentage += $percentageRate;
                $months[$i]['month'] = $cur_month->addMonth()->format('M-y');
                $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
                $months[$i]['payment'] = round($monthlyPayment, 2);
                $months[$i]['remaining_amount'] = round($remainingAmount, 2);
                $months[$i]['total_percentage'] = round($totalPercentage, 2);
            }
            $bookings[$key]['months'] = $months;
            $bookings[$key]['paid_mount'] = $paid_mount;

        }
        return view('front_end.my_bookings', compact('page_heading','bookings','settings'));
    }

    public function my_reservations()
    {
        $page_heading = "My Reservations";
        $id = Auth::user()->id;
        $customer = User::with(['agencyUsers'])->find($id);
        $settings = Settings::find(1);

        if (!$customer) {
            abort(404);
        }
        if($customer ->role == 4)
        {
            $agentIds = $customer->agencyUsers->pluck('id')->toArray();

            $reservations = \App\Models\Reservation::with(['agent', 'property'])
            ->whereIn('agent_id', $agentIds)
            ->orderBy('created_at', 'desc')
            ->get();
            return view('front_end.my_reservations', compact('page_heading','reservations','settings'));
        }
        else
        {
            $reservations = \App\Models\Reservation::with(['agent', 'property'])
            ->where('agent_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
            return view('front_end.my_reservations', compact('page_heading','reservations','settings'));

        }
        // $bookings = Properties::with(['project', 'images'])->select('properties.*','reservations.created_at as booking_date')->where(['reservations.user_id' => Auth::user()->id])->rightjoin('reservations', 'reservations.property_id', 'properties.id')->orderBy('reservations.created_at', 'desc')->get();
        // $settings = Settings::find(1);
        // $cur_month = Carbon::now();
        // $cur_month->startOfMonth();

        // foreach($bookings as $key=>$val){
        //     // Get paid amount from reservations table
        //     $paid_mount = \App\Models\Reservation::where(['user_id' => Auth::user()->id, 'property_id' => $val->id])->sum('amount');
            
        //     $ser_amt = ($settings->service_charge_perc / 100) * $val->price;
        //     $total = $val->price + $ser_amt;
        //     $down_payment = ($settings->advance_perc / 100) * $total;
        //     $pending_amt = $total - $down_payment;

        //     if(isset($val->project->end_date) && $val->project->end_date){
        //         $targetDate = Carbon::createFromFormat('Y-m', $val->project->end_date)->endOfMonth();;
        //         $monthsDifference = $cur_month->diffInMonths($targetDate);
        //     }else{
        //         $monthsDifference = $settings->month_count;
        //     }

        //     $payableEmiAmount = $pending_amt;
        //     $monthCount = $monthsDifference;
        //     $monthlyPayment = $payableEmiAmount / $monthCount;
        //     $percentageRate = (100 - $settings->advance_perc) / $monthCount;

        //     $months = [];
        //     $totalPercentage = $settings->advance_perc;
        //     $remainingAmount = $payableEmiAmount;

        //     for ($i = 0; $i < $monthCount; $i++) {
        //         $remainingAmount -= $monthlyPayment;
        //         $totalPercentage += $percentageRate;
        //         $months[$i]['month'] = $cur_month->addMonth()->format('M-y');
        //         $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
        //         $months[$i]['payment'] = round($monthlyPayment, 2);
        //         $months[$i]['remaining_amount'] = round($remainingAmount, 2);
        //         $months[$i]['total_percentage'] = round($totalPercentage, 2);
        //     }
        //     $bookings[$key]['months'] = $months;
        //     $bookings[$key]['paid_mount'] = $paid_mount;
        // }
        
    }

    public function my_employees()
    {
        $page_heading = "My Employees";
        $id = Auth::user()->id;
        $customer = User::with(['agencyUsers'])->find($id);

        if (!$customer) {
            abort(404);
        }

        // Get employees for agency users (role 4 = agency)
        if($customer->role == 4) {
            $employees = $customer->agencyUsers()
                ->where('role', 3) // role 3 = agent/employee
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // For individual agents, return empty collection
            $employees = collect();
        }

        return view('front_end.my_employees', compact('page_heading', 'employees'));
    }

    public function visit_schedule()
    {

        $page_heading = "Visit Schedule";
        $id = Auth::user()->id;
        $customer = User::with(['agencyUsers'])->find($id);

        if (!$customer) {
            abort(404);
        }

        // Get all active properties for the dropdown
        $properties = \App\Models\Properties::with(['project', 'property_type'])
            ->where('active', 1)
            ->where('deleted', 0)
            ->orderBy('name', 'asc')
            ->get();

        // Get all active projects for the dropdown
        $projects = \App\Models\Projects::where('active', 1)
            ->where('deleted', 0)
            ->orderBy('name', 'asc')
            ->get();

        // Initialize agents variable
        $agents = collect();

        if($customer ->role == 4)
        {
            // Get agents for this agency
            $agents = $customer->agencyUsers()
                ->where('role', 3) // role 3 = agent/employee
                ->where('active', 1) // only active agents
                ->orderBy('name', 'asc')
                ->get();

            $agentIds = $customer->agencyUsers->pluck('id')->toArray();

            $visits = \App\Models\VisiteSchedule::with(['agent', 'project'])
            ->whereIn('agent_id', $agentIds)
            ->orderBy('created_at', 'desc')
            ->get();
            return view('front_end.visit_schedule', compact('page_heading','visits', 'properties', 'projects', 'agents'));
        }
        else
        {
            $visits = \App\Models\VisiteSchedule::with(['agent', 'project'])
            ->where('agent_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
            return view('front_end.visit_schedule', compact('page_heading','visits', 'properties', 'projects', 'agents'));

        }

        
    }

    public function fav_property(Request $request)
    {
        if ($fav = FavouriteProperty::where(['user_id' => Auth::user()->id, 'property_id' => $request->prop_id])->first()) {
            $fav->delete();
            return response()->json(['status' => 1, 'message' => __('messages.removed_from_favourites'), 'type' => 'rem']);
        } else {
            $ins['user_id'] = Auth::user()->id;
            $ins['property_id'] = $request->prop_id;
            $ins['created_at'] = gmdate('Y-m-d H:i:s');
            FavouriteProperty::create($ins);
            return response()->json(['status' => 1, 'message' => __('messages.added_to_favourites'), 'type' => 'add']);
        }
    }

    public function change_password(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->isMethod('post')) {
            $status = "0";
            $message = "";
            $errors = [];
            $validator = Validator::make($request->all(),
                [
                    'cur_password' => 'required',
                    'password' => 'required|confirmed',
                    'password_confirmation' => 'required',
                ]
            );
            if ($validator->fails()) {
                $status = "0";
                $message = __('messages.validation_error_occurred');
                $errors = $validator->messages();
            } else {
                if (Auth::attempt(['id' => $user_id, 'password' => $request->cur_password, 'role' => Auth::user()->role])) {
                    $ins['password'] = bcrypt($request->password);
                    $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                    if (User::where('id', $user_id)->update($ins)) {
                        $status = "1";
                        $message = __('messages.password_successfully_updated');
                        $errors = '';
                    } else {
                        $status = "0";
                        $message = __('messages.something_went_wrong');
                        $errors = '';
                    }
                } else {
                    $status = "0";
                    $message = __('messages.invalid_current_password');
                    $errors = '';
                }
            }
            echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
        } else {
            abort(404);
        }

    }

    public function qib()
    {
        $gatewayId = "015995941";
        $secretKey = "LRhchdhRxSGUxzt5";
        $amount_to_pay = 0.25;
        $amount = number_format((float) $amount_to_pay, 2, '.', '');
        $referenceId = $this->generateReferenceId();
        $hashable_string = "gatewayId=" . $gatewayId . ",amount=" . $amount . ",referenceId=" . $referenceId;
        $signature = base64_encode(hash_hmac('sha256', $hashable_string, $secretKey, true));
        $returnUrl = url('qib_payment_status');

        return view('front_end.qib', compact('gatewayId', 'secretKey', 'amount', 'referenceId', 'hashable_string', 'signature', 'returnUrl'));

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
    public function qib_payment_status(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->status == "success") {
            $referenceId = $request->referenceId;
            $temp_booking = TempBooking::where(['payment_ref_id' => $referenceId, 'user_id' => $user_id])->first();
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
            return redirect()->route('frontend.my_bookings')->with('success', __('messages.booking_successfully_completed'));
        } else {
            return redirect()->route('frontend.my_bookings')->with('error', $request->reason);
        }
    }

    public function qib_reserve_payment_status(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->status == "success") {
            $referenceId = $request->referenceId;
            $temp_booking = TempReservation::where(['payment_ref_id' => $referenceId, 'user_id' => $user_id])->first();
            $temp_id = $user_id . uniqid() . time();
            $booking = new Reservation();
            $booking->user_id = $user_id;
            $booking->property_id = $temp_booking->property_id;
            $booking->payment_ref_id = $referenceId;
            $booking->amount = $temp_booking->amount;
            $booking->created_at = gmdate('Y-m-d H:i:s');
            $booking->payment_return = json_encode($request->all());
            $booking->payment_mode = "QIB";
            $booking->invoice_id = $temp_id;

            $booking->save();

            $booking->booking_no = 'PROP-RSRVTN-' . date(date('Ymd', strtotime($booking->created_at))) . $booking->id;
            $booking->save();
            $temp_booking->delete();
            return redirect()->route('frontend.my_reservations')->with('success', __('messages.booking_successfully_completed'));
        } else {
            return redirect()->route('frontend.my_reservations')->with('error', $request->reason);
        }
    }
    public function book_now(Properties $property,Request $request)
    {
        if($request->submit=="book"){
            $with_management_fee = $request->with_management_fee;
            $page_heading = "Book Now";
            $settings = Settings::find(1);

            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            $total = $property->price + $ser_amt;
            // $down_payment = ($settings->advance_perc / 100) * $total;
            if($with_management_fee){
                $down_payment = (($settings->advance_perc+$settings->service_charge_perc) / 100) * $property->price;
            }else{
                $down_payment = ($settings->advance_perc/100) * $property->price;
            }





            // $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            // $total = $property->price + $ser_amt;
            // $down_payment = ($settings->advance_perc / 100) * $total;
            $amount_to_pay = $down_payment;
            // $amount_to_pay = 0.1;
            $pending_amt = $total - $amount_to_pay;

            $gatewayId = "015995941";
            $secretKey = "LRhchdhRxSGUxzt5";
            $amount = number_format((float) $amount_to_pay, 2, '.', '');
            $referenceId = $this->generateReferenceId();
            $hashable_string = "gatewayId=" . $gatewayId . ",amount=" . $amount . ",referenceId=" . $referenceId;
            $signature = base64_encode(hash_hmac('sha256', $hashable_string, $secretKey, true));
            $returnUrl = url('qib_payment_status');

            $temp['user_id'] = Auth::user()->id;
            $temp['property_id'] = $property->id;
            $temp['payment_ref_id'] = $referenceId;
            $temp['amount'] = $amount_to_pay;
            $temp['with_management_fee'] = $with_management_fee;
            $temp['pending_amt'] = $pending_amt;
            TempBooking::insert($temp);
            return view('front_end.qib', compact('gatewayId', 'secretKey', 'amount', 'referenceId', 'hashable_string', 'signature', 'returnUrl'));
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

    public function specific_book_now(Properties $property,Request $request)
    {
        if($request->submit=="book"){
            $with_management_fee = $request->with_management_fee;
            $page_heading = "Specific Book Now";
            $settings = Settings::find(1);
            $down_payment = $request->down_payment;
            $rental_duration = $request->rental_duration;
            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            $total = $property->price + $ser_amt;
            // $down_payment = ($settings->advance_perc / 100) * $total;
            if($with_management_fee){
                $down_payment = $down_payment + $ser_amt;
            }else{
                $down_payment = $down_payment;
            }





            // $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            // $total = $property->price + $ser_amt;
            // $down_payment = ($settings->advance_perc / 100) * $total;
            $amount_to_pay = $down_payment;
            // $amount_to_pay = 0.1;
            $pending_amt = $total - $amount_to_pay;

            $gatewayId = "015995941";
            $secretKey = "LRhchdhRxSGUxzt5";
            $amount = number_format((float) $amount_to_pay, 2, '.', '');
            $referenceId = $this->generateReferenceId();
            $hashable_string = "gatewayId=" . $gatewayId . ",amount=" . $amount . ",referenceId=" . $referenceId;
            $signature = base64_encode(hash_hmac('sha256', $hashable_string, $secretKey, true));
            $returnUrl = url('qib_payment_status');

            $temp['user_id'] = Auth::user()->id;
            $temp['property_id'] = $property->id;
            $temp['payment_ref_id'] = $referenceId;
            $temp['amount'] = $amount_to_pay;
            $temp['with_management_fee'] = $with_management_fee;
            $temp['pending_amt'] = $pending_amt;
            TempBooking::insert($temp);
            return view('front_end.qib', compact('gatewayId', 'secretKey', 'amount', 'referenceId', 'hashable_string', 'signature', 'returnUrl'));
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
    public function change_currency($currency)
    {
        session()->put('currency', $currency);
        $this->thmx_currency_convert();
        return redirect()->back();
    }

    /**
     * Send an SMS using the API with Basic Authentication
     *
     * @param string $username API username
     * @param string $password API password
     * @param string $from Sender name/number
     * @param string $to Recipient numbers (comma-separated)
     * @param string $text Message content
     * @param int $type Encoding type (0 or 1)
     * @param string|null $deferred (Optional) Scheduled send time
     * @param bool $flash (Optional) Flash message
     * @param bool $blink (Optional) Blink message
     * @param bool $private (Optional) Private message
     * @return array API response (includes message ID if successful)
     */
    public function sendSmsWithAuth(
        string $username,
        string $password,
        string $from,
        string $to,
        string $text,
        int $type = 0,
        ?string $deferred = null,
        bool $flash = false,
        bool $blink = false,
        bool $private = false
    ): array {
        $apiUrl = "https://messaging.ooredoo.qa/bms/api/Sms"; // Adjust base URL if needed
        $data = [
            "From" => $from,
            "To" => $to,
            "Text" => $text,
            "Type" => $type,
            "Deferred" => $deferred,
            "Flash" => $flash,
            "Blink" => $blink,
            "Private" => $private
        ];
        Log::info('This is an info message');
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("$username:$password") // Basic Auth
        ]);

        $response = curl_exec($ch);
        Log::info($response);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        Log::info($httpCode);
        curl_close($ch);

        if ($httpCode !== 201) {
            throw new Exception("Failed to send SMS. HTTP Code: $httpCode. Response: $response");
        }

        return json_decode($response, true);
    }
    /**
     * Check the status of an SMS with Basic Authentication
     *
     * @param string $username API username
     * @param string $password API password
     * @param string $messageId UUID of the sent message
     * @param bool $detailed (Optional) Fetch detailed per-recipient status
     * @return array API response (status summary or detailed report)
     */
    function checkSmsStatusWithAuth(
        string $username,
        string $password,
        string $messageId,
        bool $detailed = false
    ): array {
        $endpoint = $detailed ? "/detailed" : "";
        $apiUrl = "https://messaging.ooredoo.qa/bms/api/Sms/" . urlencode($messageId) . $endpoint;

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Authorization: Basic " . base64_encode("$username:$password") // Basic Auth
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("Failed to check status. HTTP Code: $httpCode. Response: $response");
        }

        return json_decode($response, true);
    }
    public function sendOtp(Request $request)
    {
        //   return response()->json(['success' => true, 'message' => 'sdada'], 200);
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'phone' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
            }
            $phone = $request->phone;
            // Generate OTP code (6 digits)
            $otp = rand(100000, 999999);
            // Store OTP in session for later verification
            Session::put('phone_verification_otp', [
                'phone' => $phone,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5)
            ]);
            // Send SMS using Ooredoo API (same as in check_sms method)
            $url = 'https://messaging.ooredoo.qa/bms/soap/Messenger.asmx';
            try {
                $result =$this->sendSmsWithAuth(
                    username: "6480~BinAlSheikh",
                    password: "QQatar@777",
                    from: "BinAlsheikh",
                    to: $phone,
                    text: $otp,
                    type: 0
                );
                $message_id =  $result['data']['id'];
                sleep(2);

                try {
                    $status = $this->checkSmsStatusWithAuth(
                        username: "6480~BinAlSheikh",
                        password: "QQatar@777",
                        messageId: $message_id
                    );
                    if (isset($status['data']['status']['SMSC_DELIVERED'])) {
                        return response()->json(['success' => true, 'message' => 'OTP sent successfully'], 200);
                    }

                } catch (Exception $e) {
                    return response()->json(['success' => false, 'message' => 'Failed to send OTP: ' . $e->getMessage()], 500);
                }

                // Check if delivered
                if (isset($status['data']['status']['SMSC_DELIVERED'])) {
                    echo "Delivered to " . $status['data']['status']['SMSC_DELIVERED'] . " recipient(s).";
                }

// Check for failures
                if (isset($status['data']['status']['REJECTED_BLACKLISTED'])) {
                    echo "Failed (blacklisted): " . $status['data']['status']['REJECTED_BLACKLISTED'];
                }
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to send OTP: ' . $e->getMessage()], 500);
            }


            // For testing/development, just log the OTP
            Log::info("OTP sent to $phone: $otp");

            return response()->json(['success' => true, 'message' => 'OTP sent successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Error sending OTP: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send OTP: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Verify OTP for phone verification
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'phone' => 'required|string',
                'otp' => 'required|string|size:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
            }

            $phone = $request->phone;
            $otp = $request->otp;

            // Retrieve stored OTP from session
            $storedData = Session::get('phone_verification_otp');

            if (!$storedData || $storedData['phone'] !== $phone) {
                return response()->json(['success' => false, 'message' => 'No OTP was sent to this number'], 400);
            }

            // Check if OTP has expired
            if (now()->isAfter($storedData['expires_at'])) {
                Session::forget('phone_verification_otp');
                return response()->json(['success' => false, 'message' => 'OTP has expired'], 400);
            }

            // Verify OTP
            if ($storedData['otp'] != $otp) {
                return response()->json(['success' => false, 'message' => 'Invalid OTP'], 400);
            }

            // OTP is valid, mark phone as verified in session
            Session::put('phone_verified', $phone);
            Session::forget('phone_verification_otp');

            return response()->json(['success' => true, 'message' => 'Phone verified successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Error verifying OTP: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to verify OTP: ' . $e->getMessage()], 500);
        }
    }

    public function thmx_currency_convert()
    {
        $url = 'https://api.exchangerate-api.com/v4/latest/QAR';
        if(!session()->get('currency')){
            session()->put('currency','QAR');
        }
        try {
            $json = file_get_contents($url);
            session()->put('currency_rate', 1);
            if ($json === false) {
                throw new \Exception('Error fetching data from the API.');
            }
            $exp = json_decode($json);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error decoding JSON response.');
            }
            $currency = session()->get('currency', 'QAR');
            if (isset($exp->rates->{$currency})) {
                session()->put('currency_rate', $exp->rates->{$currency});
            } else {
                session()->put('currency_rate', 1);
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
    public function checkout(Properties $property)
    {
        $page_heading = "Chekout";
        if($property->sale_type==1){
            $settings = Settings::find(1);

            $cur_month = Carbon::now();
            $cur_month->startOfMonth();
            if(isset($property->project->end_date) && $property->project->end_date){
                $targetDate = Carbon::createFromFormat('Y-m', $property->project->end_date)->endOfMonth();;
                $monthsDifference = $cur_month->diffInMonths($targetDate);
            }else{
                $monthsDifference = $settings->month_count;
            }



            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            // $total = $property->price + $ser_amt;
            $total = $property->price;
            $down_payment = ($settings->advance_perc / 100) * $total;
            $pending_amt = $total - $down_payment;

            $payableEmiAmount = $pending_amt;
            $monthCount = $monthsDifference;//$settings->month_count;
            $monthlyPayment = $payableEmiAmount / $monthCount;
            $percentageRate = (100 - $settings->advance_perc) / $monthCount;

            $months = [];
            $totalPercentage = $settings->advance_perc;
            $remainingAmount = $payableEmiAmount;

            for ($i = 0; $i < $monthCount; $i++) {
                $remainingAmount -= $monthlyPayment;
                $totalPercentage += $percentageRate;
                $months[$i]['month'] = $cur_month->addMonth()->format('M-y');
                $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
                $months[$i]['payment'] = round($monthlyPayment, 2);
                $months[$i]['remaining_amount'] = round($remainingAmount, 2);
                $months[$i]['total_percentage'] = round($totalPercentage, 2);
            }
            return view('front_end.checkout', compact('page_heading','property','settings','months'));
        }else{
            return view('front_end.rent_checkout', compact('page_heading','property'));
        }

    }

    public function specific_checkout(Properties $property, Request $request)
    {
        $page_heading = "Specific Checkout";
        if($property->sale_type==1){
            $settings = Settings::find(1);
            $advance_amount = $request->advance_amount;
            $rental_duration = $request->rental_duration;

            $cur_month = Carbon::now();
            $cur_month->startOfMonth();

            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            $total = $property->price + $ser_amt;
            $full_price_calc = $property->price;
            $down_payment_p = $advance_amount;
            $pending_amt = $full_price_calc - $down_payment_p;

            $payableEmiAmount = $pending_amt;
            $monthCount = $rental_duration;
            $monthlyPayment = $payableEmiAmount / $monthCount;
            $downPaymentPercentage = ($down_payment_p / $full_price_calc) * 100;
            $percentageRate = (100 - $downPaymentPercentage) / $monthCount;

            $months = [];
            $totalPercentage = $downPaymentPercentage;
            $remainingAmount = $payableEmiAmount;

            for ($i = 0; $i < $monthCount; $i++) {
                $remainingAmount -= $monthlyPayment;
                $totalPercentage += $percentageRate;
                $months[$i]['month'] = $cur_month->addMonth()->format('M-y');
                $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
                $months[$i]['payment'] = round($monthlyPayment, 2);
                $months[$i]['remaining_amount'] = round($remainingAmount, 2);
                $months[$i]['total_percentage'] = round($totalPercentage, 2);
            }
            return view('front_end.specific_checkout', compact('page_heading','property','settings','months', 'down_payment_p','ser_amt', 'downPaymentPercentage', 'rental_duration'));
        }else{
            return view('front_end.rent_checkout', compact('page_heading','property'));
        }
    }
    public function calculate_emi(Request $request)
    {
        $property_id = $request->property_id;
        $property = Properties::find($property_id);
        $advance_amount = $request->advance_amount;
        $handover_amount = $request->hand_over_amount;
        $rental_duration = $request->rental_duration; // This will act as the number of months for the EMI calculation
        $settings = Settings::find(1);

        $cur_month = Carbon::now();
        $cur_month->startOfMonth();

        $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
        $ser_percentage = $settings->service_charge_perc;
        // $total = $property->price + $ser_amt;
        $full_price_calc = $property->price;

        // Set the down payment (advance amount from user)
        $down_payment = $advance_amount;

        // Calculate the pending amount to be paid via EMI
        $pending_amt = $full_price_calc - $down_payment - $handover_amount;

        // The payable EMI amount is the pending amount
        $payableEmiAmount = $pending_amt;

        // Set the rental duration (number of months for EMI)
        $monthCount = $rental_duration;

        // Calculate the monthly payment based on the pending amount and rental duration
        $monthlyPayment = $payableEmiAmount / $monthCount;
        $downPaymentPercentage = ($down_payment / $full_price_calc) * 100;
        $handOverPaymentPercentage = ($handover_amount / $full_price_calc) * 100;
        // Calculate the percentage rate for each month's EMI
        $percentageRate = (100 - $downPaymentPercentage - $handOverPaymentPercentage) / $monthCount;
        $months = [];
        $totalPercentage = $downPaymentPercentage;
        $remainingAmount = $payableEmiAmount;
        $total_payment = $down_payment;
        for ($i = 0; $i < $monthCount; $i++) {
            $remainingAmount -= $monthlyPayment;
            $totalPercentage += $percentageRate;
            $total_payment += $monthlyPayment;
            $months[$i]['month'] = $cur_month->addMonth()->format('M-y');
            $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
            $months[$i]['payment'] = round($monthlyPayment, 2);
            $months[$i]['remaining_amount'] = round($remainingAmount, 2);
            $months[$i]['total_payment'] = round($total_payment, 2);
            $months[$i]['percentage'] = round($percentageRate, 2);
            $months[$i]['total_percentage'] = round($totalPercentage, 2);
        }
        $downPaymentPercentage = round($downPaymentPercentage, 2);
        $total_payment_with_handover = round($total_payment + $handover_amount, 2);
        $html = view('front_end.calculate_emi', compact('down_payment', 'ser_amt','ser_percentage', 'months','downPaymentPercentage', 'handover_amount', 'handOverPaymentPercentage', 'total_payment_with_handover' ))->render();
        return response()->json(['html' => $html]);
    }
    public function get_payment_dates(Request $request)
    {
        $property_id = $request->property_id;
        $property = Properties::find($property_id);
        $rental_duration = $request->desired_rental_duration;
        $cur_month = Carbon::now();
        $cur_month->startOfMonth();

        $rent = $property->price;
        $deposit = $rent;
        $administrative_fee  = $rent/2;
        $total = $rent+$deposit+$administrative_fee;
        $down_payment = $total;

        $monthCount = $rental_duration;
        $monthlyPayment = $rent;
        $total_rent = $rent;
        $months = [];
        for ($i = 1; $i < $monthCount; $i++) {
            $months[$i]['month'] = $cur_month->addMonth()->format('M-y');
            $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
            $months[$i]['payment'] = round($monthlyPayment, 2);
            $total_rent += $monthlyPayment;
        }
        $html = view('front_end.rent_plan', compact('down_payment', 'months','total_rent'))->render();
        return response()->json(['html' => $html]);
    }
    public function book_rent_now(Properties $property,Request $request)
    {
        if($request->submit=="book"){
            $property_id = $request->property_id;
            $rental_duration = $request->desired_rental_duration;
            $cur_month = Carbon::now();
            $cur_month->startOfMonth();

            $rent = $property->price;
            $deposit = $rent;
            $administrative_fee  = $rent/2;
            $total = $rent+$deposit+$administrative_fee;
            $amount_to_pay = $total;

            $gatewayId = "015995941";
            $secretKey = "LRhchdhRxSGUxzt5";
            $amount = number_format((float) $amount_to_pay, 2, '.', '');
            $referenceId = $this->generateReferenceId();
            $hashable_string = "gatewayId=" . $gatewayId . ",amount=" . $amount . ",referenceId=" . $referenceId;
            $signature = base64_encode(hash_hmac('sha256', $hashable_string, $secretKey, true));
            $returnUrl = url('qib_payment_status');

            // $temp['user_id'] = Auth::user()->id;
            // $temp['property_id'] = $property->id;
            // $temp['payment_ref_id'] = $referenceId;
            // $temp['amount'] = $amount_to_pay;
            // $temp['with_management_fee'] = $with_management_fee;
            // $temp['pending_amt'] = $pending_amt;
            // TempBooking::insert($temp);
            return view('front_end.qib', compact('gatewayId', 'secretKey', 'amount', 'referenceId', 'hashable_string', 'signature', 'returnUrl'));
        }else{
            $page_heading = "Reserve Now";
            $amount_to_pay =  1000;
            $gatewayId = "015995941";
            $secretKey = "LRhchdhRxSGUxzt5";
            $amount = number_format((float) $amount_to_pay, 2, '.', '');
            $referenceId = $this->generateReferenceId();
            $hashable_string = "gatewayId=" . $gatewayId . ",amount=" . $amount . ",referenceId=" . $referenceId;
            $signature = base64_encode(hash_hmac('sha256', $hashable_string, $secretKey, true));
            $returnUrl = url('qib_reserve_payment_status');

            // $temp['user_id'] = Auth::user()->id;
            // $temp['property_id'] = $property->id;
            // $temp['payment_ref_id'] = $referenceId;
            // $temp['amount'] = $amount_to_pay;
            // TempReservation::insert($temp);
            return view('front_end.qib', compact('gatewayId', 'secretKey', 'amount', 'referenceId', 'hashable_string', 'signature', 'returnUrl'));
        }

    }
    public function getPropertyCount(Request $request)
    {
        $sale_type = $request->sale_type ?? '';
        $property_type = $request->property_type ?? '';
        $bedrooms = $request->bedrooms ?? '';
        $bathrooms = $request->bathrooms ?? '';
        $price_from = $request->price_from ?? '';
        $price_to = $request->price_to ?? '';
        $project_id = $request->project ?? '';
        $location_id = $request->location ?? '';

        $properties = Properties::select('properties.*')
            ->where(['properties.active' => '1', 'properties.deleted' => 0])
            ->leftjoin('projects', 'projects.id', 'properties.project_id');

        if ($sale_type) {
            if($sale_type != 3){
            $properties = $properties->whereIn('sale_type', [$sale_type, 3]);
            }
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
        if (isset($bedrooms)) {
            if ($bedrooms == "6+") {
                $properties = $properties->where('bedrooms', '>=', 6);
            } else {
                if($bedrooms == '0')
                    $properties = $properties->where('bedrooms', $bedrooms);
                else
                {
                    if($bedrooms)
                    {
                        $properties = $properties->where('bedrooms', $bedrooms);
                    }
                }
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

        $count = $properties->count();
        return response()->json(['count' => $count]);
    }

    public function downloadPaymentPlan($id)
    {
        try {

            $property = Properties::with(['property_type', 'images', 'amenities'])->findOrFail($id);
            if (!$property) {
                abort(404);
            }

            $page_heading = $property->name;
            $settings = Settings::find(1);

            $cur_month = Carbon::now();
            $cur_month->startOfMonth();
            if(isset($property->project->end_date) && $property->project->end_date){
                $targetDate = Carbon::createFromFormat('Y-m', $property->project->end_date)->endOfMonth();;
                $monthsDifference = $cur_month->diffInMonths($targetDate);
            }else{
                $monthsDifference = $settings->month_count;
            }


            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            $total = $property->price + $ser_amt;
            $full_price_calc = $property->price;
            $down_payment = ($settings->advance_perc / 100) * $full_price_calc;
            $pending_amt = $full_price_calc - $down_payment;

            $payableEmiAmount = $pending_amt;
            $monthCount = $monthsDifference;//$settings->month_count;
            $rental_duration = $monthCount;
            $monthlyPayment = $payableEmiAmount / $monthCount;
            $percentageRate = (100 - $settings->advance_perc) / $monthCount;

//            $months = [];
//            $totalPercentage = $settings->advance_perc;
//            $downPaymentPercentage = $settings->advance_perc;
//            $remainingAmount = $payableEmiAmount;
//
//            for ($i = 0; $i < $monthCount; $i++) {
//                $remainingAmount -= $monthlyPayment;
//                $totalPercentage += $percentageRate;
//                $month = $cur_month->addMonth()->format('M-y');
//                $months[$i]['month'] = $month;
//                $months[$i]['month_list'] = $formatted_date = Carbon::createFromFormat('M-y', $month)->format('F - Y');;
//                $months[$i]['val'] = $i+1;
//                $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
//                $months[$i]['payment'] = round($monthlyPayment, 2);
//                $months[$i]['remaining_amount'] = round($remainingAmount, 2);
//                $months[$i]['$percentage_rate'] = round($totalPercentage, 2);
//                $months[$i]['total_percentage'] = round($totalPercentage, 2);
//            }

            $months = [];
            $totalPercentage = $settings->advance_perc;
            $totalPayment = $down_payment;
            $remainingAmount = $payableEmiAmount;

            for ($i = 0; $i < $monthCount; $i++) {
                $remainingAmount -= $monthlyPayment;
                $totalPercentage += $percentageRate;
                $totalPayment += $monthlyPayment;
                $month = $cur_month->copy()->addMonths($i+1)->format('M-y');
                $months[] = [
                    'ordinal' => $this->getOrdinalSuffix($i + 1),
                    'month' => $month,
                    'payment' => round($monthlyPayment, 2),
                    'total_payment' => round($totalPayment, 2),
                    'remaining_amount' => round($remainingAmount, 2),
                    'percentage' => round($percentageRate, 2),
                    'total_percentage' => round($totalPercentage, 2)
                ];
            }

            // Get logo and convert to base64
            $logoPath = public_path('Screenshot_2025-06-14_032432.png');
            $waterMarkPath = public_path('watermark.png');

            $logoBase64 = '';
            $waterMarkBase64 = '';
            if (file_exists($logoPath)) {
                $imageData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            }
            if (file_exists($waterMarkPath)) {
                $imageData = file_get_contents($waterMarkPath);
                $waterMarkBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            }
            $payment_plan = 'Property Payment Plan';
            $payment_term = 'Property Payment Terms';
            // Generate PDF with bookmarks
            $project_name = $property->project ? $property->project->name : '';
            $management_fees_percentage = $settings->service_charge_perc;
            $pdf = $this->getPdf($payment_plan, $payment_term, $property, $ser_amt, $total, $full_price_calc, $down_payment, $settings->advance_perc, $months, $settings, $rental_duration, $logoBase64, $waterMarkBase64, $project_name, $monthlyPayment, $percentageRate, $management_fees_percentage);


            return $pdf->download('payment_plan_' . $property->apartment_no . '.pdf');



        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
//    public function downloadPaymentPlan(Request $request)
//    {
//        try {
//            // Get property details
//            $property = Properties::findOrFail($request->property_id);
//
//            // Get settings
//            $settings = Settings::first();
//
//            // Get calculation parameters from request
//            $advance_amount = $request->advance_amount;
//            $rental_duration = $request->rental_duration;
//
//            // Calculate payment details
//            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
//            $total = $property->price + $ser_amt;
//            $full_price_calc = $property->price;
//            $down_payment = $advance_amount;
//            $pending_amt = $full_price_calc - $down_payment;
//
//            // Calculate percentages
//            $downPaymentPercentage = ($down_payment / $full_price_calc) * 100;
//            $monthlyPercentage = (100 - $downPaymentPercentage) / $rental_duration;
//
//            // Generate months and payment schedule
//            $cur_month = Carbon::now();
//            $cur_month->startOfMonth();
//
//            $monthlyPayment = $pending_amt / $rental_duration;
//
//            $months = [];
//            $totalPercentage = $downPaymentPercentage;
//            $remainingAmount = $pending_amt;
//
//            for ($i = 0; $i < $rental_duration; $i++) {
//                $remainingAmount -= $monthlyPayment;
//                $totalPercentage += $monthlyPercentage;
//                $month = $cur_month->copy()->addMonths($i+1)->format('M-y');
//                $months[] = [
//                    'ordinal' => $this->getOrdinalSuffix($i + 1),
//                    'month' => $month,
//                    'payment' => round($monthlyPayment, 2),
//                    'remaining_amount' => round($remainingAmount, 2),
//                    'total_percentage' => round($totalPercentage, 2)
//                ];
//            }
//
//            // Get logo and convert to base64
//            $logoPath = public_path('Screenshot_2025-06-14_032432.png');
//            $waterMarkPath = public_path('watermark.png');
//
//            $logoBase64 = '';
//            $waterMarkBase64 = '';
//            if (file_exists($logoPath)) {
//                $imageData = file_get_contents($logoPath);
//                $logoBase64 = 'data:image/png;base64,' . base64_encode($imageData);
//            }
//            if (file_exists($waterMarkPath)) {
//                $imageData = file_get_contents($waterMarkPath);
//                $waterMarkBase64 = 'data:image/png;base64,' . base64_encode($imageData);
//            }
//            $payment_plan = 'Property Payment Plan';
//            $payment_term = 'Property Payment Terms';
//            // Generate PDF with bookmarks
//            $pdf = $this->getPdf($payment_plan, $payment_term, $property, $ser_amt, $total, $full_price_calc, $down_payment, $downPaymentPercentage, $months, $settings, $rental_duration, $logoBase64, $waterMarkBase64);
//
//            return $pdf->download('payment_plan_' . $property->apartment_no . '.pdf');
//
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }

    public function downloadCalculatorResult(Request $request)
    {
        try {
            // Get property details
            $property = Properties::findOrFail($request->property_id);

            // Get settings
            $settings = Settings::first();

            // Get calculation parameters from request
            $advance_amount = $request->advance_amount;
            $hand_over_amount = $request->hand_over_amount;
            $rental_duration = $request->rental_duration;

            // Calculate payment details
            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
            $total = $property->price + $ser_amt;
            $full_price_calc = $property->price;
            $down_payment = $advance_amount;
            $hand_over_payment = $hand_over_amount;
            $pending_amt = $full_price_calc - $down_payment - $hand_over_payment;

            // Calculate percentages
            $downPaymentPercentage = ($down_payment / $full_price_calc) * 100;
            $handOverPaymentPercentage = ($hand_over_payment / $full_price_calc) * 100;
            $monthlyPercentage = (100 - $downPaymentPercentage - $handOverPaymentPercentage) / $rental_duration;

            // Generate months and payment schedule
            $cur_month = Carbon::now();
            $cur_month->startOfMonth();

            $monthlyPayment = $pending_amt / $rental_duration;

            $months = [];
            $totalPercentage = $downPaymentPercentage;
            $totalPayment = $down_payment;
            $remainingAmount = $pending_amt;

            for ($i = 0; $i < $rental_duration; $i++) {
                $remainingAmount -= $monthlyPayment;
                $totalPercentage += $monthlyPercentage;
                $totalPayment += $monthlyPayment;
                $month = $cur_month->copy()->addMonths($i+1)->format('M-y');
                $months[] = [
                    'ordinal' => $this->getOrdinalSuffix($i + 1),
                    'month' => $month,
                    'payment' => round($monthlyPayment, 2),
                    'total_payment' => round($totalPayment, 2),
                    'remaining_amount' => round($remainingAmount, 2),
                    'percentage' => round($monthlyPercentage, 2),
                    'total_percentage' => round($totalPercentage, 2)
                ];
            }

            // Get logo and convert to base64
            $logoPath = public_path('Screenshot_2025-06-14_032432.png');
            $waterMarkPath = public_path('watermark.png');

            $logoBase64 = '';
            $waterMarkBase64 = '';
            if (file_exists($logoPath)) {
                $imageData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            }
            if (file_exists($waterMarkPath)) {
                $imageData = file_get_contents($waterMarkPath);
                $waterMarkBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            }
            $payment_plan = 'Custom Payment Plan';
            $payment_term = 'Custom Payment Terms';
            // Generate PDF with bookmarks
            $unit_number =  $property->apartment_no;
            $balcony_size =  $property->balcony_size;
            $gross_area =  $property->gross_area;
            $floor_no =  $property->floor_no;
            $project_name = $property->project ? $property->project->name : '';
            $management_fees_percentage = $settings->service_charge_perc;
            $pdf = $this->getPdfCalulator($payment_plan, $payment_term, $property, $ser_amt, $total, $full_price_calc, $down_payment, $downPaymentPercentage, $months, $settings, $rental_duration, $logoBase64, $waterMarkBase64, $project_name, $hand_over_amount, $handOverPaymentPercentage,$management_fees_percentage );

            return $pdf->download('payment_calculator_' . $property->apartment_no . '.pdf');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param string $payment_plan
     * @param string $payment_term
     * @param $property
     * @param $ser_amt
     * @param $total
     * @param $full_price_calc
     * @param $down_payment
     * @param $downPaymentPercentage
     * @param array $months
     * @param $settings
     * @param $rental_duration
     * @param string $logoBase64
     * @param string $waterMarkBase64
     * @return mixed
     */
//    public function getPdf(string $payment_plan, string $payment_term, $property, $ser_amt, $total, $full_price_calc, $down_payment, $downPaymentPercentage, array $months, $settings, $rental_duration, string $logoBase64, string $waterMarkBase64, string $project_name)
//    {
//        $ppp = $project_name;
//        $pdf = PDF::loadView('front_end.pdf.payment_plan', [
//            'payment_plan' => $payment_plan,
//            'payment_note_en_part1' => 'Note: This plan is just a preview and is not considered an official final plan. The official final plan',
//            'payment_note_en_part2' => 'is generated with the contract',
//            'payment_note_ar' => 'تنويه: هذا المستند لا يعتبر جدول الدفع النهائي والمعتمد. جدول الدفع النهائي يصدر مع طباعة العقد',
//
//            'payment_term' => $payment_term,
//            'property' => $property,
//            'ser_amt' => $ser_amt,
//            'total' => $total,
//            'full_price' => $full_price_calc,
//            'down_payment' => $down_payment,
//            'downPaymentPercentage' => $downPaymentPercentage,
//            'months' => $months,
//            'settings' => $settings,
//            'rental_duration' => $rental_duration,
//            'logoBase64' => $logoBase64,
//            'waterMarkBase64' => $waterMarkBase64,
//            'project' => $project_name,
//
//        ]);
//
//        // Add bookmarks
//        $pdf->setOptions([
//            'isHtml5ParserEnabled' => true,
//            'isRemoteEnabled' => true,
//            'isPhpEnabled' => true,
//            'isFontSubsettingEnabled' => true,
//            'defaultFont' => 'Arial',
//            'bookmarks' => [
//                [
//                    'title' => 'Property Details',
//                    'level' => 0
//                ],
//                [
//                    'title' => 'Payment Terms',
//                    'level' => 0
//                ],
//                [
//                    'title' => 'Payment Schedule',
//                    'level' => 0
//                ]
//            ]
//        ]);
//        return $pdf;
//    }

    public function getPdfCalulator(string $payment_plan, string $payment_term, $property, $ser_amt, $total, $full_price_calc, $down_payment, $downPaymentPercentage, array $months, $settings, $rental_duration, string $logoBase64, string $waterMarkBase64, string $project_name, string $handOverPayment, string $handOverPaymentPercentage, string  $managment_fees_percentage)
    {
        $ppp = $project_name;
        $pdf = PDF::loadView('front_end.pdf.calculator_plan', [
            'payment_plan' => $payment_plan,
            'payment_note_en_part1' => 'Note: This plan is just a preview and is not considered an official final plan. The official final plan',
            'payment_note_en_part2' => 'is generated with the contract',
            'payment_note_ar' => 'تنويه: هذا المستند لا يعتبر جدول الدفع النهائي والمعتمد. جدول الدفع النهائي يصدر مع طباعة العقد',

            'payment_term' => $payment_term,
            'property' => $property,
            'ser_amt' => $ser_amt,
            'total' => $total,
            'full_price' => $full_price_calc,
            'full_price_handover' => $full_price_calc,
            'down_payment' => $down_payment,
            'downPaymentPercentage' => $downPaymentPercentage,
            'hand_over_amount' => $handOverPayment,
            'hand_over_percentage' => $handOverPaymentPercentage,
            'duration' => $rental_duration,
            'months' => $months,
            'settings' => $settings,
            'rental_duration' => $rental_duration,
            'logoBase64' => $logoBase64,
            'waterMarkBase64' => $waterMarkBase64,
            'project' => $project_name,
            'managment_fees_percentage' => $managment_fees_percentage

        ]);

        // Add bookmarks
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'defaultFont' => 'Arial',
            'bookmarks' => [
                [
                    'title' => 'Property Details',
                    'level' => 0
                ],
                [
                    'title' => 'Payment Terms',
                    'level' => 0
                ],
                [
                    'title' => 'Payment Schedule',
                    'level' => 0
                ]
            ]
        ]);
        return $pdf;
    }

    public function getPdf(string $payment_plan, string $payment_term, $property, $ser_amt, $total, $full_price_calc, $down_payment, $downPaymentPercentage, array $months, $settings, $rental_duration, string $logoBase64, string $waterMarkBase64, string $project_name, string $handOverPayment, string $handOverPaymentPercentage, string  $managment_fees_percentage)
    {
        $ppp = $project_name;
        $pdf = PDF::loadView('front_end.pdf.payment_plan', [
            'payment_plan' => $payment_plan,
            'payment_note_en_part1' => 'Note: This plan is just a preview and is not considered an official final plan. The official final plan',
            'payment_note_en_part2' => 'is generated with the contract',
            'payment_note_ar' => 'تنويه: هذا المستند لا يعتبر جدول الدفع النهائي والمعتمد. جدول الدفع النهائي يصدر مع طباعة العقد',

            'payment_term' => $payment_term,
            'property' => $property,
            'ser_amt' => $ser_amt,
            'total' => $total,
            'full_price' => $full_price_calc,
            'full_price_handover' => $full_price_calc,
            'down_payment' => $down_payment,
            'downPaymentPercentage' => $downPaymentPercentage,
            'hand_over_amount' => $handOverPayment,
            'hand_over_percentage' => $handOverPaymentPercentage,
            'duration' => $rental_duration,
            'months' => $months,
            'settings' => $settings,
            'rental_duration' => $rental_duration,
            'logoBase64' => $logoBase64,
            'waterMarkBase64' => $waterMarkBase64,
            'project' => $project_name,
            'managment_fees_percentage' => $managment_fees_percentage

        ]);

        // Add bookmarks
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'defaultFont' => 'Arial',
            'bookmarks' => [
                [
                    'title' => 'Property Details',
                    'level' => 0
                ],
                [
                    'title' => 'Payment Terms',
                    'level' => 0
                ],
                [
                    'title' => 'Payment Schedule',
                    'level' => 0
                ]
            ]
        ]);
        return $pdf;
    }

    public function forget_password(Request $request)
    {
        try {
            // Check if the entered email is the same as the authenticated user's email
            // No check to compare entered email with authenticated user's email as per new requirements.
            if (\Auth::check() && $request->email !== \Auth::user()->email) {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.reset_password_own_account_only')
                ]);
            }

            
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $email = $request->email;
            $user = \App\Models\User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found with this email address.'
                ]);
            }

            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store OTP in session with expiration (5 minutes)
            session([
                'forget_password_otp' => $otp,
                'forget_password_email' => $email,
                'otp_expires_at' => now()->addMinutes(5)
            ]);

            // Prepare email content
            $subject = 'Password Reset OTP - Bin Al Sheikh';
            $mailbody = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <h2 style="color: #333; margin-bottom: 10px;">Password Reset Request</h2>
                        <p style="color: #666; font-size: 16px;">Hello ' . $user->name . ',</p>
                    </div>

                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                        <p style="color: #333; font-size: 16px; margin-bottom: 15px;">
                            You have requested to reset your password. Please use the following OTP to verify your identity:
                        </p>

                        <div style="text-align: center; margin: 20px 0;">
                            <div style="display: inline-block; background: #f4e4bc; padding: 15px 30px; border-radius: 8px; font-size: 24px; font-weight: bold; color: #333; letter-spacing: 5px;">
                                ' . $otp . '
                            </div>
                        </div>

                        <p style="color: #666; font-size: 14px; margin-bottom: 10px;">
                            <strong>Important:</strong>
                        </p>
                        <ul style="color: #666; font-size: 14px; margin-left: 20px;">
                            <li>This OTP is valid for 5 minutes only</li>
                            <li>Do not share this OTP with anyone</li>
                            <li>If you did not request this password reset, please ignore this email</li>
                        </ul>
                    </div>

                    <div style="text-align: center; margin-top: 30px;">
                        <p style="color: #999; font-size: 12px;">
                            This is an automated message from Bin Al Sheikh. Please do not reply to this email.
                        </p>
                    </div>
                </div>
            ';

            // Send email using custom helper
            $emailSent = send_email($email, $subject, $mailbody);

            if ($emailSent) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP has been sent to your email address successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again later.'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ]);
        }
    }

    public function verify_forget_password_otp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp' => 'required|string|size:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $email = $request->email;
            $otp = $request->otp;

            // Check if OTP exists in session
            if (!session()->has('forget_password_otp') || !session()->has('forget_password_email')) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP session expired. Please request a new OTP.'
                ]);
            }

            // Check if email matches
            if (session('forget_password_email') !== $email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email address.'
                ]);
            }

            // Check if OTP is expired
            if (session()->has('otp_expires_at') && now()->isAfter(session('otp_expires_at'))) {
                session()->forget(['forget_password_otp', 'forget_password_email', 'otp_expires_at']);
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new OTP.'
                ]);
            }

            // Verify OTP
            if (session('forget_password_otp') !== $otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP. Please check and try again.'
                ]);
            }

            // OTP is valid - clear session and allow password reset
            session()->forget(['forget_password_otp', 'forget_password_email', 'otp_expires_at']);

            // Store verification in session for password reset
            session([
                'password_reset_verified' => true,
                'password_reset_email' => $email,
                'password_reset_expires_at' => now()->addMinutes(10)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully. You can now reset your password.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ]);
        }
    }

    public function update_forget_password(Request $request)
    {
         //$user_id = Auth::user()->id;
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'new_password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $email = $request->email;
            $newPassword = $request->new_password;

            // Check if password reset is verified
            if (!session()->has('password_reset_verified') || !session()->has('password_reset_email')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password reset session expired. Please start the process again.'
                ]);
            }

            // Check if email matches
            if (session('password_reset_email') !== $email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email address.'
                ]);
            }

            // Check if password reset is expired
            if (session()->has('password_reset_expires_at') && now()->isAfter(session('password_reset_expires_at'))) {
                session()->forget(['password_reset_verified', 'password_reset_email', 'password_reset_expires_at']);
                return response()->json([
                    'success' => false,
                    'message' => 'Password reset session has expired. Please start the process again.'
                ]);
            }

            // Find user and update password
            $user = \App\Models\User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ]);
            }

            // Update password
            $user->password = Hash::make($newPassword);
            $user->save();

            // Clear password reset session
            session()->forget(['password_reset_verified', 'password_reset_email', 'password_reset_expires_at']);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully. You can now login with your new password.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ]);
        }
    }

    /**
     * Store a new visit schedule
     * Agents (role 3) and Agencies (role 4) can create visit schedules
     */
    public function store_visit_schedule(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Check if user is authenticated
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Please login first.',
                ], 401);
            }

            // Check if user is an agent (role 3) or agency (role 4)
            if ($user->role != 3 && $user->role != 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only agents and agencies can create visit schedules.',
                ], 403);
            }

            // Determine validation rules based on user role
            $validationRules = [
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
            ];

            // Add agent selection validation for agencies
            if ($user->role == 4) {
                $validationRules['selected_agent_id'] = 'required|integer|exists:users,id';
            }

            // Validate the request
            $validator = Validator::make($request->all(), $validationRules, [
                'client_name.required' => 'Client name is required',
                'client_phone_number.required' => 'Client phone number is required',
                'client_email_address.email' => 'Please provide a valid email address',
                'client_id.file' => 'Client ID must be a file',
                'client_id.mimes' => 'Client ID file must be jpg, jpeg, png, or pdf',
                'client_id.max' => 'Client ID file size must not exceed 5MB',
                'project_id.required' => 'Project selection is required',
                'project_id.exists' => 'Selected project does not exist',
                'selected_agent_id.required' => 'Agent selection is required',
                'selected_agent_id.exists' => 'Selected agent does not exist',
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
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Determine the agent ID based on user role
            $agentId = null;
            if ($user->role == 4) {
                // Agency: Use selected agent ID
                $agentId = $request->selected_agent_id;
                
                // Verify that the selected agent belongs to this agency
                $selectedAgent = User::where('id', $agentId)
                    ->where('agency_id', $user->id)
                    ->where('role', 3)
                    ->where('active', 1)
                    ->first();
                    
                if (!$selectedAgent) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected agent is not valid or does not belong to your agency',
                    ], 403);
                }
            } else {
                // Agent: Use current user's ID
                $agentId = $user->id;
            }

            // Check if project exists and is active
            $project = \App\Models\Projects::where('id', $request->project_id)
                ->where('active', 1)
                ->where('deleted', 0)
                ->first();

            if (!$project) {
                return response()->json([
                    'success' => false,
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
            $visitDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->visit_date . ' ' . $request->visit_time);

            // Check for conflicting visit schedules for the same agent
            $existingVisit = \App\Models\VisiteSchedule::where('agent_id', $agentId)
                ->where('visit_time', $visitDateTime)
                ->first();

            if ($existingVisit) {
                return response()->json([
                    'success' => false,
                    'message' => 'The selected agent already has a visit scheduled at this time',
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
                'status' => 'scheduled', // Default status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Visit schedule created successfully',
                'data' => [
                    'id' => $visitSchedule->id,
                    'client_name' => $visitSchedule->client_name,
                    'visit_time' => $visitSchedule->visit_time->format('d-M-Y h:i A'),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating visit schedule: ' . $e->getMessage(),
            ], 500);
        }
    }
}
