<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('parcel_status_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('parcel_id')->constrained()->onDelete('cascade');
        $table->string('status'); // pending, picked_up, etc.
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_status_logs');
    }
};
