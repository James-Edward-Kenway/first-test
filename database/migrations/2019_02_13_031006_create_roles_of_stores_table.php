<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesOfStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_of_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id',0,1);
            $table->integer('store_id',0,1);
            $table->tinyInteger('role',0,1);
            $table->timestamps();
        });

        Schema::create('product_wishlist', function (Blueprint $table) {
            $table->integer('user_id',0,1);
            $table->integer('product_id',0,1);
        });

        Schema::create('service_wishlist', function (Blueprint $table) {
            $table->integer('user_id',0,1);
            $table->integer('service_id',0,1);
        });

        Schema::create('product_likes', function (Blueprint $table) {
            $table->integer('user_id',0,1);
            $table->integer('product_id',0,1);
        });

        Schema::create('service_likes', function (Blueprint $table) {
            $table->integer('user_id',0,1);
            $table->integer('service_id',0,1);
        });
        Schema::create('store_subscription', function (Blueprint $table) {
            $table->integer('user_id',0,1);
            $table->integer('store_id',0,1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_of_stores');
        Schema::dropIfExists('product_wishlist');
        Schema::dropIfExists('service_wishlist');
        Schema::dropIfExists('product_likes');
        Schema::dropIfExists('service_likes');
        Schema::dropIfExists('store_subscription');
    }
}
