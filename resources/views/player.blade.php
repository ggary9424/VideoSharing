@extends('layouts.app')
@section('header')
    <link href="//vjs.zencdn.net/5.8/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/5.8/video.min.js"></script>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $video['name'] }}</div>
                <div class="panel-body">
                    <video id="playing-video" class="video-js vjs-default-skin" controls
                      preload="auto" width="640" height="480">
                        <source src="/video/stream/{{ $video['id'] }}" type="{{ $video['type'] }}" />
                    </video>
                    <script>
                        var player = videojs('playing-video', {}, function() {
                            this.play(); // if you don't trust autoplay for some reason 
                            // How about an event listener? 
                            this.on('ended', function() {
                                console.log('awww...over so soon?');
                            });
                        });
                    </script>
                 </div>
             </div>
        </div>
    </div>
</div>
@endsection

