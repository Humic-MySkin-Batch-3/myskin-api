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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('accounts')->onDelete('cascade');
            $table->string('specialization');
            $table->string('license_number')->unique();
            $table->string('license_file_path'); // PDF Surat Tanda Registrasi
            $table->string('diploma_file_path'); // PDF Ijazah
            $table->text('certification'); // Sertifikat Keahlian
            $table->string('current_institution');
            $table->integer('years_of_experience');
            $table->text('work_history');
            $table->text('publications');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
