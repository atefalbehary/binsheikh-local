<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceHighlights;
use App\Models\Service;
use Illuminate\Http\Request;
use Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Services";
        $search_text = $_GET['search_text'] ?? '';
        $services = Service::where(['services.deleted' => 0])->orderBy('services.created_at', 'desc');
        if ($search_text) {
            $services = $services->whereRaw("(services.name like '%$search_text%')");
        }
        $services = $services->paginate(10);
        return view('admin.service.list', compact('page_heading', 'services', 'search_text'));
    }

    public function create()
    {

        $page_heading = "Services";
        $mode = "create";
        $id = "";
        $highlights = [];
        return view("admin.service.create", compact('page_heading', 'mode', 'id', 'highlights'));
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
                'is_recommended' => isset($request->is_recommended) ? 1 : 0,
                'active' => $request->active,
            ];

            if ($request->file("image")) {
                $response = image_upload($request, 'service/image', 'image');
                if ($response['status']) {
                    $ins['image'] = $response['link'];
                }
            }
            if ($request->id != "") {
                $prpty_id = $request->id;
                $service = Service::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Service::getSlug($request->name, $request->id);
                $service->update($ins);
                $status = "1";
                $message = "Service updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Service::getSlug($request->name);
                $prd = Service::create($ins);
                $prpty_id = $prd->id;
                $status = "1";
                $message = "Service added successfully";
            }

            if ($request->id) {
                ServiceHighlights::where('service_id', $prpty_id)->delete();
            }

            $highlight_title = $request->highlight_title;
            $highlight_title_ar = $request->highlight_title_ar;

            $highlight_description = $request->highlight_description;
            $highlight_description_ar = $request->highlight_description_ar;
           
            foreach ($highlight_title as $key => $val) {
                $iti['service_id'] = $prpty_id;
                $iti['title'] = $val;
                $iti['title_ar'] = $highlight_title_ar[$key];
                $iti['description'] = $highlight_description[$key];
                $iti['description_ar'] = $highlight_description_ar[$key];
                ServiceHighlights::create($iti);
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

        $service = Service::find($id);
        if ($service) {
            $page_heading = "Services";
            $mode = "edit";
            $highlights = ServiceHighlights::where('service_id', $id)->orderBy('id','asc')->get();
            return view("admin.service.create", compact('page_heading', 'mode', 'id', 'service', 'highlights'));
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

        $service = Service::find($id);
        if ($service) {
            $service->deleted = 1;
            $service->active = 0;
            $service->updated_at = gmdate('Y-m-d H:i:s');
            $service->save();
            $status = "1";
            $message = "Service removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Service::where('id', $request->id)->update(['active' => $request->status])) {
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

        $service = ServiceHighlights::find($id);
        if ($service) {
            $service->delete();
            $status = "1";
            $message = "Image removed successfully";
        } else {
            $message = "Sorry!.. Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }

}
