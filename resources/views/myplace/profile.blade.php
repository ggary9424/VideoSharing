<div class="panel panel-default">
    <div class="panel-heading">Your Profile</div>
    <div class="panel-body">
        <p><strong>Name: </strong>{{ Auth::user()->name }}</p>
        <p><strong>Email: </strong>{{ Auth::user()->email }}</p>
        <p><strong>Create At: </strong>{{ Auth::user()->created_at }}</p>
        <p><strong>Upload Movie Num: </strong>{{ $video_count }}</p>
    </div>
</div>
