@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row" style="margin-top:10px;">
        	<a href="#" onclick="window.history.back();">Back</a>
        </div>
        <hr />
	    {{Form::open(array('action'=>'ContentController@store'))}}
	        <input type="hidden" name="article_id" value="{{ $article_id }}" />
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>Content</label>
			        <textarea id="editor_create" name="content"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>CSS Class Names</label>
                    <input type="text" id="css_class" class="form-control" name="css_class" />
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
    contentEditSummernote('#editor_create');
@stop

