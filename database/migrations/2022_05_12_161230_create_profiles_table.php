<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('image_url')->nullable();
            $table->string('profession')->nullable();
            $table->string('gender')->nullable();
            $table->json('habilities')->nullable();
            $table->string('about_me')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('code_mobile')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_id');
        });
    }
};
