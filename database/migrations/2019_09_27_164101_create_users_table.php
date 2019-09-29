<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('username', 27);
            $table->string('email', 191);
            $table->string('name', 191);
            $table->string('password', 191);
            $table->string('remember_token', 100)->default('0');
            $table->text('api_token')->nullable()->default(null);
            $table->integer('file_id')->default('0');
            $table->timestamps();
            $table->unique(["email"]);
            $table->unique(["username"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        // Schema::dropIfExists('users');
    }
}
