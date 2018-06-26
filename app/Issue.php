<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Article;
use App\Volume;

class Issue extends Model
{
    protected $table = 'issues';
    protected $fillable = ['title','is_published','volume_id'];

    public function articles()
    {
    	$articles = Article::where('issue_id',$this->id)->orderBy('sort_order','ASC')->get();
    	return $articles;
    }

    public function volume()
    {
    	$volume = Volume::where('id',$this->volume_id)->get()->first();
    	return $volume;
    }

}
