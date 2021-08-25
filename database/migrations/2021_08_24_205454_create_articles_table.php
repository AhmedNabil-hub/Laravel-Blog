<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{

    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreignId('user_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreignId('category_id')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
