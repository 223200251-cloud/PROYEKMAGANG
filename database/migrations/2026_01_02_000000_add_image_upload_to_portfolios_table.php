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
        Schema::table('portfolios', function (Blueprint $table) {
            // Tambah kolom untuk membedakan tipe image
            $table->enum('image_type', ['uploaded', 'url'])->default('url')->after('image_url');
            // Kolom untuk menyimpan path file upload
            $table->string('image_path')->nullable()->after('image_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['image_type', 'image_path']);
        });
    }
};
