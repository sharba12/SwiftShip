<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('email_notifications')->default(true)->after('address');
            $table->boolean('sms_notifications')->default(false)->after('email_notifications');
        });

        // Add notification log table
        Schema::create('parcel_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // email, sms
            $table->string('status'); // pending, sent, failed
            $table->string('recipient');
            $table->text('message');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['email_notifications', 'sms_notifications']);
        });
        
        Schema::dropIfExists('parcel_notifications');
    }
};