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
            $table->ulid('id')->primary();

            // Personal Information
            $table->string('nip')->unique()->nullable(); // Nomor Induk Pegawai
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('address')->nullable();

            // Employment Information
            $table->string('position'); // Jabatan
            $table->string('rank')->nullable(); // Golongan/Pangkat
            $table->string('department')->nullable(); // Unit Kerja
            $table->date('join_date')->nullable(); // Tanggal Mulai Kerja
            $table->enum('employment_status', ['PNS', 'PPPK', 'Honorer', 'Kontrak'])->default('PNS');

            // Additional Information
            $table->string('education_level')->nullable(); // Pendidikan Terakhir
            $table->text('bio')->nullable(); // Biografi singkat
            $table->json('social_media')->nullable(); // Social media links

            // Status
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0); // Urutan tampilan

            // User Stamps (users table uses ULID)
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
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
