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
        Schema::create('marriage_certificate_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certificate_id');
            $table->foreign('certificate_id')->references('id')->on('marriage_certificates')->onUpdate('cascade')->onDelete('cascade');
            $table->string('approval_category');
            $table->string('step');
            $table->unsignedBigInteger('approver_id');
            $table->foreign('approver_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status');
            $table->string('is_active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marriage_certificate_histories');
    }
};
