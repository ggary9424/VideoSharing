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
                    <div class="embed-responsive embed-responsive-16by9">                    
                        <video class="video-js vjs-default-skin" id="playing-video" 
                            controls preload="auto">
                            <source src="/video/stream/{{ $video['id'] }}" type="{{ $video['type'] }}" />
                        </video>
                    </div>
                    <script>
                        var player = videojs('playing-video', {}, function() {
                            this.play(); // if you don't trust autoplay for some reason 
                            // How about an event listener? 
                            this.on('ended', function() {
                                console.log('awww...over so soon?');
                            });
                        });
                    </script>
                
                <div class="col-md-12" id="video-desc">
                    <h3>Description</h3>
                    <p>{{ $video['desc'] }}</p>
                </div>
                </div>
            <div>
        </div>
    </div>
</div>
@endsection

