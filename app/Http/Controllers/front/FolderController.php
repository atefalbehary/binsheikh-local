<?php

namespace App\Http\Controllers\front;

use App\Models\Blog;
use App\Models\Folder;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class FolderController extends Controller
{
    public $lang = 'en';
    public function __construct()
    {
        $this->lang = session('sys_lang');

    }

    public function folder($id)
    {
        $page_heading = "folder";
        if(!is_numeric($id)){
            return redirect()->route('home');
        }
        $folder = Folder::find($id);
        $videos = Video::where(['deleted' => 0,'folder_id' => $id, 'active' => 1])->get();
        if($videos->isNotEmpty()) $related = true;

        $blogs = Blog::where(['deleted' => 0, 'folder_id'=> $id, 'active' => 1])->latest()->paginate(10);
        if($blogs->isNotEmpty()) $related = true;

        $photos = Photo::where(['deleted' => 0, 'folder_id'=> $id])->get();
        if($photos->isNotEmpty()) $related = true;
        return view('front_end.folder', compact('folder','photos','blogs','videos', 'page_heading'));
    }
}
