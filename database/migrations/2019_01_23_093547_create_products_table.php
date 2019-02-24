<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('like_count')->unsigned();
            $table->tinyInteger('status',0,1)->default(3);
            $table->text('title');
            $table->text('description');
            $table->text('images')->default('[]');
            $table->decimal('price',16,2);
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
        Schema::dropIfExists('products');
    }
}
