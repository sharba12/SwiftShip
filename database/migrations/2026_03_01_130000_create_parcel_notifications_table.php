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
        Schema::create('parcel_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['email', 'sms']); // notification type
            $table->enum('status', ['sent', 'failed']); // delivery status
            $table->string('recipient'); // email or phone number
            $table->text('message'); // notification content
            $table->text('error_message')->nullable(); // error if failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_notifications');
    }
};