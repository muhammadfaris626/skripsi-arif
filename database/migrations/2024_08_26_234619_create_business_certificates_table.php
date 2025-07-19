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
        Schema::create('business_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cover_letter_id');
            $table->foreign('cover_letter_id')->references('id')->on('cover_letters')->onUpdate('cascade')->onDelete('cascade');
            $table->string('request_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('resident_id')->nullable();
            $table->foreign('resident_id')->references('id')->on('residents')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('resident_number');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->string('religion');
            $table->string('gender');
            $table->unsignedBigInteger('work_id')->nullable();
            $table->foreign('work_id')->references('id')->on('works')->onUpdate('cascade')->onDelete('cascade');
            $table->string('address');
            $table->string('business_name');
            $table->longText('business_address');
            $table->string('long_term');
            $table->string('validity_period')->nullable();
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_certificates');
    }
};
