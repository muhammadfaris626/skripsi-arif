<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marriage_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->unsignedBigInteger('work_id');
            $table->foreign('work_id')->references('id')->on('works')->onUpdate('cascade')->onDelete('cascade');
            $table->string('couple_name');
            $table->string('partner_address');
            $table->string('guardian_name');
            $table->string('wedding_date');
            $table->string('name_of_the_chief');
            $table->string('bride_price');
            $table->string('witness_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marriage_certificates');
    }
};
