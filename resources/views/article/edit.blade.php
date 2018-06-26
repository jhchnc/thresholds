@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row" style="margin-top:10px;">
        	<a href="#" onclick="window.history.back();">Back</a>
        </div>
        <hr />
	    {{Form::open(array('method'=>'PUT','action'=>array('ArticleController@update',$article->id)))}}
	        <input type="hidden" name="issue_id" value="{{ $article->issue_id }}" />
            <div>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
            <hr />
			<div class="row">
                <div class="col-md-9 form-group">
                    <div xstyle="margin-top:20px;">
                        <label>Title</label>
                        <input class="form-control" type="text" name="title" value="{{ $article->title }}" />
                    </div>
                    <div style="margin-top:20px;">
                        <label>URL Alias</label>
                        <input class="form-control" type="text" name="alias" value="{{ $article->alias }}" />
                    </div>
                    <div style="margin-top:20px;">
                        <label>Byline</label>
                        <input class="form-control" type="text" name="byline" value="{{ $article->byline }}" />
                    </div>
                    <div style="margin-top:20px;">
                        <label>Content</label>
                        <textarea id="article_editor_{{ $article->id }}" name="content">{{ $article->content }}</textarea>
                    </div>
                    <div style="margin-top:20px;">
                        <label>CSS</label>
                        <textarea id="article_css" class="form-control" style="height:300px;" name="css_string">{{ $article->css_string }}</textarea>
                    </div>
                    <div style="margin-top:20px;" class="container-fluid">
                        <div class="row">
                            <div class="col-md-1 form-group">
                                <input type="submit" class="btn btn-primary btn-sm" id="article_css_file_btn" value="Upload" />
                            </div>
                            <div class="col-md-11 form-group">
                                <label>CSS File upload</label>
                                <span style="font-size:.8em;"><em>Adds URL to CSS textarea. <b>Don't forget to Save after Upload.</b></em></span>
                                <input type="file" name="article_css_file" id="article_css_file" class="xform-control" />
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div style="margin-top:20px;" class="container-fluid">
                        <div class="row article_background_image_file_container" @if ($article->background_image) style="display:none;" @endif >
                            <div class="col-md-1 form-group">
                                <input type="submit" class="btn btn-primary btn-sm" id="article_background_image_file_btn" value="Upload" />
                            </div>
                            <div class="col-md-11 form-group">
                                <label>Background image upload</label>
                                <input type="file" name="article_background_image_file" id="article_background_image_file" class="xform-control" />
                            </div>
                        </div>
                        @if ($article->background_image)
                            <div class="row article_background_image_file_preview">
                                <div class="col-md-4 form-group">
                                    <img src="{{ $article->background_image }}" />
                                </div>
                                <div class="col-md-7 form-group">
                                    <a href="#" class="btn-upload-new btn btn-xs btn-primary">Change background image</a>
                                    <a href="#" class="btn-delete-image btn btn-xs btn-danger">Remove background image</a>
                                </div>
                            </div>                            
                        @endif
                    </div>
                    <hr />
                    <div style="margin-top:20px;">
                        <label>
                            <input class="" type="checkbox" name="is_published" value="1" {{ $article->is_published ? 'checked="checked"' : '' }} />
                            Published
                        </label>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <h4>Article Fragments</h4>
                    @foreach( $article->fragments() as $fragment ) 
                        <div>
                            <a href="/content/{{ $fragment->id }}/edit" class="fragment_view" data-html="true" data-placement="above" data-trigger="hover" title="Fragment" href='#'>Edit</a>
                            <div class="fragment_view_content" style="display: none">
                                <div>{!! $fragment->content !!}</div>
                            </div>
                            <a href="#" class="btn btn-xs btn-default copy_fragment copy_fragment_{{ $fragment->id }}" rel="{{ $fragment->id }}">copy</a>
                            <a href="{{ route('content.delete', $fragment->id) }}" class="btn btn-xs btn-default btn-delete">delete</a>
                        </div>
                    @endforeach
                    <a class="btn btn-sm btn-primary" href="/content/create/{{ $article->id }}">Add Fragment</a>
                </div>
            </div>
	    {{Form::close()}}
    </div>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">


@stop

@section('scripts')

    $('.fragment_view').each(function(){ 
        var a = $(this);
        var c = a.next();
        a.popover({ 
            html: true,
            // placement: 'top',
            content: function() {
                return c.html();
            }
        });
    });

    // give the fonts a chance to load before staring editor
    setTimeout(function(){
        articleEditSummernote('#article_editor_{{ $article->id }}');

        $('.fragment_id').each(function(){
            var marker = $(this);
            var color = getRandomColor();
            marker.css('color',color).css('font-weight','bold');
            $('.copy_fragment_' + marker.attr('rel') ).prev().prev().css('background-color', color ).css('font-weight','bold');
        });

    },250);

    $('button[type=submit]').click(function(){
        $('span.fragment_id').each(function(){
            $(this).attr('style','');
            $('#article_editor_{{ $article->id }}').summernote('editor.insertText', '');
        });
    });


    $('.btn-delete').each(function(){
        $(this).click(function(e){
            if( confirm("Are you sure?") ) {

            } else {
                e.preventDefault();
            }
        });
    });

    $('#article_css_file_btn').click(function(e){
        e.preventDefault();
        var file = $('#article_css_file').prop('files')[0];
        cssFile(file);
    });

    $('#article_background_image_file_btn').click(function(e){
        e.preventDefault();
        var file = $('#article_background_image_file').prop('files')[0];
        backgroundImageFile(file,{{ $article->id }});
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
      // alert(url);
      $('#article_css').val( $('#article_css').val() + "\n" + url );
    }
  });
}
function backgroundImageFile(file, article_id) {
  data = new FormData();
  data.append("file", file);
  data.append("article_id", article_id);
  data.append("_token", $('#token').val());
  $.ajax({
    data: data,
    type: "POST",
    url: '/upload/background_image',
    cache: false,
    contentType: false,
    processData: false,
    success: function(url) {
        window.location.reload();
    }
  });
}
$('.btn-upload-new').click(function(e){
    e.preventDefault();
    $('.article_background_image_file_container').show();
    $('.article_background_image_file_preview').hide();
});

$('.btn-delete-image').click(function(e){
    e.preventDefault();
    data = new FormData();
    data.append("article_id", {{$article->id}});
    data.append("_token", $('#token').val());
    $.ajax({
        data: data,
        type: "POST",
        url: '/delete/background_image',
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
            window.location.reload();
        }
    });
});



@stop

