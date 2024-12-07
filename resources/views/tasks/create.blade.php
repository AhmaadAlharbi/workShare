@extends('layouts.main')

@section('content')
<div class="create-task-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <span class="page-icon">
                <i class="fas fa-plus-circle"></i>
            </span>
            <div class="header-text">
                <h1>Create New Task</h1>
                <p>Create a new task and assign it to departments</p>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="task-form-container">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <!-- Left Column - Main Info -->
                <div class="main-info">
                    <div class="input-wrapper">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            placeholder="Enter task title" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="assignedUser">Assign Task To:</label>
                        <select name="assigned_user_id" id="assignedUser" class="form-control">
                            <option value="" disabled selected>Select a user</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="input-wrapper">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="6"
                            placeholder="Provide detailed task description" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="input-wrapper">
                        <label for="status">Status</label>
                        <div class="status-select">
                            <select id="status" name="status" required>
                                <option value="pending" {{ old('status')=='pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="in-progress" {{ old('status')=='in-progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="completed" {{ old('status')=='completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Departments -->
                <div class="departments-section">
                    <h2>Share with Departments</h2>
                    <div class="departments-grid">
                        @foreach($departments as $department)
                        <label class="department-card" for="dept{{ $department->id }}">
                            <input type="checkbox" name="departments[]" value="{{ $department->id }}"
                                id="dept{{ $department->id }}" {{ (old('departments') && in_array($department->id,
                            old('departments'))) ? 'checked' : '' }}>
                            <span class="checkbox-custom"></span>
                            <span class="department-name">{{ $department->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    Create Tasks
                </button>
                <a href="{{ route('tasks.index') }}" class="btn-cancel">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .create-task-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .header-text h1 {
        font-size: 1.8rem;
        color: #1f2937;
        margin: 0;
    }

    .header-text p {
        color: #6b7280;
        margin: 0.5rem 0 0;
    }

    .task-form-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .input-wrapper {
        margin-bottom: 1.5rem;
    }

    .input-wrapper label {
        display: block;
        margin-bottom: 0.5rem;
        color: #374151;
        font-weight: 500;
    }

    .input-wrapper input,
    .input-wrapper textarea,
    .input-wrapper select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: #f9fafb;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .input-wrapper input:focus,
    .input-wrapper textarea:focus,
    .input-wrapper select:focus {
        border-color: #6366f1;
        background: white;
        outline: none;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .status-select {
        position: relative;
    }

    .status-select select {
        appearance: none;
        padding-right: 2.5rem;
    }

    .status-select i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        pointer-events: none;
    }

    .departments-section h2 {
        font-size: 1.2rem;
        color: #374151;
        margin-bottom: 1rem;
    }

    .departments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .department-card {
        position: relative;
        padding: 1rem;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .department-card:hover {
        border-color: #6366f1;
        background: white;
    }

    .department-card input[type="checkbox"] {
        position: absolute;
        opacity: 0;
    }

    .checkbox-custom {
        width: 20px;
        height: 20px;
        border: 2px solid #e5e7eb;
        border-radius: 4px;
        margin-right: 0.75rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .department-card input[type="checkbox"]:checked+.checkbox-custom {
        background: #6366f1;
        border-color: #6366f1;
    }

    .department-card input[type="checkbox"]:checked+.checkbox-custom::after {
        content: '\f00c';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.75rem;
    }

    .department-name {
        color: #374151;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn-submit,
    .btn-cancel {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: white;
        border: none;
        flex: 1;
        max-width: 200px;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
        border: none;
        flex: 1;
        max-width: 200px;
    }

    .btn-submit:hover,
    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .create-task-page {
            padding: 1rem;
        }

        .task-form-container {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-submit,
        .btn-cancel {
            max-width: none;
        }
    }
</style>
@endsection