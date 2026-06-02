<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add country_code to users table
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'country_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('country_code')->default('usa')->after('id');
                $table->index('country_code');
            });
        }

        // Add country_code to posts table
        if (Schema::hasTable('posts') && ! Schema::hasColumn('posts', 'country_code')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('country_code')->default('usa')->after('id');
                $table->index('country_code');
            });
        }

        // Add country_code to businesses table if exists
        if (Schema::hasTable('businesses') && ! Schema::hasColumn('businesses', 'country_code')) {
            Schema::table('businesses', function (Blueprint $table) {
                $table->string('country_code')->default('usa')->after('id');
                $table->index('country_code');
            });
        }

        // Add country_code to enquiries table if exists
        if (Schema::hasTable('enquiries') && ! Schema::hasColumn('enquiries', 'country_code')) {
            Schema::table('enquiries', function (Blueprint $table) {
                $table->string('country_code')->default('usa')->after('id');
                $table->index('country_code');
            });
        }

        // Add country_code to newsletter table if exists
        if (Schema::hasTable('newsletter') && ! Schema::hasColumn('newsletter', 'country_code')) {
            Schema::table('newsletter', function (Blueprint $table) {
                $table->string('country_code')->default('usa')->after('id');
                $table->index('country_code');
            });
        }
    }

    public function down(): void
    {
        // Remove country_code from all tables
        foreach (['users', 'posts', 'businesses', 'enquiries', 'newsletter'] as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'country_code')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropIndex(['country_code']);
                    $table->dropColumn('country_code');
                });
            }
        }
    }
};
