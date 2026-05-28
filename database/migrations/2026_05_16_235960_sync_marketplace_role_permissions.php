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
            'newsletter.create',
            'newsletter.view',
            'newsletter.edit',
            'newsletter.delete',
        ]);
    }
};
