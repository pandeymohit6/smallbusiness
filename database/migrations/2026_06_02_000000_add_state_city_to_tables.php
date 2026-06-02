<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add state and city to businesses table
        if (Schema::hasTable('businesses')) {
            Schema::table('businesses', function (Blueprint $table) {
                if (!Schema::hasColumn('businesses', 'state')) {
                    $table->string('state')->nullable()->after('location');
                }
                if (!Schema::hasColumn('businesses', 'city')) {
                    $table->string('city')->nullable()->after('state');
                }
            });
        }

        // Add state and city to users table
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'state')) {
                    $table->string('state')->nullable()->after('country_code');
                }
                if (!Schema::hasColumn('users', 'city')) {
                    $table->string('city')->nullable()->after('state');
                }
            });
        }

        // Add state and city to posts table
        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                if (!Schema::hasColumn('posts', 'state')) {
                    $table->string('state')->nullable()->after('country_code');
                }
                if (!Schema::hasColumn('posts', 'city')) {
                    $table->string('city')->nullable()->after('state');
                }
            });
        }

        // Add state and city to enquiries table if exists
        if (Schema::hasTable('enquiries')) {
            Schema::table('enquiries', function (Blueprint $table) {
                if (!Schema::hasColumn('enquiries', 'state')) {
                    $table->string('state')->nullable()->after('country_code');
                }
                if (!Schema::hasColumn('enquiries', 'city')) {
                    $table->string('city')->nullable()->after('state');
                }
            });
        }
    }

    public function down(): void
    {
        // Remove state and city from all tables
        foreach (['businesses', 'users', 'posts', 'enquiries'] as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'state')) {
                        $table->dropColumn('state');
                    }
                    if (Schema::hasColumn($table->getTable(), 'city')) {
                        $table->dropColumn('city');
                    }
                });
            }
        }
    }
};
