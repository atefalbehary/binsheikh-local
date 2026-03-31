<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesToolkit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SalesToolkitController extends Controller
{
    public function index()
    {
        // Only Agents (3) and Agencies (4) should access
        if (Auth::user()->role != 3 && Auth::user()->role != 4) {
            return redirect('/my-profile')->with('error', 'You do not have access to this page.');
        }

        $userId = Auth::user()->id;
        $userRole = Auth::user()->role; // 3 = Agent, 4 = Agency
        $page_heading = "Sales Toolkit";

        // Get documents assigned to this user
        $documents = SalesToolkit::latest()->get()->filter(function ($doc) use ($userId, $userRole) {
            $assigned = $doc->assigned_to;
            if (!is_array($assigned)) {
                return false;
            }

            // Assigned to all agents & agencies
            if (in_array('all', $assigned)) {
                return true;
            }

            // Assigned to all agents only
            if (in_array('all_agents', $assigned) && $userRole == 3) {
                return true;
            }

            // Assigned to all agencies only
            if (in_array('all_agencies', $assigned) && $userRole == 4) {
                return true;
            }

            // Assigned to this specific user
            if (in_array($userId, $assigned) || in_array((string) $userId, $assigned)) {
                return true;
            }

            return false;
        });

        return view('front_end.sales_toolkit.index', compact('documents', 'page_heading'));
    }

    public function download($id)
    {
        // Only Agents (3) and Agencies (4) should access
        if (Auth::user()->role != 3 && Auth::user()->role != 4) {
            return redirect('/my-profile')->with('error', 'You do not have access to this page.');
        }

        $document = SalesToolkit::findOrFail($id);

        // Verify the user has access to this document
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;
        $assigned = $document->assigned_to;

        $hasAccess = false;
        if (is_array($assigned)) {
            if (in_array('all', $assigned))
                $hasAccess = true;
            if (in_array('all_agents', $assigned) && $userRole == 3)
                $hasAccess = true;
            if (in_array('all_agencies', $assigned) && $userRole == 4)
                $hasAccess = true;
            if (in_array($userId, $assigned) || in_array((string) $userId, $assigned))
                $hasAccess = true;
        }

        if (!$hasAccess) {
            return redirect('/my-profile/sales-toolkit')->with('error', 'You do not have access to this document.');
        }

        $fileName = basename($document->file_path);
        $fileContent = Storage::disk('s3')->get($document->file_path);
        $mimeType = Storage::disk('s3')->mimeType($document->file_path) ?: 'application/octet-stream';

        return response($fileContent, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
