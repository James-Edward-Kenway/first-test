<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order',0,0)->default(0);
            $table->string('name',512);
            $table->timestamps();
        });

        Schema::create('attribute_categories_product_categories', function (Blueprint $table) {
            $table->integer('attribute_category_id',0,1);
            $table->integer('product_category_id',0,1);
        });

        Schema::create('attribute_categories_services_categories', function (Blueprint $table) {
            $table->integer('attribute_category_id',0,1);
            $table->integer('service_category_id',0,1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_categories_product_categories');
        Schema::dropIfExists('attribute_categories_services_categories');
        Schema::dropIfExists('attribute_categories');
    }
}
