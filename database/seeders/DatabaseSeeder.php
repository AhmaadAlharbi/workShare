<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            DepartmentSeeder::class,
        ]);
        // User::factory()->create([
        //     'name' => 'Ahmad Zaid',
        //     'email' => 'ahmaadzaid7@gmail.com',
        //     'password' => Hash::make('12345678'),
        //     'department_id' => Department::first()->id,

        // ]);
        User::factory()
            ->firstUser()
            ->create();

        // Create additional random users
        User::factory(10)  // Creates 10 random users, adjust number as needed
            ->create();
        $this->call([
            TaskSeeder::class,
            TaskNoteSeeder::class,
            TaskCommentSeeder::class,

        ]);
    }
}