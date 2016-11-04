<?php
namespace App\Repositories;

use App\Models\Video;

class VideoRepository
{
    protected $video;

    public function __construct (Video $video) {
        $this->video = $video;
    }

    public function getUploaderVideosJsonForTable (int $page_num, int $user_id) {
        if ($page_num <= 0) {
            return "";
        }
        $page_num = ($page_num-1)*100;
        $result = $this->video-> select(['id', 'name', 'views', 'created_at'])
                      -> where('user_id', $user_id)
                      -> orderBy('created_at', 'DESC')
                      -> skip($page_num)
                      -> take(100)
                      -> get();
        return $result->toJson();
    }
}
