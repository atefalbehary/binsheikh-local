<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Photo;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Photos";
        $list = Photo::where(['deleted' => 0])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.photos.list', compact('page_heading', 'list'));
    }
    public function create()
    {

        $page_heading = "Photos";
        $folders = Folder::all();
        return view("admin.photos.create", compact('page_heading','folders'));
    }

    public function store(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';
        $gallery = $request->file('gallery');
        if ($gallery) {
            // foreach ($gallery as $file) {
            //     $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            //     $path = public_path() . '/uploads/gallery/photos';
            //     $file->move($path, $name);
            //     $im['created_at'] = gmdate('Y-m-d H:i:s');
            //     $im['image'] = '/uploads/gallery/photos/' . $name;
            //     Photo::create($im);
            // }
            foreach ($gallery as $file) {
                Log::info($request->folder_id );
                $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = '/uploads/gallery/photos/' . $name;
                Storage::disk('s3')->put($path, fopen($file, 'r+'));
                $im['created_at'] = gmdate('Y-m-d H:i:s');
                $im['image'] = '/uploads/gallery/photos/' . $name;
                $im['folder_id'] = ($request->folder_id != '')?$request->folder_id:NULL;
                Photo::create($im);
            }
        }
        $status = "1";
        $message = "Succesfully uploaded";
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }

    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $photos = Photo::find($id);
        if ($photos) {
            $photos->deleted = 1;
            $photos->active = 0;
            $photos->updated_at = gmdate('Y-m-d H:i:s');
            $photos->save();
            $status = "1";
            $message = "Photo removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Photo::where('id', $request->id)->update(['active' => $request->status])) {
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

    public function deleteAll(Request $request)
    {
        //Log::info($request->all());
        if ($request->has('delete_all_id')) {
            $ids = explode(',', $request->delete_all_id);

            Photo::whereIn('id', $ids)->delete();

            return redirect()->back()->with('success', 'Selected photos deleted successfully.');
        }
        return redirect()->back()->with('error', 'No photo selected.');

    }

}
