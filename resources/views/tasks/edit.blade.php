@extends('layouts.main')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Task</h5>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    required>{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="in-progress" {{ old('status', $task->status) == 'in-progress' ? 'selected' : '' }}>In
                        Progress</option>
                    <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : ''
                        }}>Completed</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Share with Departments</label>
                @foreach($departments as $department)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="departments[]" value="{{ $department->id }}"
                        id="dept{{ $department->id }}" {{ in_array($department->id,
                    $task->departments->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dept{{ $department->id }}">
                        {{ $department->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection