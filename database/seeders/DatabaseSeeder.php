<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
//        Post::factory()->count(10)->create();
//        Permission::create(['name' => 'Super Admin']);
//        Role::create(['name' => 'Super Admin']);
//        $superAdmin = User::query()->where('name', 'super admin')->first();
//        $superAdmin->assignRole(['Super Admin']);
//        Comment::factory()->count(30)->create();
    }
}
