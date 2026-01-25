<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_text = $request->get('search_text')?? '';
        $role = $request->get('role');
        $page_heading = "Customer";
        $query = User::where('deleted', 0);
        if ($role !== null) {
            $query->where('role', $role);
                if($role == '2'){
                    $page_heading = "Users";
                }
                else
                {
                    if($role == '3'){
                        $page_heading = "Agents";
                    }
                    else
                    {
                        if($role == '4'){
                            $page_heading = "Agencies";
                        }
                    }
                }
            }
       // $search_text  = $_GET['search_text'] ?? '';
        $customer       = $query->orderBy('created_at', 'desc');
        if ($search_text) {
           // $customer = $customer->whereRaw("(name like '%$search_text%' OR email like '%$search_text%' OR phone like '%$search_text%' )");
            $customer = $customer->where(function ($query) use ($search_text) {
                $query->where('name', 'like', "%$search_text%")
                    ->orWhere('email', 'like', "%$search_text%")
                    ->orWhere('phone', 'like', "%$search_text%");

                // Try to match date part only (YYYY-MM-DD)
                if (strtotime($search_text)) {
                    $query->orWhereDate('created_at', '=', date('Y-m-d', strtotime($search_text)));
                }
            });
        }
        $customers = $customer->paginate(10);
        // dd($customer);
        return view('admin.customer.list', compact('page_heading', 'customers', 'search_text', 'role'));
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

    public function deleteAll(Request $request)
    {
        //Log::info($request->all());
        if ($request->has('delete_all_id')) {
            $ids = explode(',', $request->delete_all_id);
            //Log::info($ids);
            User::whereIn('id', $ids)->delete();

            return redirect()->back()->with('success', 'Selected customers deleted successfully.');
        }
        return redirect()->back()->with('error', 'No customers selected.');
//        $delete_all_id = explode(",", $request->delete_all_id);
//        User::whereIn('id', $delete_all_id)->delete();
//        return redirect('admin/sections')->with('success', 'Sections deleted successfully.');
    }

    public function details($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customer.details', compact('customer'));
    }

}
