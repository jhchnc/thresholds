<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'contents';
    protected $fillable = ['content','parent_id','is_published'];

	public function getCleanContent()
	{
		$content = $this->content;
		$content = str_replace('src="http://thresholds.oasis.unc.edu/', 'src="/', $content);
		$content = str_replace('src="http://openthresholds.org/', 'src="/', $content);
		return $content;
	}

	public function displayLazyContent()
	{
		$content = $this->content;
        $content = str_replace('src="', 'src="/css/images/clear.gif" data-lazyload="true" data-original="', $content);
		return $content;
	}

}
