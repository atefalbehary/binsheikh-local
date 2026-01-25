<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Folder;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Folders";
        $list = Folder::where(['deleted' => 0])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.folders.list', compact('page_heading', 'list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Folders";
        $mode = "create";
        $id = "";

        return view("admin.folders.create", compact('page_heading', 'mode', 'id'));
    }

    public function store(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';
        //Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'title_ar' => 'required',
            'cover_image' => 'required',
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $input = $request->all();
            Log::info($input);
            $ins = [
                'title' => $request->title,
                'title_ar' => $request->title_ar,
                'is_pinned' =>isset($request->is_pinned) ? 1 : 0,
            ];
            $ins['cover_image'] = '';
            if ($request->file('cover_image')) {
                Log::info("--");
                $response = image_upload($request, 'folder/image', 'cover_image');
                if ($response['status']) {
                    $ins['cover_image'] = $response['link'];
                }
            }
            if ($request->id != "") {
                $data = Folder::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $data->update($ins);
                $status = "1";
                $message = "Folder updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $res = Folder::create($ins);
                $status = "1";
                $message = "Folder added successfully";
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
        Log::info($id);
        $status = "0";
        $message = "";
        $o_data = [];
        $related = false;
        $data = Folder::find($id);
        $videos = Video::where('folder_id',$id)->get();
        if($videos->isNotEmpty()) $related = true;

        $blogs = Blog::where('folder_id',$id)->get();
        if($blogs->isNotEmpty()) $related = true;

        $photos = Photo::where('folder_id',$id)->get();
        if($photos->isNotEmpty()) $related = true;

        if ($data && !$related) {
            $data->deleted = 1;
            //$data->active = 0;
            $data->updated_at = gmdate('Y-m-d H:i:s');
            $data->save();
            $status = "1";
            $message = "Video removed successfully";
        }elseif($related) {
            $message = "The Folder contain some media!!";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Folder::where('id', $request->id)->update(['is_pinned' => $request->status])) {
            $status = "1";
            $msg = "Successfully updated";
            if (!$request->status) {
                $msg = "Successfully updated";
            }
            $message = $msg;
        } else {
            $message = "Sorry!.. Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }

    public function deleteAll(Request $request)
    {
        //Log::info($request->all());
        if ($request->has('delete_all_id')) {
            $ids = explode(',', $request->delete_all_id);

            Video::whereIn('id', $ids)->delete();

            return redirect()->back()->with('success', 'Selected Videos deleted successfully.');
        }
        return redirect()->back()->with('error', 'No Video selected.');

    }
}
