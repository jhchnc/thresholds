@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        	&nbsp;
        </div>
    </div>
    <div class="container">
        <div class="row">
        	<a href="/volumes/{{ $volume_id }}/edit/">Back</a>
        </div>
    </div>
    <div class="container">
		{{Form::open(array('action'=>'IssueController@store'))}}
	        <input type="hidden" name="volume_id" value="{{ $volume_id }}" />
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>Title</label>
			        <input class="form-control" type="text" name="title" value="" />
                </div>
            </div>
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>
				        <input class="" type="checkbox" name="is_published" value="1" />
				        Published
		        	</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <button class="btn btn-primary pull-right" type="submit">Save</button>
                </div>
            </div>

	    {{Form::close()}}
    </div>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

@stop


