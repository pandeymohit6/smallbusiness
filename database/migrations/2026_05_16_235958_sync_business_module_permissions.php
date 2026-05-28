<?php

declare(strict_types=1);

use App\Services\PermissionService;
use App\Services\RolesService;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        app(PermissionService::class)->createPermissions();
        app(RolesService::class)->createPredefinedRoles();
    }

    public function down(): void
    {
        PermissionService::removePermissions([
            'business.create',
            'business.view',
            'business.edit',
            'business.delete',
            'business.manage',
            'business_inquiry.create',
            'business_inquiry.view',
            'business_inquiry.edit',
            'business_inquiry.reply',
            'business_inquiry.assign_broker',
        ]);
    }
};
