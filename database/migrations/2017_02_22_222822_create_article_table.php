<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {

            $table->increments('id');
            $table->text('title');
            $table->mediumText('content')->nullable();
            $table->text('css_string')->nullable();
            $table->text('sass_string')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('is_published')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
