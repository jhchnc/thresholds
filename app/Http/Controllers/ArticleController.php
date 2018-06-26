<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Issue;
use View;
use Form;
use Validator;
use Carbon;
use Session;
use Redirect;
use Leafo\ScssPhp\Compiler;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

	public function index() {
		$all = Article::all();
		return View::make('article.index')->with('all', $all);
	}

	public function create($issue_id) {
		return View::make('article.create')->with('issue_id',$issue_id);
	}

	public function store(Request $request) {
        // store
        $article = new Article;
        $article->created_at = Carbon\Carbon::now();
        $this->updateArticle($article,$request,'store');
        $issue = Issue::findOrFail($request->get('issue_id'));
        return Redirect::to('volumes/' . $issue->volume_id . '/edit');
	}

	public function update($id, Request $request) {
        $article = Article::findOrFail($id);
        $this->updateArticle($article,$request,'update');
        // $issue = Issue::findOrFail($request->get('issue_id'));
        // return Redirect::to('volumes/' . $issue->volume_id . '/edit');
        return Redirect::to('article/' . $article->id . '/edit');
	}

    public function updateArticle($article,$request,$mode) {
        $rules = array(
            'content' => 'required',
            'title' => 'required',
            // 'alias' => 'unique:articles'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('article/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            $article->content = $request->get('content');

            $scss = new Compiler();
            $css_string = $request->get('css_string');
            $sass_string = '.article_id_' . $article->id . ' { ' . $css_string . ' } ';
            $sass_string = $scss->compile($sass_string);
            $article->css_string = $css_string;
            $article->sass_string = $sass_string;

            $article->is_published = $request->get('is_published');
            $article->issue_id = $request->get('issue_id');
            $article->title = $request->get('title');

            $article->alias = $request->get('alias');
            
            $article->byline = $request->get('byline');
            $article->updated_at = Carbon\Carbon::now();
            $article->save();
            if( $mode == 'update' ) {
                Session::flash('message', 'Successfully saved article!');
            } else {
                Session::flash('message', 'Successfully created article!');
            }
        }
    }

	public function show($id) {
		$article = Article::findOrFail($id);
		return View::make('article.show')->with('article', $article);
	}

	public function destroy($id) {
		$article = Article::findOrFail($id);
        $article->delete();
        return redirect()->back();
	}

	public function edit($id) {
		$article = Article::findOrFail($id);
		return View::make('article.edit')->with('article', $article);
	}

}
