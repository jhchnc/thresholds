<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Article;

class ProcessArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = Article::all();
        $bar = $this->output->createProgressBar(count($articles));
        foreach ($articles as $article) {
            $article->save();
            foreach ($article->fragments() as $fragment) {
                $fragment->save();
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
