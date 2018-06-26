@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
        	&nbsp;
        </div>
    </div>
    <div class="container">
        <h3>Volume Title</h3>
	    {{Form::open(array('method'=>'PUT','action'=>array('VolumeController@update',$volume->id)))}}
            <div class="row">
                <div class="col-md-12 form-group">
			        <input class="form-control" type="text" id="volume_title_editor_{{ $volume->id }}" name="title" value="{{ $volume->title }}" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Sort Order</label>
                    <input class="form-control" type="text" name="sort_order" value="{{ $volume->sort_order }}" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
	    {{Form::close()}}

        <!-- List all Issues -->
        <h2>Issues</h2>
        <hr />
        <ul>
            @foreach( $volume->issues() as $issue ) 

                <li>
                    <a href="/issue/{{ $issue->id }}/edit">{{ $issue->title }}</a> 
                    <ul>
                        <li style="margin-top:7px;">
                            <strong>Articles</strong><br/>
                            <ul class="sortable">
                                @foreach( $issue->articles() as $article ) 
                                    <li id="{{ $article->id }}" style="margin-top:2px;">
                                        <span class="glyphicon glyphicon-move"></span>
                                        <a class="btn btn-xs btn-primary" style="margin-left:10px;" href="{{ route('article.edit', $article->id) }}">Edit</a>
                                        {{ $article->title }} 
                                        <a class="btn btn-xs btn-danger pull-right" style="margin-left:10px;" href="{{ route('article.delete', $article->id) }}">Delete</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li style="margin-top:15px;">
                            <a class="btn btn-xs btn-primary" href="/article/create/{{ $issue->id }}">Add Article</a>
                        </li>
                    </ul>
                    <br/>
                    <br/>
                </li>

            @endforeach
        </ul>
        <hr />
        <a class="btn btn-primary" href="/issue/create/{{ $volume->id }}">Add Issue</a>

    </div>
    <input type="hidden" name="" id="token" value="{{ csrf_token() }}">

@stop

@section('scripts')

    $('.btn-danger').each(function(){
        $(this).click(function(e){
            if( confirm("Are you sure?") ) {

            } else {
                e.preventDefault();
            }
        });
    });

    $( ".sortable" ).sortable({
        axis: 'y',
        update: function (event, ui) {
            data = new FormData();
            $('ul.sortable').each(function(){
                var ul = $(this);
                var sort_order = 1;
                ul.find('li').each(function(){
                    var li = $(this);
                    data.append(li.attr('id'), sort_order);
                    sort_order++;
                });
            });
            data.append("_token", $('input#token').val());
            $.ajax({
                data: data,
                type: 'POST',
                url: '/article/sort',
                cache: false,
                contentType: false,
                processData: false,
            });
        }
    });
    $( ".sortable" ).disableSelection();

@stop
