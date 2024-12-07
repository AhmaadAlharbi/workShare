@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Left Column: Task Details -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>Task Details
                    </h5>
                    <span
                        class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in-progress' ? 'warning' : 'secondary') }} fs-6">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <h4 class="border-bottom pb-2">{{ $task->title }}</h4>

                    <div class="task-details">
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Description</h6>
                            <p class="border-start border-4 border-primary ps-3 bg-light p-2 rounded">
                                {{ $task->description }}
                            </p>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-card bg-light p-2 rounded">
                                    <h6 class="text-muted mb-1">
                                        <i class="bi bi-person-fill me-1"></i>Created By
                                    </h6>
                                    <p class="mb-0 ms-4">{{ $task->user->name }}</p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="info-card bg-light p-2 rounded">
                                    <h6 class="text-muted mb-1">
                                        <i class="bi bi-building me-1"></i>Primary Department
                                    </h6>
                                    <p class="mb-0 ms-4">{{ $task->primaryDepartment->name }}</p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="info-card bg-light p-2 rounded">
                                    <h6 class="text-muted mb-1">
                                        <i class="bi bi-share me-1"></i>Shared With
                                    </h6>
                                    <div class="ms-4">
                                        @foreach($task->departments as $department)
                                        <span class="badge bg-primary me-1 mb-1">{{ $department->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="info-card bg-light p-2 rounded text-center">
                                    <small class="text-muted d-block">Created</small>
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $task->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="info-card bg-light p-2 rounded text-center">
                                    <small class="text-muted d-block">Updated</small>
                                    <i class="bi bi-clock-history"></i>
                                    {{ $task->updated_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        @if(Auth::user()->department_id === $task->department_id)
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square me-1"></i>Edit Task
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this task?')">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm ms-auto">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Tabs for Notes and Comments -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light p-0">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#notes" type="button"
                                role="tab">
                                <i class="bi bi-journal-text me-2"></i>Notes
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#comments" type="button"
                                role="tab">
                                <i class="bi bi-chat-dots me-2"></i>Comments
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Notes Tab -->
                        <div class="tab-pane fade show active" id="notes" role="tabpanel">
                            <!-- New Note Form -->
                            <div class="new-note-section mb-4">
                                <form action="{{ route('task-notes.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-plus-circle me-1"></i>Add Note
                                        </label>
                                        <textarea name="note" class="form-control @error('note') is-invalid @enderror"
                                            rows="3" placeholder="Type your note here..."></textarea>
                                        @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send me-1"></i>Add Note
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Notes Timeline -->
                            <div class="notes-timeline">
                                @forelse($taskNotes as $note)
                                <div class="note-card mb-3 bg-light rounded p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <span class="fw-bold text-primary">{{ $note->user->name }}</span>
                                            <span class="text-muted ms-2 small">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $note->created_at->format('M d, Y H:i') }}
                                            </span>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-secondary"
                                                onclick="toggleEditForm({{ $note->id }})">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('task-notes.destroy', $note) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div id="note-view-{{ $note->id }}" class="mt-2">
                                        <p class="mb-0">{{ $note->note }}</p>
                                    </div>

                                    <div id="note-edit-{{ $note->id }}" class="mt-2" style="display: none;">
                                        <form action="{{ route('task-notes.update', $note) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                            <textarea name="note" rows="3"
                                                class="form-control mb-2">{{ $note->note }}</textarea>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    onclick="toggleEditForm({{ $note->id }})">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-journal-text display-4"></i>
                                    <p class="mt-2">No notes added yet</p>
                                </div>
                                @endforelse

                                <div class="mt-3">
                                    {{ $taskNotes->links() }}
                                </div>
                            </div>
                        </div>

                        <!-- Comments Tab -->
                        <div class="tab-pane fade" id="comments" role="tabpanel">
                            <div class="comments-section" style="height: 60vh; overflow-y: auto;">
                                @forelse($taskComments as $comment)
                                <div class="comment-item mb-3">
                                    <div
                                        class="d-flex {{ $comment->user_id === Auth::id() ? 'flex-row-reverse' : '' }}">
                                        <div class="comment-bubble {{ $comment->user_id === Auth::id() ? 'ms-auto bg-primary text-white' : 'bg-light' }} 
                                                p-3 rounded-3 {{ $comment->user_id === Auth::id() ? 'me-2' : 'ms-2' }}"
                                            style="max-width: 80%;">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small
                                                    class="text-{{ $comment->user_id === Auth::id() ? 'light' : 'muted' }}">
                                                    {{ $comment->user->name }}
                                                </small>
                                                <small
                                                    class="text-{{ $comment->user_id === Auth::id() ? 'light' : 'muted' }}">
                                                    {{ $comment->created_at->format('M d, H:i') }}
                                                </small>
                                            </div>

                                            <div id="comment-view-{{ $comment->id }}">
                                                <p class="mb-0">{{ $comment->comment }}</p>
                                                @if($comment->user_id === Auth::id())
                                                <div class="comment-actions mt-2 text-end">
                                                    <button
                                                        class="btn btn-sm btn-link text-{{ $comment->user_id === Auth::id() ? 'light' : 'primary' }}"
                                                        onclick="toggleCommentEdit({{ $comment->id }})">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('task-comments.destroy', $comment) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-link text-{{ $comment->user_id === Auth::id() ? 'light' : 'danger' }}"
                                                            onclick="return confirm('Delete this comment?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
                                            </div>

                                            <div id="comment-edit-{{ $comment->id }}" style="display: none;">
                                                <form action="{{ route('task-comments.update', $comment) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="comment" class="form-control form-control-sm mb-2"
                                                        rows="2">{{ $comment->comment }}</textarea>
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-sm btn-light"
                                                            onclick="toggleCommentEdit({{ $comment->id }})">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            Update
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-chat-dots display-4"></i>
                                    <p class="mt-2">No comments yet. Start the conversation!</p>
                                </div>
                                @endforelse
                            </div>

                            <!-- Fixed Comment Input at Bottom -->
                            <div class="comment-input-section border-top pt-3 bg-white">
                                <form action="{{ route('task-comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                    <div class="input-group">
                                        <textarea name="comment" class="form-control" placeholder="Type your comment..."
                                            rows="1" style="resize: none;"></textarea>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert for Notes/Comments -->
@if(session('success') || session('comment_success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') ?? session('comment_success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

<!-- Scripts -->
<script>
    function toggleEditForm(noteId) {
const viewDiv = document.getElementById(`note-view-${noteId}`);
const editDiv = document.getElementById(`note-edit-${noteId}`);

if (viewDiv.style.display === 'none') {
    viewDiv.style.display = 'block';
    editDiv.style.display = 'none';
} else {
    viewDiv.style.display = 'none';
    editDiv.style.display = 'block';
}
}

function toggleCommentEdit(commentId) {
const viewDiv = document.getElementById(`comment-view-${commentId}`);
const editDiv = document.getElementById(`comment-edit-${commentId}`);

if (viewDiv.style.display === 'none') {
    viewDiv.style.display = 'block';
    editDiv.style.display = 'none';
} else {
    viewDiv.style.display = 'none';
    editDiv.style.display = 'block';
}
}

// Auto-expand textarea
document.querySelectorAll('textarea').forEach(textarea => {
textarea.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});
});

// Auto-hide toast notifications after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
const toasts = document.querySelectorAll('.toast');
toasts.forEach(toast => {
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
});
});

// Scroll comments to bottom on load
document.addEventListener('DOMContentLoaded', function() {
const commentsSection = document.querySelector('.comments-section');
if (commentsSection) {
    commentsSection.scrollTop = commentsSection.scrollHeight;
}
});

// Active tab persistence
document.addEventListener('DOMContentLoaded', function() {
const hash = window.location.hash;
if (hash) {
    const tab = document.querySelector(`[data-bs-target="${hash}"]`);
    if (tab) {
        new bootstrap.Tab(tab).show();
    }
}

// Store active tab in URL
const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', function(e) {
        window.location.hash = e.target.dataset.bsTarget;
    });
});
});
</script>
@endsection