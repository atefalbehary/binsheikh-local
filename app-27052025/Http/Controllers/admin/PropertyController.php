<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Categories;
use App\Models\Projects;
use App\Models\Properties;
use App\Models\PropertyAmenities;
use App\Models\PropertyFaq;
use App\Models\PropertyImages;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Properties";
        $search_text = $_GET['search_text'] ?? '';
        $sale_type = $_GET['sale_type'] ?? '';
        $project_id = $_GET['project_id'] ?? '';
        
        $properties = Properties::with('project')->where(['properties.deleted' => 0])->orderBy('properties.created_at', 'desc');
        if ($search_text) {
            $properties = $properties->whereRaw("(properties.name like '%$search_text%' OR apartment_no like '%$search_text%')");
        }
        if ($sale_type) {
            $properties = $properties->where("sale_type",$sale_type);
        }
        if ($project_id) {
            $properties = $properties->where("project_id",$project_id);
        }
        
        $properties = $properties->paginate(10);
        $projects = Projects::select('id','name')->where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
        return view('admin.property.list', compact('page_heading', 'properties', 'search_text','sale_type','projects','project_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Properties";
        $mode = "create";
        $id = "";
        $images = [];
        $faq = [];
        $categories = Categories::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
        $projects = Projects::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
        $amenities = Amenities::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
        return view("admin.property.create", compact('page_heading', 'mode', 'id', 'amenities', 'categories', 'images', 'faq','projects'));
    }

    public function store(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'short_description' => 'required',
            
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $input = $request->all();
            $ins = [
                'name' => $request->name,
                'name_ar' => $request->name_ar,
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'short_description' => $request->short_description,
                'short_description_ar' => $request->short_description_ar,
                'active' => $request->active,
                'category' => $request->category,

                'location' => $request->location,
                'location_ar' => $request->location_ar,
                'price' => $request->price,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'area' => $request->area,
                'parking' => '',//$request->parking,
                'location_link' => $request->location_link,
                'sale_type' => $request->sale_type,
                'apartment_no' => $request->apartment_no,
                'project_id' => $request->project_id,
                'link_360' =>  $request->link_360,
                'unit_layout' =>  $request->unit_layout,
                'video_link' =>  $request->video_link,
                'is_recommended' => isset($request->is_recommended) ? 1 : 0,

                'balcony_size' =>  $request->balcony_size,
                'gross_area' =>  $request->gross_area,
                'floor_no' =>  $request->floor_no,
                'meta_title' =>  $request->meta_title,
                'meta_title_ar' =>  $request->meta_title_ar,
                'meta_description' =>  $request->meta_description,
                'meta_description_ar' =>  $request->meta_description_ar,
            ];

            $imgs = [];
            $images = $request->file('images');
            if ($images) {
                // foreach ($images as $file) {
                //     $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                //     $path = public_path() . '/uploads/property/';
                //     $file->move($path, $name);
                //     $imgs[] = '/uploads/property/' . $name;
                // }
                foreach ($images as $file) {
                    $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = '/uploads/property/' . $name;
                    Storage::disk('s3')->put($path, fopen($file, 'r+')); 
                    $imgs[] = '/'.$path;
                }
            }
            if ($request->file("broucher")) {
                $response = image_upload($request, 'property/broucher', 'broucher');
                if ($response['status']) {
                    $ins['broucher'] = $response['link'];
                }
            }

            if ($request->file("floor_plan")) {
                $response = image_upload($request, 'property/floor_plan', 'floor_plan');
                if ($response['status']) {
                    $ins['floor_plan'] = $response['link'];
                }
            }
            // if ($request->file("video")) {
            //     $response = image_upload($request, 'property/video', 'video');
            //     if ($response['status']) {
            //         $ins['video'] = $response['link'];
            //     }
            // }
            $ins['video'] = '';
            if ($request->file("video_thumbnail")) {
                $response = image_upload($request, 'property/video_thumbnail', 'video_thumbnail');
                if ($response['status']) {
                    $ins['video_thumbnail'] = $response['link'];
                }
            }
            
            

            if ($request->id != "") {
                $prpty_id = $request->id;
                $property = Properties::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Properties::getSlug($request->name, $request->id);
                $property->update($ins);
                $status = "1";
                $message = "Property updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Properties::getSlug($request->name);
                $prd = Properties::create($ins);
                $prpty_id = $prd->id;
                $status = "1";
                $message = "Property added successfully";
            }
            if ($request->id) {
                PropertyAmenities::where('property_id', $prpty_id)->delete();
                PropertyFaq::where('property_id', $prpty_id)->delete();
            }
            $amnties = $request->amenities;
            foreach ($amnties as $key => $val) {
                $inc['property_id'] = $prpty_id;
                $inc['amenity_id'] = $val;
                PropertyAmenities::create($inc);
            }

            // $iti_title = $request->faq_title;
            // $iti_title_ar = $request->faq_title_ar;
            // $iti_description = $request->faq_description;
            // $iti_description_ar = $request->faq_description_ar;
            // foreach ($iti_title as $key => $val) {
            //     $iti['property_id'] = $prpty_id;
            //     $iti['title'] = $val;
            //     $iti['title_ar'] = $iti_title_ar[$key];
            //     $iti['description'] = $iti_description[$key];
            //     $iti['description_ar'] = $iti_description_ar[$key];
            //     PropertyFaq::create($iti);
            // }
            foreach ($imgs as $img) {
                $im['property_id'] = $prpty_id;
                $im['image'] = $img;
                PropertyImages::create($im);
            }

        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $property = Properties::with('amenities')->find($id);
        if ($property) {
            $page_heading = "Properties";
            $mode = "edit";
            $images = PropertyImages::where('property_id', $id)->get();
            $amenities = Amenities::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
            $categories = Categories::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
            $faq = PropertyFaq::where('property_id', $id)->orderBy('id', 'asc')->get();
            $projects = Projects::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
            return view("admin.property.create", compact('page_heading', 'mode', 'id', 'property', 'images', 'categories', 'amenities', 'faq','projects'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $property = Properties::find($id);
        if ($property) {
            $property->deleted = 1;
            $property->active = 0;
            $property->updated_at = gmdate('Y-m-d H:i:s');
            $property->save();
            $status = "1";
            $message = "Property removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Properties::where('id', $request->id)->update(['active' => $request->status])) {
            $status = "1";
            $msg = "Successfully activated";
            if (!$request->status) {
                $msg = "Successfully deactivated";
            }
            $message = $msg;
        } else {
            $message = "Sorry!.. Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }

    public function delete_image($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $property = PropertyImages::find($id);
        if ($property) {
            $property->delete();
            $status = "1";
            $message = "Image removed successfully";
        } else {
            $message = "Sorry!.. Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }

}
