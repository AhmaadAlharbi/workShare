<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskNote;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create random notes for existing tasks
        Task::all()->each(function ($task) {
            // Create 2-5 notes for each task
            $numberOfNotes = rand(2, 5);

            for ($i = 0; $i < $numberOfNotes; $i++) {
                TaskNote::factory()->create([
                    'task_id' => $task->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                ]);
            }
        });

        // Create specific notes for testing
        $admin = User::where('email', 'ahmaadzaid7@gmail.com')->first();
        if ($admin) {
            $task = Task::inRandomOrder()->first();
            if ($task) {
                TaskNote::create([
                    'task_id' => $task->id,
                    'user_id' => $admin->id,
                    'note' => 'Initial project requirements reviewed and documented. Team alignment confirmed.',
                ]);

                TaskNote::create([
                    'task_id' => $task->id,
                    'user_id' => $admin->id,
                    'note' => 'Progress update: Development phase is 60% complete. On track for delivery.',
                ]);
            }
        }
    }
}