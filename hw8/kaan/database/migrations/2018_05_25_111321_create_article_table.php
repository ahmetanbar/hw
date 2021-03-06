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
            $table->unsignedInteger('uid');
            $table->unsignedInteger('category');
            $table->string('title', 40);
            $table->string('body');
            $table->string('artimg', 100)->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('comments')->default(0);
            $table->unsignedInteger('vote_num')->default(0);
            $table->unsignedInteger('voit_point')->default(0);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleted_at')-nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
