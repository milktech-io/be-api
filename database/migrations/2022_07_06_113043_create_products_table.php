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
            $table->string('name');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('sold')->default(0);
            $table->string('variant')->null();
            $table->uuid('category_id');
            $table->json('features')->null();
            $table->boolean('active')->default(1);
            $table->boolean('multiplier')->default(0);
            $table->json('metadata')->nullable();
            $table->softdeletes();
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
