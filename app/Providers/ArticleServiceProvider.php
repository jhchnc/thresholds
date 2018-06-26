<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Article;

class ArticleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::saving(function ($article) {

            $content = $article->getCleanContent();
            $article->content = $content['content'];
            $article->background_image = $content['background_image'];

            $css = $article->getCleanCSS();
            if( $css ) {
                $article->css_string = $css['css_string'];
                $article->sass_string = $css['sass_string'];
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
