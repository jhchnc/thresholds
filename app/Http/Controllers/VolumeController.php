<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Volume;
use View;
use Form;
use Validator;
use Carbon;
use Session;
use Redirect;

class VolumeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

	public function index() {
		$all = Volume::orderBy('sort_order','ASC')->get();
		return View::make('volume.index')->with('all', $all);
	}

	public function create() {
		return View::make('volume.create');
	}

	public function store(Request $request) {
        $rules = array(
            'title' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('volumes/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            // store
            $volume = new Volume;
            $volume->title = $request->get('title');
            $volume->created_at = Carbon\Carbon::now();
            $volume->updated_at = Carbon\Carbon::now();
            $volume->save();
            // redirect
            Session::flash('message', 'Successfully created volume!');
            return Redirect::to('volumes');
        }
	}

	public function update($id, Request $request) {
        $rules = array(
            'title' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('volumes/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            // store
			$volume = Volume::findOrFail($id);
            $volume->title = $request->get('title');
            $volume->sort_order = $request->get('sort_order');
            $volume->updated_at = Carbon\Carbon::now();
            $volume->save();
            // redirect
            Session::flash('message', 'Successfully saved volume!');
            return Redirect::to('volumes/' . $id . '/edit');
        }
	}

	public function show($id) {
		$volume = Volume::findOrFail($id);
		return View::make('volume.show')->with('volume', $volume);
	}

	public function destroy($id) {
		$volume = Volume::findOrFail($id);
		return $volume;
	}

	public function edit($id) {
		$volume = Volume::findOrFail($id);
		return View::make('volume.edit')->with('volume', $volume);
	}
    
    public function CurrentVolume() {
        $volume = Volume::all()->first();
        return $volume;
    }


}
