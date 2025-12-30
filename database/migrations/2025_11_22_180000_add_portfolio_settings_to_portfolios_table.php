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
            // Visibility settings
            $table->enum('visibility', ['public', 'private'])->default('public')->after('status');
            
            // Order/sequence
            $table->integer('display_order')->default(0)->after('visibility');
            
            // Highlight feature
            $table->boolean('is_highlighted')->default(false)->after('display_order');
            $table->dateTime('highlighted_until')->nullable()->after('is_highlighted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['visibility', 'display_order', 'is_highlighted', 'highlighted_until']);
        });
    }
};
