<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            // change the enum to include 'admin'
            $table->enum('role', ['patient','doctor','admin'])
                ->default('patient')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            // revert to original
            $table->enum('role', ['patient','doctor'])
                ->default('patient')
                ->change();
        });
    }
};
