<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Storage;
function check_permission($module, $permission)
{
    $userid = Auth::user()->id;
    $privilege = $privilege = 1;
    return $privilege;
}
if (!function_exists('get_storage_path')) {
    function get_storage_path($filename = '', $dir = '')
    {
        if (!empty($filename)) {

            $upload_dir = config('global.upload_path');
            if (!empty($dir)) {
                $dir = config("global.{$dir}");
            }
            if (\Storage::disk(config('global.upload_bucket'))->exists($dir . $filename)) {
                return \Storage::url("{$dir}{$filename}");
            }
        }

        return '';
    }
}
if (!function_exists('get_uploaded_image_url')) {
    function get_uploaded_image_url($filename = '', $dir = '', $default_file = 'placeholder.png')
    {

        if (!empty($filename)) {

            $upload_dir = config('global.upload_path');
            if (!empty($dir)) {
                $dir = config("global.{$dir}");

            }

            if (\Storage::disk(config('global.upload_bucket'))->exists($dir . $filename)) {
                return \Storage::disk(config('global.upload_bucket'))->url($dir . $filename);
                //return asset(\Storage::url("{$dir}{$filename}"));
            } else {

                return asset(\Storage::url("{$dir}{$filename}"));
            }
        }
        if (!empty($default_file)) {
            if (!empty($dir)) {
                $dir = config("global.{$dir}");
            }
            $default_file = asset(\Storage::url("{$dir}{$default_file}"));
        }
        if (!empty($default_file)) {
            return $default_file;
        }

        return \Storage::url("logo.png");
    }
}
if (!function_exists('time_ago')) {
    function time_ago($datetime, $now = null, $timezone = 'Etc/GMT')
    {
        if (!$now) {
            $now = time();
        }
        $timezone_user = new DateTimeZone($timezone);
        $date = new DateTime($datetime, $timezone_user);
        $timestamp = $date->getTimestamp();
        $timespan = explode(', ', timespan($timestamp, $now));
        $timespan = $timespan[0] ?? '';
        $timespan = strtolower($timespan);

        if (!empty($timespan)) {
            if (stripos($timespan, 'second') !== false) {
                $timespan = 'few seconds ago';
            } else {
                $timespan .= " ago";
            }
        }

        return $timespan;
    }
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (!function_exists('get_date_in_timezone')) {
    function get_date_in_timezone($date, $format = "d-M-Y h:i a", $timezone = '', $server_time_zone = "Etc/GMT")
    {
        if ($timezone == '') {
            $timezone = config('global.date_timezone');
        }
        try {
            $timezone_server = new DateTimeZone($server_time_zone);
            $timezone_user = new DateTimeZone($timezone);
        } catch (Exception $e) {
            $timezone_server = new DateTimeZone($server_time_zone);
            $timezone_user = new DateTimeZone($server_time_zone);
        }

        $dt = new DateTime($date, $timezone_server);

        $dt->setTimezone($timezone_user);

        return $dt->format($format);
    }
}
function public_url()
{
    if (config('app.url') == 'http://127.0.0.1:8000') {
        return str_replace('/public', '', config('app.url'));
    }
    return config('app.asset_url');
}
function moneyFormat($amount){
    $currency = session()->get('currency');
    $currency_rate = session()->get('currency_rate');
    if($currency=="QAR" || !$currency){
        $currency = "QR";
    }
    if(!$currency_rate){
        $currency_rate = 1;
    }
    $amount = $amount*$currency_rate;
    if (floor($amount) == $amount) {
        return $currency.' '.number_format($amount, 0, '.', ',');
    } else {
        return $currency.' '.number_format($amount, 2, '.', ',');
    }
}

function image_upload($request, $model, $file_name, $mb_file_size = 2500)
{
    if (empty($model)) {
        $model = 'category';
    }

    if ($request->file($file_name)) {
        $file = $request->file($file_name);
        return file_save($file, $model, $mb_file_size);
    }
    return ['status' => false, 'link' => null, 'message' => 'Unable to upload file'];
}

if (!function_exists('array_combination')) {
    function array_combination($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = array_combination($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                array_merge(array($v), $t) :
                array($v, $t);
            }
        }

        return $result;
    }
}

// function file_save($file, $model, $mb_file_size = 25000)
// {
//     try {
//         // $model = str_replace('/', '', $model);
//         //validateSize
//         $precision = 2;
//         $size = $file->getSize();
//         $size = (int) $size;
//         $base = log($size) / log(1024);
//         $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
//         $dSize = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

//         $aSizeArray = explode(' ', $dSize);
//         if ($aSizeArray[0] > $mb_file_size && ($aSizeArray[1] == 'MB' || $aSizeArray[1] == 'GB' || $aSizeArray[1] == 'TB')) {
//             return ['status' => false, 'link' => null, 'message' => 'Image size should be less than equal ' . $mb_file_size . ' MB'];
//         }
//         // rename & upload files to upload folder
//         $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
//         $path = public_path() . '/uploads/' . $model . '/';
//         $file->move($path, $name);

//         $image_url = '/uploads/' . $model . '/' . $name;

//         return ['status' => true, 'link' => $image_url, 'message' => 'file uploaded'];

//     } catch (\Exception $e) {
//         return ['status' => false, 'link' => null, 'message' => $e->getMessage()];
//     }
// }

function file_save($file, $model, $mb_file_size = 25000)
{
    try {
        // Validate file size
        $precision = 2;
        $size = $file->getSize();
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        $dSize = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

        $aSizeArray = explode(' ', $dSize);
        if ($aSizeArray[0] > $mb_file_size && ($aSizeArray[1] == 'MB' || $aSizeArray[1] == 'GB' || $aSizeArray[1] == 'TB')) {
            return ['status' => false, 'link' => null, 'message' => 'Image size should be less than or equal to ' . $mb_file_size . ' MB'];
        }

        // Generate unique file name
        $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Upload file to S3
        $path = 'uploads/' . $model . '/' . $name;  // Define the S3 path
        $uploaded = Storage::disk('s3')->put($path, fopen($file, 'r+'));  // Store file on S3

        // Check if upload was successful
        if (!$uploaded) {
            return ['status' => false, 'link' => null, 'message' => 'Failed to upload file to S3'];
        }

        // Get the public URL of the uploaded file
        // $image_url = Storage::disk('s3')->url($path);
        $image_url = $path;

        return ['status' => true, 'link' => $image_url, 'message' => 'File uploaded successfully'];

    } catch (\Exception $e) {
        dd($e->getMessage());
        return ['status' => false, 'link' => null, 'message' => $e->getMessage()];
    }
}
function aws_asset_path($path){
    $path = ltrim($path, '/');
    return "https://cdn.bsbqa.com/".$path;
}
if (!function_exists('deleteFile')) {
    function deleteFile($path)
    {
        try {
            $root_path = base_path() . $path;
            if (file_exists($root_path)) {
                unlink($root_path);
            }

        } catch (\Exception $e) {
            return false;
        }
    }
}

function printr($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}
function url_title($str, $separator = '-', $lowercase = false)
{
    if ($separator == 'dash') {
        $separator = '-';
    } else if ($separator == 'underscore') {
        $separator = '_';
    }

    $q_separator = preg_quote($separator);

    $trans = array(
        '&.+?;' => '',
        '[^a-z0-9 _-]' => '',
        '\s+' => $separator,
        '(' . $q_separator . ')+' => $separator,
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val) {
        $str = preg_replace("#" . $key . "#i", $val, $str);
    }

    if ($lowercase === true) {
        $str = strtolower($str);
    }

    return trim($str, $separator);
}

function send_email($to, $subject, $mailbody)
{

    require base_path("vendor/autoload.php");
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "binalsheikhtower25@gmail.com";
        $mail->Password = "paujbczfsyqcuiru";
        $mail->SMTPSecure = "STARTTLS";
        $mail->Port = 587;
        $mail->setFrom("binalsheikhtower25@gmail.com", "Bin Al Sheikh");
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $mailbody;
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );
        if (!$mail->send()) {
            // dd($e->getMessage());
            return 0;
        } else {
            return 1;
        }
    } catch (Exception $e) {
        // dd($e->getMessage());
        return 0;
    }
}

function convert_all_elements_to_string($data = null)
{
    if ($data != null) {
        array_walk_recursive($data, function (&$value, $key) {
            if (!is_object($value)) {
                if ($value) {
                    $value = (string) $value;
                } else {
                    $value = (string) $value;
                }
            } else {
                $json = json_encode($value);
                $array = json_decode($json, true);

                array_walk_recursive($array, function (&$obj_val, $obj_key) {
                    $obj_val = (string) $obj_val;
                });

                if (!empty($array)) {
                    $json = json_encode($array);
                    $value = json_decode($json);
                } else {
                    $value = [];
                }
            }
        });
    }
    return $data;
}
function thousandsCurrencyFormat($num)
{

    if ($num > 1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }

    return $num;
}
function order_status($id)
{
    $status_string = "Order Placed";
    if ($id == 1) {
        $status_string = 'Order Accepted';
    }
    if ($id == 2) {
        $status_string = 'Assigned Delivery Boy';
    }
    if ($id == 3) {
        $status_string = 'Ready for Delivery';
    }
    if ($id == 4) {
        $status_string = 'Order Dispatched';
    }
    if ($id == 5) {
        $status_string = 'Order Delivered';
    }
    if ($id == 6) {
        $status_string = 'Order Cancelled';
    }
    if ($id == 7) {
        $status_string = 'Order Rejected';
    }
    if ($id == 8) {
        $status_string = 'Delivery Started';
    }
    if ($id == 9) {
        $status_string = 'Order Cancelled By Delivery Boy';
    }
    return $status_string;
}
function order_pay_status($id)
{
    $status_string = "Pending";
    if ($id == 1) {
        $status_string = 'Paid';
    }
    if ($id == 2) {
        $status_string = 'Failed';
    }
    if ($id == 3) {
        $status_string = 'Cancelled, Refunded to Wallet';
    }
    if ($id == 4) {
        $status_string = 'Cancelled';
    }
    return $status_string;
}

function encryptor($string)
{
    $output = false;

    $encrypt_method = "AES-128-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number

    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;
}

function decryptor($string)
{
    $output = false;

    $encrypt_method = "AES-128-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //decrypt the given text/string/number
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

    return $output;
}

function image_link($image, $directory)
{
    if ($image != "") {
        return url(config('global.upload_path') . $directory . $image);

    }
}

if (!function_exists('web_date_in_timezone')) {
    function web_date_in_timezone($date, $format = "d M Y h:i A", $server_time_zone = "Etc/GMT")
    {
        $timezone = session('user_timezone');
        if (!$timezone) {
            $timezone = $server_time_zone;
        }
        $timezone_server = new DateTimeZone($server_time_zone);
        $timezone_user = new DateTimeZone($timezone);
        $dt = new DateTime($date, $timezone_server);
        $dt->setTimezone($timezone_user);
        return $dt->format($format);
    }
}

if (!function_exists('api_date_in_timezone')) {
    function api_date_in_timezone($date, $format, $timezone='Asia/kolkata', $server_time_zone = "Etc/GMT")
    {
        if (empty($format)) {
            $format = "d M Y h:i A";
        }

        $timezone_server = new DateTimeZone($server_time_zone);
        $timezone_user = new DateTimeZone($timezone);
        $dt = new DateTime($date, $timezone_server);
        $dt->setTimezone($timezone_user);
        return $dt->format($format);
    }
}

function removeNamespaceFromXML($xml)
{
    // Because I know all of the the namespaces that will possibly appear in
    // in the XML string I can just hard code them and check for
    // them to remove them
    $toRemove = ['rap', 'turss', 'crim', 'cred', 'j', 'rap-code', 'evic'];
    // This is part of a regex I will use to remove the namespace declaration from string
    $nameSpaceDefRegEx = '(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?';

    // Cycle through each namespace and remove it from the XML string
    foreach ($toRemove as $remove) {
        // First remove the namespace from the opening of the tag
        $xml = str_replace('<' . $remove . ':', '<', $xml);
        // Now remove the namespace from the closing of the tag
        $xml = str_replace('</' . $remove . ':', '</', $xml);
        // This XML uses the name space with CommentText, so remove that too
        $xml = str_replace($remove . ':commentText', 'commentText', $xml);
        // Complete the pattern for RegEx to remove this namespace declaration
        $pattern = "/xmlns:{$remove}{$nameSpaceDefRegEx}/";
        // Remove the actual namespace declaration using the Pattern
        $xml = preg_replace($pattern, '', $xml, 1);
    }

    // Return sanitized and cleaned up XML with no namespaces
    return $xml;
}

function namespacedXMLToArray($xml)
{
    // One function to both clean the XML string and return an array
    return json_decode(json_encode(simplexml_load_string(removeNamespaceFromXML($xml))), true);
}

function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&key=AIzaSyDZuYyGb9tmL4p2mqSbgt5yp1pishELFO0";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = '';
    $time = '';
    $dist_in_meter = '';

    if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
        $dist_in_meter = $response_a['rows'][0]['elements'][0]['distance']['value'];

    }
    return array('distance' => $dist, 'time' => $time, 'dist_in_meter' => $dist_in_meter);
}
