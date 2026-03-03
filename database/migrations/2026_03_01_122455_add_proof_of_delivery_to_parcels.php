<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->text('signature_data')->nullable()->after('delivered_at');
            $table->string('delivery_photo')->nullable()->after('signature_data');
            $table->string('recipient_name_confirmed')->nullable()->after('delivery_photo');
            $table->timestamp('proof_submitted_at')->nullable()->after('recipient_name_confirmed');
        });
    }

    public function down(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropColumn([
                'signature_data',
                'delivery_photo',
                'recipient_name_confirmed',
                'proof_submitted_at'
            ]);
        });
    }
};