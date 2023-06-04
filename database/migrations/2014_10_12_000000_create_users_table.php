<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('token_expire_at')->nullable();
            $table->string('password');
            $table->integer('login_attemps')->default(0);
            $table->date('block_until')->nullable();
            $table->uuid('sponsor_id')->nullable();
            $table->integer('is_active')->index('is_active')->default(1);
            $table->string('eth_address')->nullable()->unique();
            $table->string('chain_id')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
