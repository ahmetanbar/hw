<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',14)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('role')->default(0); 
            $table->string('name');
            $table->string('surname');
            $table->unsignedInteger('gender')->default(0); 
            $table->date('birthday');
            $table->string('country')->nullable();
            $table->string('ppimg', 100)->nullable();
            $table->unsignedInteger('phone')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
