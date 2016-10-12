@if(Session::has('msg'))
<div class="well well-default">
    {{ Session::get('msg') }}
</div>
@endif
@if(Session::has('msg_warning'))
<div class="well well-warning">
    {{ Session::get('msg_warning') }}
</div>
@endif