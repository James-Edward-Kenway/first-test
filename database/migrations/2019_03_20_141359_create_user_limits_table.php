<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_limits', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('user_id',0,1);
            $table->tinyInteger('type',0,1);
            $table->Integer('count');
            $table->dateTime('till');
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
        Schema::dropIfExists('user_limits');
    }
}
