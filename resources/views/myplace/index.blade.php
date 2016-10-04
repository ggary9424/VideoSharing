@extends('layouts.app')
@section('header')
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/js/file_input.js"></script>    
@endsection
@section('content')
@if(Session::has('msg'))
<div class="well" id="msg">
    {{ Session::get('msg') }}
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-11 col-md-offset-0">
            @include('myplace.profile')
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-0">
            @include('myplace.uploaded')
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-0">
            @include('myplace.upload')
        </div>
    </div>
</div>
@endsection
