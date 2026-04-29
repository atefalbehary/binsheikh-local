<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Validator;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Reviews";
        $search_text = $_GET['search_text'] ?? '';
        $reviews = Reviews::where(['reviews.deleted' => 0])->orderBy('reviews.created_at', 'desc');
        if ($search_text) {
            $reviews = $reviews->whereRaw("(reviews.name like '%$search_text%')");
        }
        $cat = $reviews->get();
        // dd($reviews);
        return view('admin.review.list', compact('page_heading', 'cat', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Reviews";
        $mode = "create";
        $id = "";
        $name = "";
        $title = "";
        $name_ar = "";
        $description = "";
        $description_ar = "";
        $image = "";

        $active = "1";

        return view("admin.review.create", compact('page_heading', 'mode', 'id', 'name', 'active', 'name_ar', 'description', 'description_ar', 'image'));
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
                'active' => $request->active,
            ];
            if ($request->file("image")) {
                $response = image_upload($request, 'reviews', 'image');
                if ($response['status']) {
                    $ins['image'] = $response['link'];
                }
            }

            if ($request->id != "") {
                $review = Reviews::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $review->update($ins);
                $status = "1";
                $message = "Review updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $prd = Reviews::create($ins);
                $status = "1";
                $message = "Review added successfully";
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

        $review = Reviews::find($id);
        if ($review) {
            $page_heading = "Reviews";
            $mode = "edit";
            $id = $review->id;

            $name = $review->name;
            $name_ar = $review->name_ar;
            $description = $review->description;
            $description_ar = $review->description_ar;
            $image = $review->image;

            $active = $review->active;

            return view("admin.review.create", compact('page_heading', 'mode', 'id', 'name', 'active', 'name_ar', 'description', 'description_ar', 'image'));
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

        $review = Reviews::find($id);
        if ($review) {
            $review->deleted = 1;
            $review->active = 0;
            $review->updated_at = gmdate('Y-m-d H:i:s');
            $review->save();
            $status = "1";
            $message = "Review removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Reviews::where('id', $request->id)->update(['active' => $request->status])) {
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
