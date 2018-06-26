<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Content;
use App\Article;
use App\Issue;
use View;
use Form;
use Validator;
use Carbon;
use Session;
use Redirect;
use Leafo\ScssPhp\Compiler;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

	public function index() {
		$all = Content::all();
		return View::make('content.index')->with('all', $all);
	}

	public function create($article_id) {
		return View::make('content.create')->with('article_id',$article_id);
	}

	public function store(Request $request) {
        $content = new Content;
        $content->created_at = Carbon\Carbon::now();
        $content->parent_id = $request->get('article_id');
        $this->updateContent($content,$request,'store');
        if( $request->get('article_id') ) {
    	    $article = Article::findOrFail($request->get('article_id'));
	        return Redirect::to('article/' . $article->id . '/edit');
        }
        return Redirect::to('/');
	}

	public function update($id, Request $request) {
        $content = Content::findOrFail($id);
        
        if( !$content->parent_id ) {
            $scss = new Compiler();
            $css_string = $request->get('css_string');
            $sass_string = '.content_id_' . $content->id . ' { ' . $css_string . ' } ';
            $sass_string = $scss->compile($sass_string);
            $content->css_string = $css_string;
            $content->sass_string = $sass_string;
        }
        $this->updateContent($content,$request,'update');
        
        if( $content->parent_id ) {
	        $article = Article::findOrFail($content->parent_id);
	        return Redirect::to('article/' . $article->id . '/edit');
        }

        return Redirect::to('/');
	}

	public function updateContent($content,$request,$mode) {
        $rules = array(
            'content' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('content/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            $content->is_published = $request->get('is_published');
            $content->css_class = $request->get('css_class');
            $content->content = $request->get('content');
            $content->updated_at = Carbon\Carbon::now();
            $content->save();
            if( $mode == 'update' ) {
	            Session::flash('message', 'Successfully saved content!');
            } else {
	            Session::flash('message', 'Successfully created content!');
            }
        }
    }

	public function show($id) {
		$content = Content::findOrFail($id);
		return View::make('content.show')->with('content', $content);
	}

	public function destroy($id) {
		$content = Content::findOrFail($id);
        $content->delete();
        return redirect()->back();
	}

	public function edit($id) {
		$content = Content::findOrFail($id);
		if( $content->parent_id ) {
			return View::make('content.edit')->with('content', $content);
		} else {
			return View::make('content.edit_full')->with('content', $content);
		}
	}

	public function store_image() {

		$post = Content::findOrFail( Input::get('post_id') );
		$message = Input::get('message');
		
		$dom = new DomDocument();
		$dom->loadHtml($message, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
		$images = $dom->getElementsByTagName('img');
		
		// foreach <img> in the submited message
		foreach($images as $img){
			$src = $img->getAttribute('src');
			
			// if the img source is 'data-url'
			if(preg_match('/data:image/', $src)){
				
				// get the mimetype
				preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
				$mimetype = $groups['mime'];
				
				// Generating a random filename
				$filename = uniqid();
				$filepath = "/images/$filename.$mimetype";
	
				// @see http://image.intervention.io/api/
				$image = Image::make($src)
				  // resize if required
				  /* ->resize(300, 200) */
				  ->encode($mimetype, 100) 	// encode file to the specified mimetype
				  ->save(public_path($filepath));
				
				$new_src = asset($filepath);
				$img->removeAttribute('src');
				$img->setAttribute('src', $new_src);
			} // <!--endif
		} // <!--endforeach
		
		$post->message = $dom->saveHTML();
		$post->save();
		
		Session::flash('message','Post updated!');
		return Redirect::back();

	}

}
