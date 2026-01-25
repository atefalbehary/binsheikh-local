<?php

$config['server_mode']                  = 'live'; //live

$config['site_name']                                    = env("APP_NAME",'Rexflow');
$config['date_timezone']								= 'Asia/Kolkata';
$config['datetime_format']								= 'M d, Y h:i A';
$config['date_format']									= 'M d, Y';
$config['date_format_excel']							= 'd/m/Y';
$config['default_currency_code']						= 'AED';

$config['upload_bucket']						= 'public';//s3
$config['upload_path']              					= 'storage/';
$config['user_image_upload_dir']    					= 'users/';
$config['category_image_upload_dir']    				= 'category/';
$config['product_image_upload_dir']    				    = 'products/';
$config['banner_image_upload_dir']                      = 'banner_images/';


//order status
$config['order_status_pending']                                 = 0;
$config['order_status_accepted']                                = 1;
$config['order_status_ready_for_delivery']                      = 2;
$config['order_status_dispatched']                              = 3;
$config['order_status_delivered']                               = 4;
$config['order_status_cancelled']                               = 10;
$config['order_status_returned']                               = 11;


$config['sale_order_prefix']                                 = 'CS-';
$config['product_image_width']              			= '1024';
$config['product_image_height']              			= '1024';
$config['google_map_key']              			= 'AIzaSyDvHsIAzA2vbTbPsXdNBCTX6Xyblk2CAFE';


$config['days'] = array(
    'sun'=>'sunday',
    'mon'=>'monday',
    'tues'=>'tuesday',
    'wed'   =>'wednesday',
    'thurs'=>'thursday',
    'fri'=>'friday',
    'sat'=>'saturday'
);
return $config;
?>
