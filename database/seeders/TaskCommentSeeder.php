<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskComment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create random comments for existing tasks
        Task::all()->each(function ($task) {
            // Create 3-7 comments for each task
            $numberOfComments = rand(3, 7);

            // Get a few random users for more realistic comment threads
            $users = User::inRandomOrder()->take(3)->get();

            for ($i = 0; $i < $numberOfComments; $i++) {
                TaskComment::factory()->create([
                    'task_id' => $task->id,
                    'user_id' => $users->random()->id,
                    'created_at' => now()->subHours(rand(1, 72)) // Random times within last 3 days
                ]);
            }
        });

        // Create a specific comment thread for testing
        $admin = User::where('email', 'ahmaadzaid7@gmail.com')->first();
        if ($admin) {
            $task = Task::inRandomOrder()->first();
            if ($task) {
                // Admin starts the thread
                TaskComment::create([
                    'task_id' => $task->id,
                    'user_id' => $admin->id,
                    'comment' => 'Team, please review the latest changes I pushed to the development branch.',
                    'created_at' => now()->subHours(5)
                ]);

                // Get another user to respond
                $otherUser = User::where('id', '!=', $admin->id)->inRandomOrder()->first();
                if ($otherUser) {
                    TaskComment::create([
                        'task_id' => $task->id,
                        'user_id' => $otherUser->id,
                        'comment' => 'Reviewed the changes. Looks good! Just one minor suggestion about error handling.',
                        'created_at' => now()->subHours(3)
                    ]);

                    // Admin responds back
                    TaskComment::create([
                        'task_id' => $task->id,
                        'user_id' => $admin->id,
                        'comment' => 'Thanks for the feedback! I\'ll update the error handling and push the changes.',
                        'created_at' => now()->subHours(1)
                    ]);
                }
            }
        }
    }
}