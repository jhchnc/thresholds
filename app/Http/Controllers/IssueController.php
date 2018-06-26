<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Issue;
use View;
use Form;
use Validator;
use Carbon;
use Session;
use Redirect;

class IssueController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

	public function index() {
		$all = Issue::all();
		return View::make('issue.index')->with('all', $all);
	}

	public function create($volume_id) {
		return View::make('issue.create')->with('volume_id',$volume_id);
	}

	public function store(Request $request) {
        $rules = array(
            'title' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('issue/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            // store
            $issue = new Issue;
            $issue->title = $request->get('title');
            $issue->is_published = $request->get('is_published');
            $issue->volume_id = $request->get('volume_id');
            $issue->created_at = Carbon\Carbon::now();
            $issue->updated_at = Carbon\Carbon::now();
            $issue->save();
            // redirect
            Session::flash('message', 'Successfully created issue!');
            return Redirect::to('volumes/' . $request->get('volume_id') . '/edit');
        }
	}

	public function update($id, Request $request) {
        $rules = array(
            'title' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('issue/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            // store
			$issue = Issue::findOrFail($id);
            $issue->is_published = $request->get('is_published') ? 1 : 0;
            $issue->title = $request->get('title');
            $issue->updated_at = Carbon\Carbon::now();
            $issue->save();
            // redirect
            Session::flash('message', 'Successfully saved issue!');
            return Redirect::to('volumes/' . $issue->volume()->id . '/edit');
        }
	}

	public function show($id) {
		$issue = Issue::findOrFail($id);
        $classname = $issue->id == 2 ? 'issue_home' : '';
        $classname = count( $issue->articles() ) > 1 ? $classname : $classname . ' issue_single';
        $init_article_alias = $issue->articles()->first()->alias;
        if( $issue->is_published ) {
            return View::make('issue.show')->with('issue', $issue)->with('classname', $classname)->with('init_article_alias', $init_article_alias);
        } else {
            $user = \Auth::user();
            if( $user ) {
                return View::make('issue.show')->with('issue', $issue)->with('classname', $classname)->with('init_article_alias', $init_article_alias);
            }
        }
	}

	public function destroy($id) {
		$issue = Issue::findOrFail($id);
		return $issue;
	}

	public function edit($id) {
		$issue = Issue::findOrFail($id);
		return View::make('issue.edit')->with('issue', $issue);
	}

}
