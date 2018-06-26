@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        	&nbsp;
        </div>
    </div>
    <div class="container">
        <div class="row">
        	<a href="#" onclick="window.history.back();">Back</a>
        </div>
	    <hr />
	    {{Form::open(array('method'=>'PUT','action'=>array('IssueController@update',$issue->id)))}}
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>Title</label>
			        <input class="form-control" type="text" id="issue_editor_{{ $issue->id }}" name="title" value="{{ $issue->title }}" />
                </div>
            </div>
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>
				        <input class="" type="checkbox" name="is_published" value="1" {!! $issue->is_published ? 'checked="checked"' : '' !!} />
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

@stop


