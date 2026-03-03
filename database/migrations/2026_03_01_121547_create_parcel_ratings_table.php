<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcel_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            $table->integer('rating')->comment('1-5 stars');
            $table->text('feedback')->nullable();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->timestamps();
            
            // Ensure one rating per parcel
            $table->unique('parcel_id');
        });

        // Add average rating to agents
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('average_rating', 3, 2)->nullable()->after('role');
            $table->integer('total_ratings')->default(0)->after('average_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcel_ratings');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['average_rating', 'total_ratings']);
        });
    }
};