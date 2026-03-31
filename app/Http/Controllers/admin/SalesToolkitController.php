<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesToolkit;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SalesToolkitController extends Controller
{
    public function index()
    {
        $documents = SalesToolkit::latest()->get();
        $agents_agencies = User::whereIn('role', [3, 4])
            ->where('deleted', 0)
            ->where('active', 1)
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role']);

        return view('admin.sales_toolkit.index', compact('documents', 'agents_agencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documents' => 'required|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png|max:20480',
        ]);

        // Determine assignment
        $specificUsers = $request->assigned_to;
        if (!empty($specificUsers) && is_array($specificUsers)) {
            // Specific users were selected
            $assignedToValue = $specificUsers;
        } else {
            // No specific users — use the default_assign radio value
            $defaultAssign = $request->default_assign ?? 'all';
            $assignedToValue = [$defaultAssign]; // e.g. ['all'], ['all_agents'], or ['all_agencies']
        }

        $uploadedCount = 0;

        foreach ($request->file('documents') as $file) {
            $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = '/uploads/sales_toolkit/' . $fileName;

            Storage::disk('s3')->put($path, file_get_contents($file));

            SalesToolkit::create([
                'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_path' => $path,
                'assigned_to' => $assignedToValue,
            ]);

            $uploadedCount++;
        }

        return redirect()->back()->with('success', $uploadedCount . ' document(s) uploaded successfully.');
    }

    public function destroy($id)
    {
        $document = SalesToolkit::find($id);
        if ($document) {
            if (Storage::disk('s3')->exists($document->file_path)) {
                Storage::disk('s3')->delete($document->file_path);
            }
            $document->delete();
            return response()->json(['status' => 1, 'message' => 'Document deleted successfully']);
        }
        return response()->json(['status' => 0, 'message' => 'Document not found']);
    }
}
