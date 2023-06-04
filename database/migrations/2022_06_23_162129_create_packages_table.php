<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('plan_id');
            $table->string('date');
            $table->string('end_date');
            $table->decimal('price', 14, 4);
            $table->string('currency');
            $table->boolean('generate_roi')->default(1);
            $table->decimal('interest', 14, 4)->default(0.0278);
            $table->integer('months')->default(20);
            $table->boolean('plus_comission')->default(1);
            $table->enum('status', ['activo', 'completado', 'liquidado'])->default('activo');
            $table->decimal('automatically_ends', 10, 4);
            $table->softDeletes();
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
        Schema::dropIfExists('packages');
    }
}
