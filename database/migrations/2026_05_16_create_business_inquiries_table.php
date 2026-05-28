<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->createBusinessesTableIfMissing();

        if (Schema::hasTable('business_inquiries')) {
            return;
        }

        Schema::create('business_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('broker_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->string('status')->default('pending'); // pending, replied, archived
            $table->timestamp('replied_at')->nullable();
            $table->text('reply_message')->nullable();
            $table->timestamps();

            $table->index('business_id');
            $table->index('status');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_inquiries');
    }

    private function createBusinessesTableIfMissing(): void
    {
        if (Schema::hasTable('businesses')) {
            return;
        }

        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('overview')->nullable();
            $table->string('business_type');
            $table->string('industry');
            $table->string('location');
            $table->decimal('asking_price', 15, 2);
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->decimal('annual_profit', 15, 2)->nullable();
            $table->integer('years_in_operation')->nullable();
            $table->integer('employees')->nullable();
            $table->string('status')->default('draft');
            $table->json('meta')->nullable();
            $table->text('features')->nullable();
            $table->text('highlights')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('status');
            $table->index('user_id');
            $table->index('business_type');
            $table->index('industry');
        });
    }
};
