<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->uuid('id')->primary();
            $table->string('sku')->nullable(false);
            $table->string('name')->nullable(false);
            $table->integer('price')->default(0);
            $table->integer('stock')->default(0);
            $table->uuid('category_id');
            $table->integer('createdAt')->nullable(false);
            
            $table->index('category_id');
            $table->index('sku');
            $table->index('name');
            $table->index('price');
            $table->index('stock');
            $table->index('createdAt');     
            
            $table->foreign('category_id')->references('id')->on('categories');

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
