<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 14, 4);
            $table->string('currency');
            $table->integer('stock')->nullable();
            $table->boolean('generate_roi')->default(1);
            $table->decimal('interest', 14, 4)->default(0.05);
            $table->decimal('automatically_ends', 14, 4);
            $table->boolean('plus_comission')->default(1);
            $table->uuid('created_by')->nullable();
            $table->uuid('product_id')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('plans');
    }
}
