<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('business_inquiries')) {
            return;
        }

        Schema::table('business_inquiries', function (Blueprint $table) {
            if (! Schema::hasColumn('business_inquiries', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('business_id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('business_inquiries', 'broker_id')) {
                $table->foreignId('broker_id')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('business_inquiries')) {
            return;
        }

        Schema::table('business_inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('business_inquiries', 'broker_id')) {
                $table->dropConstrainedForeignId('broker_id');
            }

            if (Schema::hasColumn('business_inquiries', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
