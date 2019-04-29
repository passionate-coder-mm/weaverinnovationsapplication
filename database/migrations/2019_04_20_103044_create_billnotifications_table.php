<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillnotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billnotifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('notifiable_type');
            $table->integer('notifiable_id');
            $table->string('data');
            $table->string('read_at');
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
        Schema::dropIfExists('billnotifications');
    }
}
