<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsManagment extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $departmients = ['IT', 'HR', 'Finance', 'Operations', 'Sales'];

        foreach ($departmients as $dept) {
            Category::create(['name' => $dept]);
        }

        $admin_user = User::create([
            'name' => 'Test User',
            'email' => 'omar@app.com',
            'password' => bcrypt('123456'),
            'category_id' => Category::where('name', 'IT')->first()->id,
        ]);

        $user_user = User::create([
            'name' => 'Normal User',
            'email' => 'user@app.com',
            'password' => bcrypt('123456'),
            'category_id' => Category::where('name', 'Finance')->first()->id,
        ]);

        // إنشاء صلاحيات
        Permission::create(['name' => 'create tickets']);
        Permission::create(['name' => 'reply tickets']);
        Permission::create(['name' => 'manage tickets']);
        Permission::create(['name' => 'assign tickets']);
        Permission::create(['name' => 'close tickets']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);




        // إنشاء أدوار
        $admin = Role::create(['name' => 'admin']);
        $agent = Role::create(['name' => 'agent']);
        $user = Role::create(['name' => 'user']);

        // ربط الصلاحيات بالأدوار
        $admin->givePermissionTo(Permission::all());
        $agent->givePermissionTo(['reply tickets', 'assign tickets']);
        $user->givePermissionTo(['create tickets']);

        // تعيين دور للمستخدم الجديد
        $admin_user->assignRole('admin');
        $user_user->assignRole('user');
    }
}
