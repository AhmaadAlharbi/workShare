<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskCommentController;

// Route::get('/', function () {
//     // return view('welcome');
//     return view('index');
// });
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth'); //to Get all tasks created by auth department
Route::get('/shared-tasks', [DashboardController::class, 'sharedTasks'])
    ->name('dashboard.shared-tasks')
    ->middleware('auth');
Route::get('/all-tasks', [DashboardController::class, 'allTasks'])
    ->name('dashboard.all-tasks')
    ->middleware('auth');
Route::resource('tasks', TaskController::class)->middleware('auth');
Route::resource('task-notes', TaskNoteController::class);
Route::resource('task-comments', TaskCommentController::class);
Route::get('/notifications/{id}/read', [TaskController::class, 'markNotificationAsRead'])
    ->name('notifications.read');

use App\Http\Controllers\EmailTestController;

Route::get('/send-test-email', [TaskController::class, 'sendTestEmail']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
