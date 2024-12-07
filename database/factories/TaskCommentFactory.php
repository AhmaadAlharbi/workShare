<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskComment>
 */
class TaskCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::inRandomOrder()->first()->id ?? Task::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'comment' => $this->getRealisticComment(),
        ];
    }
    private function getRealisticComment(): string
    {
        return $this->faker->randomElement([
            'I have reviewed the changes and everything looks good to merge.',
            'Can we schedule a quick call to discuss these requirements?',
            'The bug has been fixed in the latest commit. Please test.',
            'I suggest we use a different approach for this feature.',
            'Great progress! Just a few minor adjustments needed.',
            'I have added more test cases to cover edge scenarios.',
            'This looks ready for production deployment.',
            'The client approved these changes in today\'s meeting.',
            'I\'ll take care of the documentation updates.',
            'Need help with optimizing this database query.',
            'UI improvements look great on mobile devices now.',
            'Can someone review my pull request?',
            'All automated tests are passing now.',
            'Added error handling for edge cases.',
            'The performance issues have been resolved.'
        ]);
    }
}