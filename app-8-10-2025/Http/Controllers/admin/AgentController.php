<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class AgentController extends Controller
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
        $from = $request->get('from', \Carbon\Carbon::create(2010, 1, 1)->format('Y-m-d'));
        $to = $request->get('to', \Carbon\Carbon::today()->format('Y-m-d'));
        $page_heading = "Customer";
        $query = User::where('deleted', 0);
        $query->where('role', 3);
        $page_heading = "Agents";
        $customer = $query->orderBy('created_at', 'desc');

        // Apply date range filter
        $customer = $customer->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);

        if ($search_text) {
            $customer = $customer->where(function ($query) use ($search_text) {
                $query->where('name', 'like', "%$search_text%")
                    ->orWhere('email', 'like', "%$search_text%")
                    ->orWhere('phone', 'like', "%$search_text%");
            });
        }

        $customers = $customer->paginate(10);
        return view('admin.agent.list', compact('page_heading', 'customers', 'search_text', 'role', 'from', 'to'));
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
        $page_heading = "Agent Details";
        $agent = User::find($id);

        if (!$agent) {
            abort(404);
        }
        
        $parts = explode('/', $agent->professional_practice_certificate);
        $last = end($parts);
        $parts = explode('/', $agent->license);
        $last_license = end($parts);
        $parts = explode('/', $agent->id_card);
        $last_id_card = end($parts);

        // Load visit schedules for this specific agent
        $visitSchedules = \App\Models\VisiteSchedule::with(['agent', 'property'])
            ->where('agent_id', $id)
            ->orderBy('visit_time', 'desc')
            ->get();
        
        // Load reservations for this specific agent
        $reservations = \App\Models\Reservation::with(['agent', 'property'])
            ->where('agent_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.agent.details', compact('page_heading', 'agent', 'last', 'last_license', 'last_id_card', 'visitSchedules', 'reservations'));
    }

    /**
     * Download a document associated with a customer
     *
     * @param string $filename The AWS path of the file to download
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadDocument($filename)
    {
        try {
            // Decode the filename as it may be URL encoded
            $decodedFilename = "uploads/profile/$filename";

            // Get the file content from AWS
            $fileUrl = aws_asset_path($decodedFilename);
            // $fileUrl = 'https://cdn.bsbqa.com/uploads/profile/683f4eff4216c_1748979455.pdf';//aws_asset_path($decodedFilename);

            // Get original file name from the path
            $originalName = basename($decodedFilename);

            // Create a temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'document_');
            file_put_contents($tempFile, file_get_contents($fileUrl));

            // Return the file as a download
            return response()->download($tempFile, $originalName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Error downloading file: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $customer = User::find($id);
        if ($customer) {
            // Update verified status
            $customer->verified = 1;
            $customer->updated_at = gmdate('Y-m-d H:i:s');
            $customer->save();

            // Send approval email
            $mailbody = view('front_end.approve_mail')->render();
            if(send_email($customer->email, 'Account Approved - Bin Al Sheikh', $mailbody)) {
                $status = "1";
                $message = "Agent approved successfully";
            } else {
                $status = "1"; // Still consider it success even if email fails
                $message = "Agent approved but email sending failed";
            }
        } else {
            $message = "Something went wrong";
        }

        // Check if it's an AJAX request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => $status == "1",
                'message' => $message
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function updateCommission(Request $request)
    {
        $status = "0";
        $message = "";

        $customer = User::find($request->user_id);
        if ($customer) {
            $customer->commission_number = $request->commission_number;
            $customer->updated_at = gmdate('Y-m-d H:i:s');
            $customer->save();
            $status = "1";
            $message = "Commission number updated successfully";
        } else {
            $message = "Something went wrong";
        }

        return redirect()->back()->with('success', $message);
    }

    public function updateDiscount(Request $request)
    {
        $status = "0";
        $message = "";

        $customer = User::find($request->user_id);
        if ($customer) {
            $customer->discount_number = $request->discount_number;
            $customer->updated_at = gmdate('Y-m-d H:i:s');
            $customer->save();
            $status = "1";
            $message = "Discount number updated successfully";
        } else {
            $message = "Something went wrong";
        }

        return redirect()->back()->with('success', $message);
    }

    public function updateApartments(Request $request)
    {
        $status = "0";
        $message = "";

        $customer = User::find($request->user_id);
        if ($customer) {
            $customer->apartment_sell = implode(',', $request->apartment_sell ?? []);
            $customer->updated_at = gmdate('Y-m-d H:i:s');
            $customer->save();
            $status = "1";
            $message = "Apartments updated successfully";
        } else {
            $message = "Something went wrong";
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update reservation commission
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateReservationCommission(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = [];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'reservation_id' => 'required|integer|exists:reservations,id',
            'commission' => 'required|numeric|min:0|max:100'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occurred";
            $errors = $validator->errors();
        } else {
            try {
                // Find the reservation
                $reservation = \App\Models\Reservation::find($request->reservation_id);
                
                if ($reservation) {
                    // Update the commission
                    $reservation->commission = $request->commission;
                    $reservation->updated_at = gmdate('Y-m-d H:i:s');
                    $reservation->save();
                    
                    $status = "1";
                    $message = "Commission updated successfully";
                } else {
                    $message = "Reservation not found";
                }
            } catch (\Exception $e) {
                Log::error('Error updating reservation commission: ' . $e->getMessage());
                $message = "Something went wrong while updating commission";
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    /**
     * Update reservation status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateReservationStatus(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = [];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'reservation_id' => 'required|integer|exists:reservations,id',
            'status' => 'required|string|in:waitingApproval,Reserved,PreparingDocument,ClosedDeal'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occurred";
            $errors = $validator->errors();
        } else {
            try {
                // Find the reservation
                $reservation = \App\Models\Reservation::find($request->reservation_id);
                
                if ($reservation) {
                    // Update the status
                    $reservation->status = $request->status;
                    $reservation->updated_at = gmdate('Y-m-d H:i:s');
                    $reservation->save();
                    
                    // Get the status label for response
                    $statusLabels = [
                        'waitingApproval' => 'Waiting Approval',
                        'Reserved' => 'Reserved',
                        'PreparingDocument' => 'Preparing Document',
                        'ClosedDeal' => 'Closed Deal'
                    ];
                    
                    $status = "1";
                    $message = "Status updated successfully";
                    $status_label = $statusLabels[$request->status] ?? $request->status;
                } else {
                    $message = "Reservation not found";
                }
            } catch (\Exception $e) {
                Log::error('Error updating reservation status: ' . $e->getMessage());
                $message = "Something went wrong while updating status";
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'status_label' => $status_label ?? null,
            'errors' => $errors
        ]);
    }

    /**
     * Export agents to CSV
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportEmployees(Request $request)
    {
        $ids = $request->get('ids');
        $agentIds = $ids ? explode(',', $ids) : [];
        
        $query = \App\Models\User::where('deleted', 0)->where('role', 3); // Assuming role 3 is for agents
        
        if (!empty($agentIds)) {
            $query->whereIn('id', $agentIds);
        }
        
        $agents = $query->get();
        
        $filename = 'agents_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response()->stream(function() use ($agents) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Agency Name',
                'Created At',
                'Status'
            ]);
            
            // CSV Data
            foreach ($agents as $agent) {
                fputcsv($file, [
                    $agent->id,
                    $agent->name,
                    $agent->email,
                    $agent->phone,
                    $agent->agency->name ?? 'N/A',
                    $agent->created_at->format('Y-m-d H:i:s'),
                    $agent->active ? 'Active' : 'Inactive'
                ]);
            }
            
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Export reservations to CSV
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportReservations(Request $request)
    {
        $ids = $request->get('ids');
        $agentId = $request->get('agent_id'); // Get the specific agent ID
        $reservationIds = $ids ? explode(',', $ids) : [];
        
        $query = \App\Models\Reservation::with(['agent', 'property']);
        
        // Filter by specific agent if agent_id is provided
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        
        if (!empty($reservationIds)) {
            $query->whereIn('id', $reservationIds);
        }
        
        $reservations = $query->get();
        
        $filename = 'agent_reservations_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response()->stream(function() use ($reservations) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID',
                'Property Name',
                'Agent Name',
                'Status',
                'Commission (%)',
                'Price (QAR)',
                'Created At'
            ]);
            
            // CSV Data
            foreach ($reservations as $reservation) {
                fputcsv($file, [
                    $reservation->id,
                    $reservation->property->name ?? 'N/A',
                    $reservation->agent->name ?? 'N/A',
                    $reservation->status_label,
                    $reservation->commission ?? 0,
                    $reservation->property->price ?? 0,
                    $reservation->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Export visit schedules to CSV
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportVisitSchedules(Request $request)
    {
        $ids = $request->get('ids');
        $agentId = $request->get('agent_id'); // Get the specific agent ID
        $scheduleIds = $ids ? explode(',', $ids) : [];
        
        $query = \App\Models\VisiteSchedule::with(['agent', 'property']);
        
        // Filter by specific agent if agent_id is provided
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        
        if (!empty($scheduleIds)) {
            $query->whereIn('id', $scheduleIds);
        }
        
        $schedules = $query->get();
        
        $filename = 'agent_visit_schedules_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response()->stream(function() use ($schedules) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID',
                'Client Name',
                'Client Email',
                'Client Phone',
                'Client ID',
                'Property Name',
                'Unit Type',
                'Visit Time',
                'Agent Name',
                'Created At'
            ]);
            
            // CSV Data
            foreach ($schedules as $schedule) {
                fputcsv($file, [
                    $schedule->id,
                    $schedule->client_name,
                    $schedule->client_email_address,
                    $schedule->client_phone_number,
                    $schedule->client_id,
                    $schedule->property->name ?? 'N/A',
                    $schedule->property->property_type->name ?? 'N/A',
                    $schedule->visit_time->format('Y-m-d H:i:s'),
                    $schedule->agent->name ?? 'N/A',
                    $schedule->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Delete selected agents
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEmployees(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = [];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occurred";
            $errors = $validator->errors();
        } else {
            try {
                $deletedCount = \App\Models\User::whereIn('id', $request->employee_ids)
                    ->where('role', 3) // Assuming role 3 is for agents
                    ->update([
                        'deleted' => 1,
                        'active' => 0,
                        'updated_at' => gmdate('Y-m-d H:i:s')
                    ]);
                
                if ($deletedCount > 0) {
                    $status = "1";
                    $message = "Successfully deleted {$deletedCount} agent(s)";
                } else {
                    $message = "No agents were deleted";
                }
            } catch (\Exception $e) {
                Log::error('Error deleting agents: ' . $e->getMessage());
                $message = "Something went wrong while deleting agents";
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    /**
     * Delete selected reservations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteReservations(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = [];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'reservation_ids' => 'required|array',
            'reservation_ids.*' => 'integer|exists:reservations,id',
            'agent_id' => 'nullable|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occurred";
            $errors = $validator->errors();
        } else {
            try {
                $query = \App\Models\Reservation::whereIn('id', $request->reservation_ids);
                
                // Filter by specific agent if agent_id is provided
                if ($request->has('agent_id') && $request->agent_id) {
                    $query->where('agent_id', $request->agent_id);
                }
                
                $deletedCount = $query->delete();
                
                if ($deletedCount > 0) {
                    $status = "1";
                    $message = "Successfully deleted {$deletedCount} reservation(s)";
                } else {
                    $message = "No reservations were deleted";
                }
            } catch (\Exception $e) {
                Log::error('Error deleting reservations: ' . $e->getMessage());
                $message = "Something went wrong while deleting reservations";
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    /**
     * Delete selected visit schedules
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteVisitSchedules(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = [];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'schedule_ids' => 'required|array',
            'schedule_ids.*' => 'integer|exists:visit_schedules,id',
            'agent_id' => 'nullable|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occurred";
            $errors = $validator->errors();
        } else {
            try {
                $query = \App\Models\VisiteSchedule::whereIn('id', $request->schedule_ids);
                
                // Filter by specific agent if agent_id is provided
                if ($request->has('agent_id') && $request->agent_id) {
                    $query->where('agent_id', $request->agent_id);
                }
                
                $deletedCount = $query->delete();
                
                if ($deletedCount > 0) {
                    $status = "1";
                    $message = "Successfully deleted {$deletedCount} visit schedule(s)";
                } else {
                    $message = "No visit schedules were deleted";
                }
            } catch (\Exception $e) {
                Log::error('Error deleting visit schedules: ' . $e->getMessage());
                $message = "Something went wrong while deleting visit schedules";
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ]);
    }

}
