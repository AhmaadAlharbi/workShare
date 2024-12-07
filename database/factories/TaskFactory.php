<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->getRandomTitle(),
            'description' => $this->getRandomDescription(),
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'completed']),
            'assigned_user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory()
        ];
    }
    private function getRandomTitle(): string
    {
        return $this->faker->randomElement([
            'Review project documentation',
            'Update user authentication system',
            'Fix responsive design issues',
            'Optimize database queries',
            'Implement new feature request',
            'Create backup system',
            'Setup monitoring tools',
            'Update security protocols',
            'Refactor legacy code',
            'Write unit tests',
            'Deploy new version',
            'Configure CI/CD pipeline',
            'Update API documentation',
            'Perform security audit',
            'Implement data validation'
        ]);
    }

    private function getRandomDescription(): string
    {
        return $this->faker->randomElement([
            'Review and update all project documentation to ensure it reflects the latest changes. Include API endpoints, database schema, and deployment procedures.',
            'Enhance the current authentication system by implementing two-factor authentication and updating password reset functionality.',
            'Address responsive design issues on mobile devices, particularly for the dashboard and reporting pages.',
            'Analyze and optimize slow database queries. Focus on the reporting module and user activity logs.',
            'Implement the new feature requested by the client for automated report generation and email notifications.',
            'Set up an automated backup system for both database and file storage with proper encryption.',
            'Install and configure monitoring tools for server performance, error logging, and user activity tracking.',
            'Update security protocols including API authentication, input validation, and XSS prevention measures.',
            'Refactor the legacy payment processing module to improve maintainability and performance.',
            'Develop comprehensive unit tests for the recently added features in the admin module.',
            'Prepare and execute deployment of version 2.0 including database migrations and cache clearing.',
            'Set up and configure CI/CD pipeline using GitHub Actions for automated testing and deployment.',
            'Update API documentation with new endpoints, request/response examples, and authentication details.',
            'Conduct thorough security audit of application including penetration testing and vulnerability assessment.',
            'Implement robust data validation for all user inputs including file uploads and form submissions.'
        ]);
    }
}
