@extends('layouts.app')

@section('content')

    [<a href="/content/create">create</a>] 

    <ul>
        @foreach( $all as $content )

            <li>
	            <a href="/content/{{ $content->id }}">{{ $content->content }}</a> 
    	        [<a href="/content/{{ $content->id }}/edit">edit</a>] 
            </li>

        @endforeach
    </ul>

@stop


