<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roles = [
            'IT ADMINISTRATOR',
            'ADMINISTRATOR',
            'USER'
        ];

        foreach ($roles as $role) {
            $check = Role::where('name', $role)->first();
            if (!$check) {
                Role::create(['name' => $role]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $users = [
                [
                    "user_name" => "admin",
                    "first_name" => "IT",
                    "last_name" => "Admin",
                    "password" => Hash::make("N11t47mu38"),
                ],
                [
                    "user_name" => "chrmo",
                    "first_name" => "CHRMO",
                    "last_name" => "Admin",
                    "password" => Hash::make("chrmo123"),
                ]
            ];

            foreach ($users as $user) {
                $check = User::where('user_name', $user['user_name'])->first();

                if (!$check) {
                    User::create([
                        "user_name" => $user['user_name'],
                        "first_name" => $user['first_name'],
                        "last_name" => $user['last_name'],
                        "password" => $user['password']
                    ]);

                    $user = User::where('user_name', $user['user_name'])->first();
                    if ($user['user_name'] === 'chrmo') {
                        $user->assignRole('ADMINISTRATOR');
                    } else {
                        $user->assignRole('IT ADMINISTRATOR');
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $users = [
                [
                    "user_name" => "admin",
                    "first_name" => "IT",
                    "last_name" => "Admin",
                ],
                [
                    "user_name" => "chrmo",
                    "first_name" => "CHRMO",
                    "last_name" => "Admin",
                ]
            ];

            foreach ($users as $user) {
                User::where('user_name', $user['user_name'])->delete();
            }
        });

        $roles = ['IT ADMINISTRATOR', 'ADMINISTRATOR', 'USER'];

        foreach ($roles as $role) {
            Role::where('name', $role)->delete();
        }
    }
};
