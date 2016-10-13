@if(Session::has('msg_info'))
<div class="alert alert-info">
    {{ Session::get('msg_info') }}
</div>
@endif
@if(Session::has('msg_success'))
<div class="alert alert-success">
    {{ Session::get('msg_success') }}
</div>
@endif
@if(Session::has('msg_warning'))
<div class="well alert-warning">
    {{ Session::get('msg_warning') }}
</div>
@endif
@if(Session::has('msg_danger'))
<div class="well alert-danger">
    {{ Session::get('msg_danger') }}
</div>
@endif