<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@home');
Route::get('home', 'HomeController@home');
// Route::get('about', 'HomeController@about');

Route::post('upload/image', [
	'middleware' => ['auth'],
	'uses' => function () {

		$allowed = array('png', 'jpg', 'gif', 'jpeg', 'wav', 'mp3', 'ogg', 'avi', 'wmv', 'mp4', 'mov', 'webm', 'ogv');
		$rules = [
			'file' => 'required|file|mimes:' . implode(',', $allowed)
		];
		$data = \Illuminate\Support\Facades\Input::all();
		$validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
		if ($validator->fails()) {
			return '{"status":"Invalid File type"}';
		}
		if(\Illuminate\Support\Facades\Input::hasFile('file')){
			$extension = \Illuminate\Support\Facades\Input::file('file')->getClientOriginalExtension();
			if(!in_array(strtolower($extension), $allowed)){
				return '{"status":"Invalid File type"}';
			} else {
				$filename = uniqid() . '_attachment.' . $extension;
				if (Illuminate\Support\Facades\Input::file('file')->move('images/', $filename)) {
					echo url('images/' . $filename);
					exit;
				}
			}
		} else {
			return '{"status":"Invalid File type"}';
		}

	}
]);

Route::post('upload/background_image', [
	'middleware' => ['auth'],
	'uses' => function () {

		$allowed = array('png', 'jpg', 'gif', 'jpeg', 'wav', 'mp3', 'ogg', 'avi', 'wmv', 'mp4', 'mov', 'webm', 'ogv');
		$rules = [
			'file' => 'required|file|mimes:' . implode(',', $allowed)
		];
		$data = \Illuminate\Support\Facades\Input::all();
		$validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
		if ($validator->fails()) {
			return '{"status":"Invalid File type"}';
		}
		if(\Illuminate\Support\Facades\Input::hasFile('file')){
			$extension = \Illuminate\Support\Facades\Input::file('file')->getClientOriginalExtension();
			if(!in_array(strtolower($extension), $allowed)){
				return '{"status":"Invalid File type"}';
			} else {
				$filename = uniqid() . '_attachment.' . $extension;
				if (Illuminate\Support\Facades\Input::file('file')->move('images/', $filename)) {
					// 
					$article = \App\Article::find($data['article_id']);
					$background_image_url = url('images/' . $filename);
					$article->background_image = $background_image_url;
					$article->save();
					echo $background_image_url;
					exit;
				}
			}
		} else {
			return '{"status":"Invalid File type"}';
		}

	}
]);
Route::post('delete/background_image', [
	'middleware' => ['auth'],
	'uses' => function () {
		$data = \Illuminate\Support\Facades\Input::all();
		$article = \App\Article::find($data['article_id']);
		if( $article ) {
			$article->background_image = null;
			$article->save();
			return 'true';
		} else {
			return 'false';
		}
	}
]);

Route::post('article/sort', [
	'middleware' => ['auth'],
	'uses' => function () {
		$data = \Illuminate\Support\Facades\Input::all();
		if( $data ) {
			foreach ($data as $key => $sort_order) {
				if( $key != '_token' ) {
					$article = \App\Article::find($key);
					$article->sort_order = $sort_order;
					$article->save();
				}
			}
			return $data;
		}
		return '{"status":"Invalid File type"}';
	}
]);

Route::resource('content', 'ContentController');
Route::resource('article', 'ArticleController');
Route::resource('issue', 'IssueController');
Route::resource('volumes', 'VolumeController');

Route::get('issue/create/{volume_id}', 'IssueController@create');
Route::get('article/create/{issue_id}', 'ArticleController@create');
Route::get('content/create/{article_id}', 'ContentController@create');

Route::get('article/{id}/delete', ['as' => 'article.delete', 'uses' => 'ArticleController@destroy']);
Route::get('content/{id}/delete', ['as' => 'content.delete', 'uses' => 'ContentController@destroy']);
