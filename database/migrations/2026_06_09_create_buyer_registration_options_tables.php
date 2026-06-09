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
        // Create buyer types table
        Schema::create('buyer_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create buyer experiences table
        Schema::create('buyer_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create countries table
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 2)->nullable()->unique();
            $table->string('phone_code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Create buyer registrations table
        Schema::create('buyer_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('buyer_type_id')->constrained('buyer_types');
            $table->foreignId('buyer_experience_id')->constrained('buyer_experiences');
            $table->boolean('newsletter')->default(false);
            $table->boolean('third_party_emails')->default(false);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_registrations');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('buyer_experiences');
        Schema::dropIfExists('buyer_types');
    }
};
