<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Video;
use Auth;
use Redirect;
use Validator;

class MyplaceController extends Controller
{
    public function index () {
        $variable_need = ['video_count', 'videos_for_table'];
        if (!Auth::check()) {
            return Redirect::to('/');
        }
        else {
            $videos = Auth::user()->videos;
            $video_count = $videos->count();
            $videos_for_table = $this->getUploaderVideosJsonForTable(1);
            return view('myplace/index', compact($variable_need));
        }
    }

    public function getUploaderVideosJsonForTable (int $page_num) {
        if ($page_num <= 0) {
            return "";
        }
        $page_num = ($page_num-1)*100;
        $result = Video::select(['id', 'name', 'views', 'created_at'])
                      -> where('user_id', Auth::user()->id)
                      -> orderBy('created_at', 'DESC')
                      -> skip($page_num)
                      -> take(100)
                      -> get();
        return $result->toJson();
    }

    public function deleteVideo (int $video_id) {
        /* delete a video information from database and delete document from elasticsearch */
        $result = Video::where('id', $video_id)
                      -> where('user_id', Auth::user()->id)
                      -> getModel()
                      /* first() is every important. See https://github.com/laravel/framework/issues/2536 */
                      -> first()
                      -> delete();

        /* delete successfully */
        if ($result == 1) {
            return Redirect::to('/myplace')->with('msg_success', 'Delete successfully');
        }

        /* delete fail */
        return Redirect::to('/myplace')->with('msg_danger', 'Fail to delete');
    }

    public function upload (Request $request) {
        if (!Auth::check()) {
            return Redirect::to('/');
        }
        else {

            /* validate first */
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return Redirect::to('/myplace#upload')->withErrors($validator);
            }
            
            /* get file from user */
            $file = $request->file("video");
            $path = $file->store('/uploaded');

            /* create a video information to database and index document to elasticsearch */
            $video = Video::create([
                         'user_id' => Auth::user()->id,
                         'name' => $request->input('video_name'),
                         'type' => $file->getMimeType(),
                         'desc' => $request->input('video_desc'),
                         'views' => 0,
                         'path' => basename($path),
                     ]);

            /* generate thumbnail for uploaded video */
            exec("ffmpegthumbnailer -i ".storage_path("app")."/".$path.
                                    " -o ".storage_path("app/thumbnail")."/thumb_".$video->id.".png".
                                    " -s 340x180 -t 20%");

            $msg_success = 'Upload successfully !!!';
            return Redirect::to('myplace')->with('msg_success', $msg_success);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'video_name' => 'required|max:50',
            'video_desc' => 'max:300',
            'video' => 'required|mimes:mp4,ogg,webm',
        ]);
    }
}
