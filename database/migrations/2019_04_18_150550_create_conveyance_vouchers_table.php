<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConveyanceVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conveyance_vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('designation_name')->nullable();
            $table->text('project_name')->nullable();
            $table->string('date')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('mode')->nullable();
            $table->string('purpose')->nullable();
            $table->double('amount')->nullable();
            $table->string('progress_status')->nullable();
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
        Schema::dropIfExists('conveyance_vouchers');
    }
}
