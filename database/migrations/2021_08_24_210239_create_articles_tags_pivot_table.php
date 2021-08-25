<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTagsPivotTable extends Migration
{

    public function up()
    {
        Schema::create('article_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreignId('tag_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('article_tag');
    }
}
