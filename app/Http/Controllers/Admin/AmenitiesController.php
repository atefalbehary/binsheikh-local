<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use Validator;

class AmenitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Amenities";
        $search_text = $_GET['search_text'] ?? '';
        $amenities = Amenities::where(['amenities.deleted' => 0])->orderBy('amenities.created_at', 'desc');
        if ($search_text) {
            $amenities = $amenities->whereRaw("(amenities.name like '%$search_text%')");
        }
        $amenities = $amenities->get();
        return view('admin.amenities.list', compact('page_heading', 'amenities', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Amenities";
        $mode = "create";
        $id = "";
    
        return view("admin.amenities.create", compact('page_heading', 'mode', 'id'));
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
            'name_ar' => 'required',
            'icon' => 'required',
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
                'icon' => $request->icon,
                'active' => $request->active,
            ]; 
            if ($request->file("icon_image")) {
                $response = image_upload($request, 'amenities/icon_image', 'icon_image');
                if ($response['status']) {
                    $ins['icon_image'] = $response['link'];
                }
            }          
            if ($request->id != "") {
                $amenities = Amenities::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $amenities->update($ins);
                $status = "1";
                $message = "Amenity updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $res = Amenities::create($ins);
                $status = "1";
                $message = "Amenity added successfully";
            }
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }
    public function edit($id)
    {

        $amenities = Amenities::find($id);
        if ($amenities) {
            $page_heading = "Amenities";
            $mode = "edit";
            $id = $amenities->id;
            return view("admin.amenities.create", compact('page_heading', 'mode', 'id','amenities'));
        } else {
            abort(404);
        }
    }

    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $amenities = Amenities::find($id);
        if ($amenities) {
            $amenities->deleted = 1;
            $amenities->active = 0;
            $amenities->updated_at = gmdate('Y-m-d H:i:s');
            $amenities->save();
            $status = "1";
            $message = "Amenity removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Amenities::where('id', $request->id)->update(['active' => $request->status])) {
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

}
