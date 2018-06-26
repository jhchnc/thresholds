@extends('layouts.app')

@section('styles') 
    {!! $home_left_sass_string !!}
    {!! $home_right_sass_string !!}
@stop

@section('content')

    <div id="main" class="container-fluid" style="margin:0;padding:0;">
        <div class="panel panel-default" style="border:none;">
            <div class="panel-body pull-left">
                <div id="" class="article">
                    <div class="article-left pull-left content_id_{{ $home_left_id }}" ><div class="article-left-wrapper">
                        @if (!Auth::guest() && !(Auth::user()->email == 'reviewer@openthresholds.org') )
                            <a href="/content/1/edit" class="btn btn-primary btn-small content_edit_button">Edit</a>
                        @endif
                        {!! $home_left !!}
                    </div></div>
                    <div class="article-right pull-right content_id_{{ $home_right_id }}"><div class="article-right-wrapper">
                        @if (!Auth::guest() && !(Auth::user()->email == 'reviewer@openthresholds.org') )
                            <a href="/content/2/edit" class="btn btn-primary btn-small content_edit_button">Edit</a>
                        @endif
                        {!! $home_right !!}
                    </div></div>
                    <!-- <h2 class="article-title"><span>Home</span></h2> -->
                </div>
            </div>
        </div>
    </div>

@endsection
