@extends('layouts.app')
@section('head_for_script')
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/js/file_input.js"></script>    
@endsection
@section('content')
@include('msgbox')
<div class="container">
    <div class="row">
        <div class="col-md-11 col-md-offset-0">
            @include('profile.profile')
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-0">
            @include('profile.uploaded')
        </div>
    </div>
</div>
@endsection
