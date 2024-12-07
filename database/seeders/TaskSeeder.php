<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 random tasks and assign departments
        Task::factory(20)->create()->each(function ($task) {
            // Assign 1-3 random departments to each task
            $departmentIds = Department::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');

            $task->departments()->attach($departmentIds);
        });

        // Create specific tasks for admin user
        $admin = User::where('email', 'ahmaadzaid7@gmail.com')->first();

        if ($admin) {
            // Create Initial Project Setup task
            $projectSetupTask = Task::factory()->create([
                'title' => 'Initial Project Setup',
                'description' => 'Set up the development environment, configure version control, and establish coding standards for the team.',
                'status' => 'completed',
                'user_id' => $admin->id,
            ]);

            // Create Team Training Session task
            $trainingTask = Task::factory()->create([
                'title' => 'Team Training Session',
                'description' => 'Prepare and conduct training session for new team members on our development workflow and best practices.',
                'status' => 'pending',
                'user_id' => $admin->id,
            ]);

            // Assign departments to admin's tasks
            // Project Setup task assigned to IT and Operations
            $projectSetupTask->departments()->attach(
                Department::whereIn('name', ['IT', 'Operations'])->pluck('id')
            );

            // Training task assigned to HR and IT
            $trainingTask->departments()->attach(
                Department::whereIn('name', ['HR', 'IT'])->pluck('id')
            );
        }
    }
}