@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        	&nbsp;
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>Volumes</h2>
                <hr />
			    <ul>
			        @foreach( $all as $volume )

			            <li>
				            <a href="/volumes/{{ $volume->id }}/edit">{{ $volume->title }}</a> 
			            </li>

			        @endforeach
			    </ul>
			    <hr />
			    <a class="btn btn-primary" href="/volumes/create">Add Volume</a>


            </div>
        </div>
    </div>
    
@stop


