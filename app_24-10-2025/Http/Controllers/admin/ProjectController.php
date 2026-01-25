<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectImages;
use App\Models\Projects;
use App\Models\ProjectCountry;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Projects";
        $search_text = $_GET['search_text'] ?? '';
        $projects = Projects::where(['projects.deleted' => 0])->orderBy('projects.created_at', 'desc');
        if ($search_text) {
            $projects = $projects->whereRaw("(projects.name like '%$search_text%')");
        }
        $projects = $projects->paginate(10);

        return view('admin.project.list', compact('page_heading', 'projects', 'search_text'));
    }

    public function create()
    {

        $page_heading = "Projects";
        $mode = "create";
        $id = "";
        $images = [];
        $project_countries = ProjectCountry::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
        return view("admin.project.create", compact('page_heading', 'mode', 'id', 'images','project_countries'));
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
            'description' => 'required',
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
                'location' => $request->location,
                'location_ar' => $request->location_ar,
                'is_recommended' => isset($request->is_recommended) ? 1 : 0,
                'link_360' => $request->link_360,
                'active' => $request->active,
                'country' => $request->country??0,
                'end_date' => $request->end_date,
                'suggested_apartments' => $request->suggested_apartments ? implode(',', $request->suggested_apartments) : null,
            ];

            if ($request->file("image")) {
                $response = image_upload($request, 'project/image', 'image');
                if ($response['status']) {
                    $ins['image'] = $response['link'];
                }
            }

            if ($request->file("app_image")) {
                $response = image_upload($request, 'project/app_image', 'app_image');
                if ($response['status']) {
                    $ins['app_image'] = $response['link'];
                }
            }

            if ($request->file("banner")) {
                $response = image_upload($request, 'project/banner', 'banner');
                if ($response['status']) {
                    $ins['banner'] = $response['link'];
                }
            }
            if ($request->file("video")) {
                $response = image_upload($request, 'project/video', 'video');
                if ($response['status']) {
                    $ins['video'] = $response['link'];
                }
            }
            if ($request->file("video_thumbnail")) {
                $response = image_upload($request, 'project/video_thumbnail', 'video_thumbnail');
                if ($response['status']) {
                    $ins['video_thumbnail'] = $response['link'];
                }
            }

            if ($request->id != "") {
                $prpty_id = $request->id;
                $project = Projects::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Projects::getSlug($request->name, $request->id);
                $project->update($ins);
                $status = "1";
                $message = "Project updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $ins['slug'] = Projects::getSlug($request->name);
                $prd = Projects::create($ins);
                $prpty_id = $prd->id;
                $status = "1";
                $message = "Project added successfully";
            }

            $imgs = [];
            $images = $request->file('prj_image');
            $prj_image_type = $request->prj_image_type;
            if ($images) {
                // foreach ($images as $key => $file) {
                //     $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                //     $path = public_path() . '/uploads/project/';
                //     $file->move($path, $name);

                //     $im['image'] = '/uploads/project/' . $name;
                //     $im['project_id'] = $prpty_id;
                //     $im['type'] = $prj_image_type[$key];
                //     ProjectImages::create($im);
                // }

                foreach ($images as $key => $file) {
                    $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = '/uploads/project/' . $name;
                    Storage::disk('s3')->put($path, fopen($file, 'r+'));

                    $im['image'] = '/uploads/project/' . $name;
                    $im['project_id'] = $prpty_id;
                    $im['type'] = $prj_image_type[$key];
                    ProjectImages::create($im);
                }
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

        $project = Projects::find($id);
        if ($project) {
            $page_heading = "Projects";
            $mode = "edit";
            $images = ProjectImages::where('project_id', $id)->get();
            $project_countries = ProjectCountry::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get();
            return view("admin.project.create", compact('page_heading', 'mode', 'id', 'project', 'images','project_countries'));
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

        $project = Projects::find($id);
        if ($project) {
            $project->deleted = 1;
            $project->active = 0;
            $project->updated_at = gmdate('Y-m-d H:i:s');
            $project->save();
            $status = "1";
            $message = "Project removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Projects::where('id', $request->id)->update(['active' => $request->status])) {
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

        $project = ProjectImages::find($id);
        if ($project) {
            $project->delete();
            $status = "1";
            $message = "Image removed successfully";
        } else {
            $message = "Sorry!.. Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }

}
