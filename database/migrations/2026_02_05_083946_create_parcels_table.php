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
        Schema::create('parcels', function (Blueprint $table) {
    $table->id();
    $table->string('tracking_id')->unique();

    $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
    $table->foreignId('agent_id')->nullable()->constrained('users');

    $table->string('sender_name');
    $table->string('receiver_name');
    $table->string('receiver_contact');

    $table->text('parcel_description')->nullable();
    $table->decimal('weight', 6, 2);

    $table->text('address_from');
    $table->text('address_to');

    $table->enum('status', [
        'pending',
        'in_transit',
        'out_for_delivery',
        'delivered',
        'failed'
    ])->default('pending');

    $table->text('notes')->nullable();

    $table->decimal('current_lat', 10, 7)->nullable();
    $table->decimal('current_lng', 10, 7)->nullable();

    $table->timestamp('in_transit_at')->nullable();
    $table->timestamp('out_for_delivery_at')->nullable();
    $table->timestamp('delivered_at')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
