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
        Schema::create('inability_certificate_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certificate_id');
            $table->foreign('certificate_id')->references('id')->on('inability_certificates')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('certificate_category_id');
            $table->foreign('certificate_category_id')->references('id')->on('certificate_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('step');
            $table->unsignedBigInteger('approver_id');
            $table->foreign('approver_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status');
            $table->string('is_active')->default('0');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inability_certificate_histories');
    }
};
