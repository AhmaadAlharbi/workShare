<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskNote>
 */
class TaskNoteFactory extends Factory
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
            'note' => $this->getRealisticNote(),
        ];
    }
    private function getRealisticNote(): string
    {
        return $this->faker->randomElement([
            'Updated the backend API to handle the new requirements. Testing needed.',
            'Client requested changes to the color scheme. Will update mockups.',
            'Fixed the bug in user authentication. All tests are passing now.',
            'Added input validation for all form fields as requested.',
            'Performance optimization complete. Load time reduced by 40%.',
            'Scheduled meeting with stakeholders for next week to review progress.',
            'Database indexes have been added to improve query performance.',
            'Documentation has been updated to reflect recent changes.',
            'Merged the feature branch after successful code review.',
            'Need additional clarification on the reporting requirements.',
            'Security patches have been applied as per the audit recommendations.',
            'UI responsiveness issues fixed for mobile devices.',
            'Created backup of current database before proceeding with migrations.',
            'Integration tests are failing. Investigating the root cause.',
            'Updated dependencies to their latest stable versions.'
        ]);
    }
}