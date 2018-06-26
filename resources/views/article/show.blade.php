@extends('layouts.app')

@section('content')

    {{ $article->title }}
    
    {!! $article->content !!}


@stop


