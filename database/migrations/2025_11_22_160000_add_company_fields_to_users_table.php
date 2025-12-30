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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['individual', 'company'])->default('individual')->after('role');
            $table->string('company_name')->nullable()->after('user_type');
            $table->string('company_website')->nullable()->after('company_name');
            $table->text('company_description')->nullable()->after('company_website');
            $table->string('company_phone')->nullable()->after('company_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'company_name', 'company_website', 'company_description', 'company_phone']);
        });
    }
};
