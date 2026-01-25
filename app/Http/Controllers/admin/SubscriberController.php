<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportReports;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $page_heading = "Subscribers";
        $search_text = $_GET['search_text'] ?? '';
        $subscribers = Subscriber::orderBy('created_at', 'desc');
        if ($search_text) {
            $subscribers = $subscribers->whereRaw("(email like '%$search_text%')");
        }
        if ($request->submit != "export") {
            $subscribers = $subscribers->paginate(10);
            return view('admin.subscribers.list', compact('page_heading', 'subscribers', 'search_text'));
        } else {
            $subscribers = $subscribers->get();

            $rows = array();
            $i = 1;
            foreach ($subscribers as $key => $val) {

                $rows[$key]['i'] = $i;
                $rows[$key]['email'] = $val->email;
                $rows[$key]['created_at'] = web_date_in_timezone($val->created_at, 'd-M-Y h:i A');
                $i++;
            }
            $headings = [
                "#",
                "Email",
                "Subscribed Date",
            ];
            $coll = new ExportReports([$rows], $headings);
            $ex = Excel::download($coll, 'subscribers_list_' . date('d_m_Y_h_i_s') . '.xlsx');
            if (ob_get_length()) {
                ob_end_clean();
            }
            return $ex;
        }

    }

    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];

        $subscribers = Subscriber::find($id);
        if ($subscribers) {
            $subscribers->delete();
            $status = "1";
            $message = "Subscriber removed successfully";
        } else {
            $message = "Something went wrong";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }

}
