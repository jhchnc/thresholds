@extends('layouts.app')

@section('content')

    {{Form::open(array('method'=>'PUT','action'=>array('ContentController@update',$content->id)))}}
        <textarea id="editor_{{ $content->id }}" name="content">{{ $content->content }}</textarea>
        <button type="submit">Save</button>
    {{Form::close()}}

@stop

@section('scripts')
    $('#editor_{{ $content->id }}').summernote({
        airMode: true,
    });                                                                                                                      
@stop

