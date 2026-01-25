<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    use HasFactory;
    protected $table = "banners";
    protected $primaryKey = "id";
    public $timestamps = true;

    
    public function getLogoAttribute($value)
    {
        if($value)
        {
            return asset($value);
        }
        else
        {
            return '';
        }
    }
    public static function get_banners_list($where=[],$params=[]){
        $banners = BannerModel::where($where)->orderBy('created_at','desc');
            
        if( !empty($params) ){
            if(isset($params['search_key']) && $params['search_key'] != ''){
                $banners->Where('banner_title','like','%'.$params['search_key'].'%');
            }
        }
        return $banners;
    } 
    public function getBannerImageAttribute($value)
    {
        if($value)
        {
            return get_uploaded_image_url($value,'banner_image_upload_dir');
            return asset($value);
        }
        else
        {
            return '';
        }
    }
}
