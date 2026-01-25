<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popups = Popup::orderBy('id', 'desc')->get();
        return view('admin.popups.index', compact('popups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.popups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $imagePath  = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $imagePath = '/uploads/popup/photos/' . $name;
            Storage::disk('s3')->put($imagePath, fopen($file, 'r+'));
        }
      //  $imagePath = $request->file('image')->store('popups', 'public');

        Popup::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'link' => $request->link,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.popups.index')->with('success', 'Popup created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $popup = Popup::findOrFail($id);
        return view('admin.popups.show', compact('popup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $popup = Popup::findOrFail($id);
        return view('admin.popups.edit', compact('popup'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $popup = Popup::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
//            if ($popup->image) {
//                Storage::disk('public')->delete($popup->image);
//            }
            $response = image_upload($request, 'popup/image', 'image');
            if ($response['status']) {
                $imagePath = $response['link'];
                $popup->image = $imagePath;
            }


        }

        $popup->title = $request->title;
        $popup->subtitle = $request->subtitle;
        $popup->link = $request->link;
        $popup->is_active = $request->has('is_active') ? 1 : 0;
        $popup->save();

        return redirect()->route('admin.popups.index')->with('success', 'Popup updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $popup = Popup::findOrFail($id);

        // Delete image file
        if ($popup->image) {
            Storage::disk('public')->delete($popup->image);
        }

        $popup->delete();

        return redirect()->route('admin.popups.index')->with('success', 'Popup deleted successfully.');
    }

    /**
     * Change the active status of a popup.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $popup = Popup::findOrFail($request->id);
        $popup->is_active = $request->status;
        $popup->save();

        return response()->json(['status' => true, 'message' => 'Status changed successfully.']);
    }
}
