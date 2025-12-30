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
            $table->boolean('is_banned')->default(false)->after('role');
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->boolean('is_flagged')->default(false)->after('comments_count');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('is_flagged');
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_banned')) {
                $table->dropColumn('is_banned');
            }
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $columns = ['is_flagged', 'status', 'rejection_reason'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('portfolios', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
