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
        Schema::create('cover_letters', function (Blueprint $table) {
            $table->id();
            $table->string('request_number');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('resident_id');
            $table->foreign('resident_id')->references('id')->on('residents')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('religion');
            $table->unsignedBigInteger('work_id');
            $table->foreign('work_id')->references('id')->on('works')->onUpdate('cascade')->onDelete('cascade');
            $table->string('address');
            $table->string('resident_number');
            $table->string('family_number');
            $table->unsignedBigInteger('certificate_category_id');
            $table->foreign('certificate_category_id')->references('id')->on('certificate_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cover_letters');
    }
};
