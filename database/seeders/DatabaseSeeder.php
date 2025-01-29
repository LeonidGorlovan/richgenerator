<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use CfDigital\Delta\Core\database\seeders\CoreSeeder;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CoreSeeder::class
        ]);

        $role = Role::create(['name' => 'developer']);

        foreach (config('delta.permissions.other') as $role_base) {
            Permission::create(['name' => $role_base]);
        }

        foreach (config('delta.permissions.crud') as $role_base) {
            Permission::create(['name' => 'view ' . $role_base]);
            Permission::create(['name' => 'create ' . $role_base]);
            Permission::create(['name' => 'edit ' . $role_base]);
            Permission::create(['name' => 'delete ' . $role_base]);
        }

        $role->givePermissionTo(Permission::pluck('name')->toArray());

        $pass = 'eQHIL49CeV';
        $user = User::factory()->create(['email' => 'user@gmail.com', 'password' => bcrypt($pass)]);
        $user->assignRole($role);

        echo $pass . PHP_EOL;
    }
}
