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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->string('name');
            $table->string('gender');
            $table->longText('address');
            $table->string('phone');
            $table->string('effective_date');
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('cascade');
            $table->unsignedBigInteger('rank_id');
            $table->foreign('rank_id')->references('id')->on('ranks')->onUpdate('cascade');
            $table->string('employee_status');
            $table->string('blood_group');
            $table->unsignedBigInteger('education_id');
            $table->foreign('education_id')->references('id')->on('education')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
