<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\VolumeController;
use App\Volume;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        $vc = new VolumeController;
        // $volumes = Volume::all();
        $volumes = Volume::orderBy('sort_order','ASC')->get();
        // $volume = $vc->CurrentVolume();
        $issues = collect();
        foreach ($volumes as $volume) {
            if( $volume && $volume->issues() ) {
                foreach ($volume->issues() as $issue) {
                    $issues->push($issue);
                }
            }
        }
        if( $issues ) {
            // dd($issues);
            View::share('issues', $issues);
            // if( $volumes->first()->issues()->first() ) {
            //     View::share('current_issue_id', $volumes->first()->issues()->first()->id );
            //     View::share('current_issue_title', $volumes->first()->issues()->first()->title );
            // } else {
                View::share('current_issue_id', '');
                View::share('current_issue_title', '');
            // }
        } else {
            View::share('issues', array());
            View::share('current_issue_id', '');
            View::share('current_issue_title', '');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
