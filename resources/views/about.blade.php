@extends('layouts.app')

@section('content')

    <div id="main" class="page container" style="margin:0;padding:0;">
        <div class="panel panel-default" style="border:none;">
            <div class="panel-body pull-left">
            	<div class="row">
		            <div class="col-md-12">
		                {!! $about !!}
                        @if (!Auth::guest() && !(Auth::user()->email == 'reviewer@openthresholds.org') )
		                    <a href="/content/3/edit" class="btn btn-primary btn-small content_edit_button">Edit</a>
		                @endif
		            </div>
                    <!-- <h2 class="article-title"><span>About</span></h2> -->
                </div>
            </div>
        </div>
    </div>


@endsection
