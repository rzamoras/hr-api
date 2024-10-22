<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('type')->after('guard_name')->default('SYSTEM');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->string('type')->after('guard_name')->default('SYSTEM');
        });

        $permissions = [
            'permission.add',
            'permission.delete',
            'permission.edit',
            'permission.view',
            'user.add',
            'user.delete',
            'user.edit',
            'user.view',
            'role.add',
            'role.delete',
            'role.edit',
            'role.view',
        ];

        $it_permissions = [
            'user.restore',
        ];

        $all_permissions = array_merge($permissions, $it_permissions);

        foreach ($all_permissions as $permission) {
            $check = Permission::where('name', $permission)->first();

            if (!$check) {
                Permission::create(['name' => $permission]);
            }
        }

        $role = Role::where('name', 'ADMINISTRATOR')->first();
        $role->syncPermissions($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        $permissions = [
            'permission.add',
            'permission.delete',
            'permission.edit',
            'permission.view',
            'user.add',
            'user.delete',
            'user.edit',
            'user.view',
            'role.add',
            'role.delete',
            'role.edit',
            'role.view',
            'user.restore'
        ];

        $role = Role::where('name', 'ADMINISTRATOR')->first();

        foreach ($permissions as $permission) {
            $check = Permission::where('name', $permission)->first();

            if ($check) {
                Permission::destroy($permission);
                $role->revokePermissionTo($permission);
            }
        }

    }
};
