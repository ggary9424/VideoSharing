@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $video['name'] }}</div>
                <div class="panel-body">
                    <div class="embed-responsive embed-responsive-16by9">                    
                        <video class="video-js vjs-default-skin" id="playing-video" 
                            controls preload="auto" autoplay="autoplay" >
                            <source src="/video/stream/{{ $video['id'] }}" type="{{ $video['type'] }}" />
                        </video>
                    </div>
                
                <div class="col-md-12" id="video-desc">
                    <h3>Description</h3>
                    @if (!$video['desc'])
                        <p style="color: #6E6E6E">No descrption.</p>
                    @else
                        <p>{{ $video['desc'] }}</p>
                    @endif
                </div>
                </div>
            <div>
        </div>
    </div>
</div>
@endsection

