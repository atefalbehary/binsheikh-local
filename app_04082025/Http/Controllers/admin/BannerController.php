<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use Illuminate\Http\Request;
use Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_heading = "Banners";
        $filter = [];
        $params = [];
        $params['search_key'] = $_GET['search_key'] ?? '';
        $search_key = $params['search_key'];
        $list = BannerModel::get_banners_list($filter, $params)->paginate(10);

        return view("admin.banner.list", compact("page_heading", "list", "search_key"));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $status = "0";
            $message = "";
            $errors = '';
            $validator = Validator::make($request->all(),
                [
                    'banner' => 'required|image',
                ],
                [
                    'banner.required' => 'Banner required',
                    'banner.image' => 'should be in image format (.jpg,.jpeg,.png)',
                ]
            );
            if ($validator->fails()) {
                $status = "0";
                $message = "Validation error occured";
                $errors = $validator->messages();
            } else {
                $ins['active'] = $request->active;
                $ins['banner_title'] = $request->banner_title;
                $ins['banner_sub_title'] = $request->banner_sub_title;
                $ins['banner_link'] = $request->banner_link;

                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                if ($file = $request->file("banner")) {
                    $dir = config('global.upload_path') . config('global.banner_image_upload_dir');
                    $file_name = time() . uniqid() . "_banner." . $file->getClientOriginalExtension();
                    $file->move($dir, $file_name);
                    $ins['banner_image'] = $file_name;
                }
                if (BannerModel::insert($ins)) {

                    $status = "1";
                    $message = "Banner created";
                    $errors = '';
                } else {
                    $status = "0";
                    $message = "Something went wrong";
                    $errors = '';
                }
            }
            echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
        } else {
            $page_heading = "Create Banner";
            return view('admin.banner.create', compact('page_heading'));
        }

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (BannerModel::where('id', $request->id)->update(['active' => $request->status])) {
            $status = "1";
            $msg = "Successfully activated";
            if (!$request->status) {
                $msg = "Successfully deactivated";
            }
            $message = $msg;
        } else {
            $message = "Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }
    public function edit($id = '')
    {
        $banner = BannerModel::find($id);
        if ($banner) {
            $page_heading = "Edit Banner";
            return view('admin.banner.edit', compact('page_heading', 'banner'));
        } else {
            abort(404);
        }
    }

    public function update(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = '';
        $validator = Validator::make($request->all(),
            [
                // 'banner_title' => 'required',
                'banner' => 'image',
            ],
            [
                // 'banner_title.required' => 'Title required',
                'banner.image' => 'should be in image format (.jpg,.jpeg,.png)',
            ]
        );
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {

            $ins['active'] = $request->active;
            $ins['banner_title'] = $request->banner_title;
            $ins['banner_sub_title'] = $request->banner_sub_title;
            $ins['banner_link'] = $request->banner_link;

            $ins['updated_at'] = gmdate('Y-m-d H:i:s');
            if ($file = $request->file("banner")) {
                $dir = config('global.upload_path') . config('global.banner_image_upload_dir');
                $file_name = time() . uniqid() . "_banner." . $file->getClientOriginalExtension();
                $file->move($dir, $file_name);
                $ins['banner_image'] = $file_name;
            }
            if (BannerModel::where('id', $request->id)->update($ins)) {

                $status = "1";
                $message = "Banner updated";
                $errors = '';
            } else {
                $status = "0";
                $message = "Something went wrong";
                $errors = '';
            }
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
    }

    public function delete($id = '')
    {
        BannerModel::where('id', $id)->delete();
        $status = "1";
        $message = "Banner removed successfully";
        echo json_encode(['status' => $status, 'message' => $message]);
    }

}
