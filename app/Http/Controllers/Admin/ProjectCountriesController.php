<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCountry;
use Illuminate\Http\Request;
use Validator;

class ProjectCountriesController extends Controller
{
    public function index()
    {

        $page_heading = "Project Countries";
        $search_text = $_GET['search_text'] ?? '';
        $countries = ProjectCountry::where(['project_countries.deleted' => 0])->orderBy('project_countries.created_at', 'desc');
        if ($search_text) {
            $countries = $countries->whereRaw("(project_countries.name like '%$search_text%')");
        }
        $countries = $countries->get();
        // dd($countries);
        return view('admin.project_country.list', compact('page_heading', 'countries', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading = "Project Countries";
        $mode = "create";
        $id = "";
        $name = "";
        $name_ar = "";
       
        $active = "1";

        return view("admin.project_country.create", compact('page_heading', 'mode', 'id', 'name', 'active', 'name_ar'));
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
                $country = ProjectCountry::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $country->update($ins);
                $status = "1";
                $message = "Country updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $prd = ProjectCountry::create($ins);
                $dest_id = $prd->id;
                $status = "1";
                $message = "Country added successfully";
            }
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }


    public function edit($id)
    {

        $country = ProjectCountry::find($id);
        if ($country) {
            $page_heading = "Project Countries";
            $mode = "edit";
            $id = $country->id;

            $name = $country->name;
            $name_ar = $country->name_ar;
            
            $active = $country->active;
            return view("admin.project_country.create", compact('page_heading', 'mode', 'id', 'name', 'name_ar', 'active'));
        } else {
            abort(404);
        }
    }

   
    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $country = ProjectCountry::find($id);
        if ($country) {
            $country->deleted = 1;
            $country->active = 0;
            $country->updated_at = gmdate('Y-m-d H:i:s');
            $country->save();
            $status = "1";
            $message = "Country removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (ProjectCountry::where('id', $request->id)->update(['active' => $request->status])) {
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
