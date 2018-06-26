<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;
use App\Content;
use Leafo\ScssPhp\Compiler;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['alias','content','is_published','sort_order'];

    public function issue()
    {
    	$issue = Issue::findOrFail($this->issue_id);
    	return $issue;
    }
    public function fragments()
    {
    	$fragments = Content::where('parent_id',$this->id)->get();
    	return $fragments;
    }

    public function getCleanCSS()
    {
        $scss = new Compiler();
        $css_string = $this->css_string;
        if( strpos($css_string,'http://openthresholds.org/images/') !== false && strpos($css_string,'http://thresholds.oasis.unc.edu/images/') !== false ) {
            $css_string = str_replace('http://openthresholds.org/images/', '/images/', $css_string);
            $css_string = str_replace('http://thresholds.oasis.unc.edu/images/', '/images/', $css_string);
            $sass_string = '.article_id_' . $this->id . ' { ' . $css_string . ' } ';
            $sass_string = $scss->compile($sass_string);
            return compact('css_string','sass_string');
        } else {
            return false;
        }
    }

    public function getCleanContent()
    {
        $content = $this->content;
        $content = str_replace('src="http://thresholds.oasis.unc.edu/', 'src="/', $content);
        $content = str_replace('src="http://openthresholds.org/', 'src="/', $content);
        $content = str_replace('<link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">', '', $content);
        $content = str_replace('<link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet">', '', $content);

        $background_image = $this->background_image;
        $background_image = str_replace('http://openthresholds.org/images/', '/images/', $background_image);
        $background_image = str_replace('http://thresholds.oasis.unc.edu/images/', '/images/', $background_image);

        return compact('content','background_image');
    }

    public function displayLazyContent()
    {
        $content = $this->content;
        $content = str_replace('src="', 'src="/css/images/clear.gif" data-lazyload="true" data-original="', $content);
        return $content;
    }

}
