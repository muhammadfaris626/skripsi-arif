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
        Schema::create('approval_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certificate_category_id');
            $table->foreign('certificate_category_id')->references('id')->on('certificate_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('step');
            $table->unsignedBigInteger('approver_1')->nullable();
            $table->foreign('approver_1')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('approver_2')->nullable();
            $table->foreign('approver_2')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('approver_3')->nullable();
            $table->foreign('approver_3')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('approver_4')->nullable();
            $table->foreign('approver_4')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('approver_5')->nullable();
            $table->foreign('approver_5')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_settings');
    }
};
