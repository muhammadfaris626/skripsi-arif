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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_card_id'); // NOMOR KK
            $table->foreign('family_card_id')->references('id')->on('family_cards')->onUpdate('cascade')->onDelete('cascade');
            $table->string('resident_name'); // NIK
            $table->string('resident_number'); // NAMA
            $table->string('gender'); // JENIS KELAMIN
            $table->string('place_of_birth'); // TEMPAT LAHIR
            $table->string('date_of_birth'); // TANGGAL LAHIR
            $table->string('religion'); // AGAMA
            $table->unsignedBigInteger('education_id'); // PENDIDIKAN
            $table->foreign('education_id')->references('id')->on('education')->onUpdate('cascade');
            $table->unsignedBigInteger('work_id'); // PEKERJAAN
            $table->foreign('work_id')->references('id')->on('works')->onUpdate('cascade');
            $table->string('blood_group'); // GOLONGAN DARAH
            $table->string('marital_status'); // STATUS PERKAWINAN
            $table->string('wedding_date')->nullable(); // TANGGAL PERKAWINAN
            $table->string('relationship_status'); // STATUS HUBUNGAN DALAM KELUARGA
            $table->string('citizenship'); // KEWARGANEGARAAN
            $table->string('paspor_number')->nullable(); // NOMOR PASPOR
            $table->string('kitap_number')->nullable(); // NOMOR KITAP
            $table->string('father_name'); // NAMA AYAH
            $table->string('mother_name'); // NAMA IBU
            $table->string('phone_number'); // NOMOR TELEPON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
