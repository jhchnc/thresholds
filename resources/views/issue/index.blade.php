@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        	&nbsp;
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

			    <a class="btn btn-primary" href="/issue/create">Add Issue</a>
			    <hr />
			    <ul>
			        @foreach( $all as $issue )

			            <li>
				            {{ $issue->title }}
			    	        [<a href="/issue/{{ $issue->id }}/edit">edit</a>] 
			            </li>

			        @endforeach
			    </ul>
			    <hr />
			    <a class="btn btn-primary" href="/issue/create">Add Issue</a>


            </div>
        </div>
    </div>


@stop

