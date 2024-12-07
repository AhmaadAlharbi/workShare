<!-- resources/views/dashboard.blade.php -->
@extends('layouts.main')

@section('title', 'Dashboard - Task Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Task Dashboard</h2>
            <div>
                {{-- <a href="#" class="btn btn-light me-2">
                    <i class="fas fa-bell"></i>
                </a> --}}
                <div class="dropdown">
                    <a class="btn btn-light" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        @forelse(auth()->user()->notifications->take(5) as $notification)
                        <a class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}"
                            href="{{ route('tasks.show', $notification->data['task_id']) }}"
                            onclick="markAsRead(event, '{{ $notification->id }}')">
                            {{ $notification->data['message'] }}
                            <small class="text-muted d-block">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </a>
                        @empty
                        <span class="dropdown-item">No notifications</span>
                        @endforelse
                    </div>
                </div>
                <a href="{{route('tasks.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Task
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Filter Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="btn-group">
            <a href="{{ route('dashboard.all-tasks') }}" class="btn btn-outline-primary active">All</a>
            <a href="/" class="btn btn-outline-primary">My Department</a>
            <a href="{{ route('dashboard.shared-tasks') }}" class="btn btn-outline-primary">Shared With
                Us</a>
        </div>
    </div>
</div>

<!-- Tasks Table -->
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->title}}</td>
                    <td>
                        @foreach($task->departments as $department)
                        {{ $department->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </td>
                    <td>{{$task->status}}</td>
                    <td><a href="{{route('tasks.show',$task)}}" class="btn btn-primary">View</a></td>
                </tr>
                @endforeach
                <!-- We'll populate this with actual data later -->
            </tbody>
        </table>
    </div>
</div>

<!-- Create Task Modal -->
{{-- @include('modals.create-task') --}}
@endsection