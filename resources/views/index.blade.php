@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <table class="table" name="movie_table">
                    <thead>
                        <tr class"active">
                            <th> 電影名稱 </th>
                            <th> 上傳者 </th>
                            <th> 觀看人數 </th>
                        </tr>
                    </thead>
                    @foreach ($videos as $video)
                    <tbody>
                        <tr class="active">
                            <td>
                                <a href="/video/{{ $video['id'] }}" style="color: #23527c">
                                    <i class="fa fa-btn fa-video-camera"></i>{{ $video['name'] }}
                                </a> 
                            </td>
                            <td>
                                <p>{{ $video->user->name }}</p> 
                            </td>
                            <td>
                                <p>{{ $video['views'] }}</p>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                    @endforeach
               </table>
            </div>
        </div>
    </div>
@endsection
