<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_heading = "Customer";
        $search_text  = $_GET['search_text'] ?? '';
        $customer       = User::where(['deleted' => 0])->where('role','!=',1)->orderBy('created_at', 'desc');
        if ($search_text) {
            $customer = $customer->whereRaw("(name like '%$search_text%' OR email like '%$search_text%' OR phone like '%$search_text%')");
        }
        $customers = $customer->paginate(10);
        // dd($customer);
        return view('admin.customer.list', compact('page_heading', 'customers', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_heading   = "Customer";
        $mode           = "create";
        $id             = "";
        $name           = "";
        $name_ar        = "";
        $description    = "";
        $description_ar = "";

        $active = "1";

        return view("admin.customer.create", compact('page_heading', 'mode', 'id', 'name', 'active', 'name_ar', 'description', 'description_ar'));
    }

    public function store(Request $request)
    {
        $status      = "0";
        $message     = "";
        $o_data      = [];
        $errors      = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            'name'           => 'required',
            'name_ar'        => 'required',
            'description'    => 'required',
            'description_ar' => 'required',

        ]);
        if ($validator->fails()) {
            $status  = "0";
            $message = "Validation error occured";
            $errors  = $validator->messages();
        } else {
            $input = $request->all();

            $ins = [
                'name'           => $request->name,
                'name_ar'        => $request->name_ar,
                'active'         => $request->active,
                'description'    => $request->description,
                'description_ar' => $request->description_ar,

            ];

            if ($request->id != "") {
                $dest_id           = $request->id;
                $customer            = User::find($request->id);
                $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                $customer->update($ins);
                $status  = "1";
                $message = "Customer updated succesfully";
            } else {
                $ins['created_at'] = gmdate('Y-m-d H:i:s');
                $prd               = User::create($ins);
                $dest_id           = $prd->id;
                $status            = "1";
                $message           = "Customer added successfully";
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

        $customer = User::find($id);
        if ($customer) {
            $page_heading = "Customer";
            $mode         = "edit";
            $id           = $customer->id;

            $name    = $customer->name;
            $name_ar = $customer->name_ar;

            $active         = $customer->active;
            $description    = $customer->description;
            $description_ar = $customer->description_ar;

            return view("admin.customer.create", compact('page_heading', 'mode', 'id', 'name', 'name_ar', 'active', 'description', 'description_ar'));
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
        $status  = "0";
        $message = "";
        $o_data  = [];

        $customer = User::find($id);
        if ($customer) {
            $customer->deleted    = 1;
            $customer->active     = 0;
            $customer->updated_at = gmdate('Y-m-d H:i:s');
            $customer->save();
            $status  = "1";
            $message = "Customer removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status  = "0";
        $message = "";
        if (User::where('id', $request->id)->update(['active' => $request->status])) {
            $status = "1";
            $msg    = "Successfully activated";
            if (! $request->status) {
                $msg = "Successfully deactivated";
            }
            $message = $msg;
        } else {
            $message = "Sorry!.. Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }

    public function applications()
    {

        $page_heading = "Customer Applications";
        $search_text  = $_GET['search_text'] ?? '';
        $applications       = CustomerApplication::with('customer')->where(['deleted' => 0])->orderBy('created_at', 'desc');
        if ($search_text) {
            $applications = $applications->whereRaw("(name like '%$search_text%' OR email like '%$search_text%' OR phone like '%$search_text%')");
        }
        $applications = $applications->paginate(10);
        return view('admin.customer.applications', compact('page_heading', 'applications', 'search_text'));
    }
    public function delete_application($id)
    {
        $status  = "0";
        $message = "";
        $o_data  = [];

        $dt = CustomerApplication::find($id);
        if ($dt) {
            $dt->deleted    = 1;
            $dt->updated_at = gmdate('Y-m-d H:i:s');
            $dt->save();
            $status  = "1";
            $message = "Application removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }

}
