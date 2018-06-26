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
    </div>
    <div class="container">
	    {{Form::open(array('action'=>'ArticleController@store'))}}
	        <input type="hidden" name="issue_id" value="{{ $issue_id }}" />
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>Title</label>
			        <input class="form-control" type="text" name="title" value="" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>URL Alias</label>
                    <input class="form-control" type="text" name="alias" />
                </div>
            </div>
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>Content</label>
			        <textarea id="article_editor_create" name="content"></textarea>
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

@section('scripts')
    articleEditSummernote('#article_editor_create');
@stop

