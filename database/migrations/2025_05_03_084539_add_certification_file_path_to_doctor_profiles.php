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
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->string('certification_file_path')->nullable()->after('diploma_file_path');
            $table->dropColumn('certification');
        });
    }

    public function down(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->text('certification')->nullable()->after('diploma_file_path');
            $table->dropColumn('certification_file_path');
        });
    }

};
