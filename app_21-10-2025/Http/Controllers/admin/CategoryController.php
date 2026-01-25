<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Property Types";
        $search_text = $_GET['search_text'] ?? '';
        $categories = Categories::where(['categories.deleted' => 0])->orderBy('categories.created_at', 'desc');
        if ($search_text) {
            $categories = $categories->whereRaw("(categories.name like '%$search_text%')");
        }
        $cat = $categories->get();
        // dd($categories);
        return view('admin.category.list', compact('page_heading', 'cat', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Property Types";
        $mode = "create";
        $id = "";
        $name = "";
        $name_ar = "";
       
        $active = "1";

        return view("admin.category.create", compact('page_heading', 'mode', 'id', 'name', 'active', 'name_ar'));
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
            ];

           
            if ($request->id != "") {
                $dest_id = $request->id;
                $category = Categories::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Categories::getSlug($request->name, $request->id);
                $category->update($ins);
                $status = "1";
                $message = "Property Type updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Categories::getSlug($request->name);
                $prd = Categories::create($ins);
                $dest_id = $prd->id;
                $status = "1";
                $message = "Property Type added successfully";
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

        $category = Categories::find($id);
        if ($category) {
            $page_heading = "Property Types";
            $mode = "edit";
            $id = $category->id;

            $name = $category->name;
            $name_ar = $category->name_ar;
            
            $active = $category->active;

           


            return view("admin.category.create", compact('page_heading', 'mode', 'id', 'name', 'name_ar', 'active'));
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

        $category = Categories::find($id);
        if ($category) {
            $category->deleted = 1;
            $category->active = 0;
            $category->updated_at = gmdate('Y-m-d H:i:s');
            $category->save();
            $status = "1";
            $message = "Property Type removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Categories::where('id', $request->id)->update(['active' => $request->status])) {
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
