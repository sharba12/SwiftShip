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
    Schema::table('parcel_status_logs', function (Blueprint $table) {
        $table->string('old_status')->nullable()->after('parcel_id');
        $table->renameColumn('status', 'new_status');
        $table->unsignedBigInteger('changed_by')->nullable()->after('new_status');
        $table->foreign('changed_by')->references('id')->on('users')->nullOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parcel_status_logs', function (Blueprint $table) {
            //
        });
    }
};
