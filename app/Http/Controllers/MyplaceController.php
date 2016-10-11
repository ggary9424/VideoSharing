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
    /* elasticsearch */
    protected $es;

    public function __construct()
    {
        $es = resolve('MyElasticSearch');
        $this->es = $es;
    }

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
        $result = Video::where('id', $video_id)
                      -> where('user_id', Auth::user()->id)
                      -> delete();
        if ($result >= 1) {
            $msg = 'Delete successfully';
            
            /* delete a document for elasticsearch */
            $es_params = [
                'index' => 'videosharing_index',
                'type' => 'video',
                'id' => $video_id
            ];
            $es_response = $this->es->delete($es_params);
        }
        else {
            $msg = 'Fail to delete';
        }
        return Redirect::to('/myplace')->with('msg', $msg);
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
            $path = $file->store('/uploaded/');

            /* create a video imformation to database*/
            $video = Video::create([
                         'user_id' => Auth::user()->id,
                         'name' => $request->input('video_name'),
                         'type' => $file->getMimeType(),
                         'desc' => $request->input('video_desc'),
                         'views' => 0,
                         'path' => basename($path),
                     ]);

            /* index a document for elasticsearch*/
            $es_params = [
                'index' => 'videosharing_index',
                'type' => 'video',
                'id' => $video->id,
                'body' => [
                            'name' => $video->name,
                            'desc' => $video->desc,
                            'user' => Auth::user()->name,
                            'created_time' => $video->created_at->format('Y/m/d')
                          ]
            ];
            $es_response = $this->es->index($es_params);

            $msg = 'Upload successfully !!!';
            return Redirect::to('myplace')->with('msg', $msg);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'video_name' => 'required|max:50',
            'video_desc' => 'max:300',
            'video' => 'required|mimes:mp4',
        ]);
    }
}
