<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('category_id');
            $table->uuid('user_id');
            $table->uuid('old_user_id')->nullable();
            $table->uuid('purchased_by');
            $table->uuid('variant_id');
            $table->uuid('transaction_id')->nullable();
            $table->decimal('price', 14, 4);
            $table->string('currency');
            $table->string('currency_price')->nullable();
            $table->integer('sold')->default(0);
            $table->boolean('free')->default(0);
            $table->decimal('total', 10, 4); //precio * sold
            $table->integer('old_id')->nullable();
            $table->string('ip_address')->nullable(); //delete
            $table->string('mac_address')->nullable(); //delete
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('items')->nullable();
            $table->text('detail')->nullable();
            $table->text('user')->nullable();
            $table->enum('status', ['Pendiente', 'Pagado', 'Cancelado', 'Rembolsado']);
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
        Schema::dropIfExists('purchases');
    }
}
