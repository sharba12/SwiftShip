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
            if (! Schema::hasColumn('users', 'average_rating')) {
                $table->decimal('average_rating', 3, 2)->nullable()->after('role');
            }

            if (! Schema::hasColumn('users', 'total_ratings')) {
                $table->integer('total_ratings')->default(0)->after('average_rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'average_rating')) {
                $table->dropColumn('average_rating');
            }

            if (Schema::hasColumn('users', 'total_ratings')) {
                $table->dropColumn('total_ratings');
            }
        });
    }
};