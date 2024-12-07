<?php
// app/Notifications/TaskAssigned.php
namespace App\Notifications;

use App\Models\Task;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskAssigned extends Notification
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $url = route('tasks.show', $this->task->id);

        return (new MailMessage)
            ->subject('New Task Assigned: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have been assigned a new task by ' . auth()->user()->name . '.')
            ->line('Task Details:')
            ->line('Title: ' . $this->task->title)
            ->line('Description: ' . $this->task->description)
            ->line('Status: ' . ucfirst($this->task->status))
            ->action('View Task', $url)
            ->line('Please review the task and start working on it at your earliest convenience.')
            ->salutation('Best regards,\n' . config('app.name') . ' Team');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New task assigned: {$this->task->title}",
            'task_id' => $this->task->id,
            'assigned_by' => auth()->user()->name,
            'task_title' => $this->task->title
        ];
    }
}
