<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Content;

class FragmentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Content::saving(function ($fragment) {
            $content = $fragment->getCleanContent();
            $fragment->content = $content;
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
