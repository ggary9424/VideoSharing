<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests;
use App\Models\Video;
use Auth;
use Redirect;

class VideoController extends Controller
{
    public function getPlayPage(int $movie_id) {
        $video = Video::select('id', 'name', 'type', 'desc')
                                   -> where('id', $movie_id)
                                   -> first();
        if (isset($video)) {
            $video->increment('views'); 
            return view('player')->with('video', $video);
        }
        else {
           return Redirect::to('/'); 
        }
    }

    public function stream (int $movie_id) {
        $videosDir = base_path('storage/app/uploaded');
        $video = Video::select('path')
                           -> where('id', $movie_id)
                           -> first();
        if (file_exists($filePath = $videosDir."/".$video['path'])) {
            $stream = new \App\VideoStream\VideoStream($filePath);
            
            return response()->stream(function() use ($stream) {
                $stream->start();
            }); 
        }
        else {
            return response("File doesn't exists", 404);
        }   
    }
}
