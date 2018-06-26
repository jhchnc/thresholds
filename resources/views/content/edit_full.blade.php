@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row" style="margin-top:10px;">
        	<a href="#" onclick="window.history.back();">Back</a>
        </div>
        <hr />
	    {{Form::open(array('method'=>'PUT','action'=>array('ContentController@update',$content->id)))}}
			<div class="row">
                <div class="col-md-12 form-group">
                	<label>Content</label>
			        <textarea id="editor_create" name="content">{{ $content->content }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>CSS Class Names</label>
                    <input type="text" id="css_class" class="form-control" name="css_class" value="{{ $content->css_class }}" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>CSS</label>
                    <textarea id="content_css" class="form-control" style="height:300px;" name="css_string">{{ $content->css_string }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 form-group">
                    <input type="submit" class="btn btn-primary btn-sm" id="content_css_file_btn" value="Upload" />
                </div>
                <div class="col-md-11 form-group">
                    <label>CSS File upload</label>
                    <span style="font-size:.8em;"><em>Adds URL to CSS textarea. <b>Don't forget to Save after Upload.</b></em></span>
                    <input type="file" name="content_css_file" id="content_css_file" class="form-control" />
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

    $('#content_css_file_btn').click(function(e){
        e.preventDefault();
        var file = $('#content_css_file').prop('files')[0];
        cssFile(file);
    });

    function cssFile(file) {
      data = new FormData();
      data.append("file", file);
      data.append("_token", $('#token').val());
      $.ajax({
        data: data,
        type: "POST",
        url: '/upload/image',
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
          $('#content_css').val( $('#content_css').val() + "\n" + url );
        }
      });
    }

@stop

