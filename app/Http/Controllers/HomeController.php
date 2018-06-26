<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Content;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        $alias = '/home';
        $article = \App\Article::where('alias',$alias)->first();
        if($article) {
            $issue = $article->issue();
            $classname = 'issue_home';
            $classname = count( $issue->articles() ) > 1 ? $classname : $classname . ' issue_single';
            if( $issue->is_published ) {
                return response()->make(view('issue.show')->with('issue', $issue)->with('classname', $classname)->with('init_article_alias', $alias));
            }
        }

        return new RedirectResponse('/issue/2');
    }

}
