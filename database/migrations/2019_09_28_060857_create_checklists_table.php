<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('object_domain',100);
            $table->integer('object_id');
            $table->text('description');
            $table->boolean('is_completed')->default(false);
            $table->dateTime('due')->nullable();
            $table->integer('urgency')->default(0);
            $table->dateTime('completed_at')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('last_update_by')->unsigned()->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('checklists');
        // Schema::dropIfExists('checklists');
    }
}
