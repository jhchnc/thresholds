<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;

class Volume extends Model
{
    protected $table = 'volumes';
    protected $fillable = ['title','is_published','sort_order'];

    public function issues()
    {
    	$issues = Issue::where('volume_id',$this->id)->get();
    	if( count($issues) ) {
	    	return $issues;
    	}
    	return array();
    }
}
