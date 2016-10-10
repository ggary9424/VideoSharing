<?
namespace app\VideoRepository

use ElasticSearch;
use Request;
use Video;

Class VideoRepository 
{
    public function createVideo(Request $request) {
        
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'video_name' => 'required|max:20',
            'video_desc' => 'max:50',
            'video' => 'required|mimes:mp4',
        ]);
    }
}
