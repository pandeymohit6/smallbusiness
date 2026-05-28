<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
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
            $table->string('status')->default('draft'); // draft, active, sold, delisted
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

    public function down(): void
    {
        Schema::dropIfExists('business_inquiries');
        Schema::dropIfExists('business_galleries');
        Schema::dropIfExists('businesses');
    }
};
