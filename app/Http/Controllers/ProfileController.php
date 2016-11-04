<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\VideoRepository;
use App\Models\User;
use Auth;
use Redirect;

class ProfileController extends Controller
{
    protected $video_repository;

    public function __construct (VideoRepository $video_repository) {
        $this->video_repository = $video_repository;
    }

    public function getProfile(int $user_id) {
        if (Auth::check()) {
            if (Auth::user()->id == $user_id) {
                return Redirect::to('myplace');
            }
        }
        $variable_need = ['user', 'video_count', 'videos_for_table'];
        
        $user = User::where('id', $user_id)->first();
        if($user == NULL) {
            return Redirect::to('/');
        }
        $videos = $user->videos;
        $video_count = $videos->count();
        $videos_for_table = $this->video_repository->getUploaderVideosJsonForTable(1, $user_id);
        return view('profile.index', compact($variable_need));
    }    
}
