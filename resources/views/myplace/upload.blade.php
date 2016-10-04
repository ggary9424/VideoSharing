<div class="panel panel-default" id="upload">
    <div class="panel-heading">Upload video</div>
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url('myplace/upload') }}" method="post" enctype="multipart/form-data" id="video_upload">
            {{ csrf_field() }}

                <div class="form-group{{ $errors->has('video_name') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Video Name:  &nbsp;&nbsp;(max: 50 words)</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="video_name" value="{{ old('name') }}" maxlength="50">
                        @if ($errors->has('video_desc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('video_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Video Discription:  &nbsp;&nbsp;(max: 300 words)</label>
                    <div class="col-md-6">
                        <textarea class="form-control" form="video_upload" name="video_desc" rows="4" cols="50" maxlength="300"></textarea>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Vidoe File</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" name="video">
                            </span>
                            <span id="select_file_name" style="padding-left: 15px;"></span>
                        </div>
                        @if ($errors->has('video'))
                        <span class="help-block">
                            <strong>{{ $errors->first('video') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-user"></i>Upload
                        </button>
                    </div>
                </div>

            </div>
        </form>                    
    </div>
</div>
