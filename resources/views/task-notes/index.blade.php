@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Task Notes</h5>
                    <a href="{{ route('task-notes.create') }}" class="btn btn-primary">Add Note</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Note</th>
                                    <th>Added By</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taskNotes as $note)
                                <tr>
                                    <td>{{ $note->task->title }}</td>
                                    <td>{{ $note->note }}</td>
                                    <td>{{ $note->user->name }}</td>
                                    <td>{{ $note->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('task-notes.edit', $note) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('task-notes.destroy', $note) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $taskNotes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection