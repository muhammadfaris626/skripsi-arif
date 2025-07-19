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
        Schema::create('birth_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('religion');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->string('time_of_birth');
            $table->unsignedBigInteger('family_card_id');
            $table->foreign('family_card_id')->references('id')->on('family_cards')->onUpdate('cascade')->onDelete('cascade');
            $table->string('father_name');
            $table->string('mother_name');
            $table->longText('address');
            $table->string('child_from');
            $table->string('give_birth_in');
            $table->string('birth_location');
            $table->string('weight');
            $table->string('birth_certificate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birth_certificates');
    }
};
