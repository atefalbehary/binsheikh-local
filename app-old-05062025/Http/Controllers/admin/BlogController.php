<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Blog";
        $search_text = $_GET['search_text'] ?? '';
        $blog = Blog::where(['deleted' => 0])->orderBy('created_at', 'desc');
        if ($search_text) {
            $blog = $blog->whereRaw("(name like '%$search_text%')");
        }
        $cat = $blog->get();
        // dd($blog);
        return view('admin.blog.list', compact('page_heading', 'cat', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Blog";
        $mode = "create";
        $id = "";
        $name = "";
        $name_ar = "";
        $description = "";
        $description_ar = "";
        $short_description = "";
        $short_description_ar = "";

        
        $image = "";
        $active = "1";

        return view("admin.blog.create", compact('page_heading', 'mode', 'id', 'name', 'active', 'name_ar','description','description_ar','image','short_description','short_description_ar'));
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
            'description' => 'required',
            'description_ar' => 'required',
            'short_description' => 'required',
            'short_description_ar' => 'required',
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
                'active' => $request->active,
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'short_description' => $request->short_description,
                'short_description_ar' => $request->short_description_ar,
            ];
            if ($request->file("image")) {
                $response = image_upload($request, 'blog', 'image');
                if ($response['status']) {
                    $ins['image'] = $response['link'];
                }
            }
           
            if ($request->id != "") {
                $dest_id = $request->id;
                $blog = Blog::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Blog::getSlug($request->name, $request->id);
                $blog->update($ins);
                $status = "1";
                $message = "Blog updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Blog::getSlug($request->name);
                $prd = Blog::create($ins);
                $dest_id = $prd->id;
                $status = "1";
                $message = "Blog added successfully";
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

        $blog = Blog::find($id);
        if ($blog) {
            $page_heading = "Blog";
            $mode = "edit";
            $id = $blog->id;

            $name = $blog->name;
            $name_ar = $blog->name_ar;
            
            $active = $blog->active;
            $description = $blog->description;
            $description_ar = $blog->description_ar;

            $short_description = $blog->short_description;
            $short_description_ar = $blog->short_description_ar;

            $image = $blog->image;


            return view("admin.blog.create", compact('page_heading', 'mode', 'id', 'name', 'name_ar', 'active','description','description_ar','image','short_description','short_description_ar'));
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

        $blog = Blog::find($id);
        if ($blog) {
            $blog->deleted = 1;
            $blog->active = 0;
            $blog->updated_at = gmdate('Y-m-d H:i:s');
            $blog->save();
            $status = "1";
            $message = "Blog removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Blog::where('id', $request->id)->update(['active' => $request->status])) {
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
