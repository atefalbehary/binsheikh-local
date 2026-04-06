<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;
use Validator;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Pages";
        $search_text = $_GET['search_text'] ?? '';
        $pages = Pages::where(['pages.deleted' => 0])->orderBy('pages.created_at', 'desc');
        if ($search_text) {
            $pages = $pages->whereRaw("(pages.name like '%$search_text%')");
        }
        $pages = $pages->paginate(10);
        return view('admin.page.list', compact('page_heading', 'pages', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'name_es' => 'required',
            'description' => 'required',
            'description_es' => 'required',
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $input = $request->all();

            $ins = [
                'name' => $request->name,
                'description' => $request->description,
                'name_es' => $request->name_es,
                'description_es' => $request->description_es,
                'active' => $request->active,

                'mission_es' => $request->mission_es ?? '',
                'mission' => $request->mission ?? '',
                'values_es' => $request->values_es ?? '',
                'values' => $request->values ?? '',
            ];

            if ($request->file("banner_image")) {
                $response = image_upload($request, 'pages/banner_images', 'banner_image');
                if ($response['status']) {
                    $ins['banner_image'] = $response['link'];
                }
            }

            if ($request->file("image")) {
                $response = image_upload($request, 'pages/image', 'image');
                if ($response['status']) {
                    $ins['image'] = $response['link'];
                }
            }

            if ($request->id != "") {
                $page = Pages::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                // $ins['slug'] = Pages::getSlug($request->name, $request->id);
                $page->update($ins);
                $status = "1";
                $message = "Page updated succesfully";
            } else {
                // $ins['created_at'] = gmdate('Y-m-d H:i:s');
                // $ins['slug'] = Pages::getSlug($request->name);
                // $pkg = Pages::create($ins);
                // $pakg_id = $pkg->id;
                // $status = "1";
                // $message = "Page added successfully";
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

        $page = Pages::find($id);
        if ($page) {
            $page_heading = "Pages";
            $mode = "edit";
            $id = $page->id;
            $active = $page->active;
            $slug = $page->slug;
            $banner_image = $page->banner_image;
            $image = $page->image;

            $name = $page->name;
            $description = $page->description;

            $mission_es = $page->mission_es;
            $mission = $page->mission;
            $values_es = $page->values_es;
            $values = $page->values;

            $name_es = $page->name_es;
            $description_es = $page->description_es;

            return view("admin.page.create", compact('page_heading', 'mode', 'id', 'name', 'description', 'active', 'name_es', 'description_es', 'slug', 'image', 'banner_image','mission_es','mission','values_es','values'));
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

        $page = Pages::find($id);
        if ($page) {
            $page->deleted = 1;
            $page->active = 0;
            $page->updated_at = gmdate('Y-m-d H:i:s');
            $page->save();
            $status = "1";
            $message = "Page removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Pages::where('id', $request->id)->update(['active' => $request->status])) {
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
