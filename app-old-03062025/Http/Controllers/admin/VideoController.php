<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Videos";
        $list = Video::where(['deleted' => 0])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.videos.list', compact('page_heading', 'list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Videos";
        $mode = "create";
        $id = "";
    
        return view("admin.videos.create", compact('page_heading', 'mode', 'id'));
    }

    public function store(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            'link' => 'required',
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $input = $request->all();

            $ins = [
                'link' => $request->link,
                'active' => $request->active,
            ];           
            if ($request->id != "") {
                $data = Video::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $data->update($ins);
                $status = "1";
                $message = "Video updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $res = Video::create($ins);
                $status = "1";
                $message = "Video added successfully";
            }
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }
    public function edit($id)
    {

        $data = Video::find($id);
        if ($data) {
            $page_heading = "Video";
            $mode = "edit";
            $id = $data->id;
            return view("admin.videos.create", compact('page_heading', 'mode', 'id','data'));
        } else {
            abort(404);
        }
    }

    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $data = Video::find($id);
        if ($data) {
            $data->deleted = 1;
            $data->active = 0;
            $data->updated_at = gmdate('Y-m-d H:i:s');
            $data->save();
            $status = "1";
            $message = "Video removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Video::where('id', $request->id)->update(['active' => $request->status])) {
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
