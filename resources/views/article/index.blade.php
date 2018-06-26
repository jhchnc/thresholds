@extends('layouts.app')

@section('content')

    [<a href="/article/create">create</a>] 

    <ul>
        @foreach( $all as $article )

            <li>
	            <a href="/article/{{ $article->id }}">{{ $article->title }}</a> 
    	        [<a href="/article/{{ $article->id }}/edit">edit</a>] 
            </li>

        @endforeach
    </ul>

@stop


