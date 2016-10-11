@extends('layouts.app')
@section('content')
<div class="container">
<row>
    <hgroup class="mb20">
		<h1>Search Results</h1>
		<h2 class="lead">
			<strong class="text-danger">{{ $videos_count }}</strong> 
			results were found for the search for
			<strong class="text-danger">{{ $search_content }}</strong>
		</h2>								
	</hgroup>
</row>
<row>
    <div class="col-xs-12 col-sm-12 col-md-12">
		@foreach ($videos_data as $key => $video)
		<div class="search-result row">
			<a href="/video/{{ $video['_id'] }}" title="{{ $video['_source']['name'] }}">
				<!-- TODO: Change url to video screenshot path -->
				<div class="col-xs-12 col-sm-6 col-md-3 video-picture" 
					 style="background-image: url('http://lorempixel.com/340/180/people')">
				</div>
			</a>
			<div class="col-xs-12 col-sm-4 col-md-2 video-properties">
				<ul>
					<li class="col-xs-6 col-sm-12">
						<i class="fa fa-calendar"></i>
						<span>{{ $video['_source']['created_time'] }}</span>
					</li>
					<li class="col-xs-6 col-sm-12">
						<i class="fa fa-user"></i>
						<span>
							@if (isset($video['highlight']['user']))
								{!! $video['highlight']['user'][0] !!}
							@else
								{!! $video['_source']['user'] !!}
							@endif
						</span>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-7 excerpet video-desc">
				<h3>
					<a href="/video/{{ $video['_id'] }}" title="">
							@if (isset($video['highlight']['name']))
								{!! $video['highlight']['name'][0] !!}
							@else
								{!! $video['_source']['name'] !!}
							@endif
					</a>
				</h3>
				<p>
					@if (isset($video['highlight']['desc']))
						{!! $video['highlight']['desc'][0] !!}
					@else
						{!! $video['_source']['desc'] !!}
					@endif
				</p>						
			</div>
		</div>
		@endforeach
	</div>
</row>
</div>
@endsection