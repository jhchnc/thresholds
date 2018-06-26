@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
        	&nbsp;
        </div>
    </div>
    <div class="container">
        {{Form::open(array('action'=>'VolumeController@store'))}}
            <div class="row">
                <h3>Volume Title</h3>
                <div class="col-md-12 form-group">
			        <input type="text" id="volume_title_editor_create" name="title" value="" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
			        <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        {{Form::close()}}
    </div>


@stop

