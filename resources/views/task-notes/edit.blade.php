@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Note</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('task-notes.update', $taskNote) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="task_id" class="form-label">Task</label>
                            <select name="task_id" id="task_id" class="form-select" required>
                                <option value="">Select Task</option>
                                @foreach($tasks as $task)
                                <option value="{{ $task->id }}" {{ $taskNote->task_id == $task->id ? 'selected' : '' }}>
                                    {{ $task->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea name="note" id="note" rows="4" class="form-control"
                                required>{{ old('note', $taskNote->note) }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Note</button>
                            <a href="{{ route('task-notes.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection