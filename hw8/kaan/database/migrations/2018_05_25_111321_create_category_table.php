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
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 40);
            $table->string('info',40);
            $table->string('catimg', 100)->nullable();
            $table->unsignedInteger('articles_num')->default(0);
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
        Schema::dropIfExists('category');
    }
}
