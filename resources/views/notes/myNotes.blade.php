@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">My Notes</h2>

    <!-- Row with "Create Note" button and "Search" form -->
    <div class="row mb-3">
        <div class="col-md-12">
            <form action="{{ route('notes.myNotes') }}" method="GET" class="row gx-2 gy-2 align-items-end">
                
                <!-- 1. Search Field -->
                <div class="col-md-3">
                    <label for="search" class="form-label">Search (Name / Description)</label>
                    <input type="text"
                           name="search"
                           id="search"
                           class="form-control"
                           placeholder="e.g. Meeting"
                           value="{{ request('search') }}">
                </div>

                <!-- 2. Start Date -->
                <div class="col-md-2">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date"
                           name="startDate"
                           id="startDate"
                           class="form-control"
                           value="{{ request('startDate') }}">
                </div>

                <!-- 3. End Date -->
                <div class="col-md-2">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date"
                           name="endDate"
                           id="endDate"
                           class="form-control"
                           value="{{ request('endDate') }}">
                </div>

                <!-- 4. Has Remarks? -->
                <div class="col-md-2">
                    <label for="hasRemarks" class="form-label">Has Remarks?</label>
                    <select name="hasRemarks" id="hasRemarks" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('hasRemarks') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('hasRemarks') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Filter & Add Note Buttons -->
                <div class="col-md-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-primary">
                        Filter
                    </button>
                    
                    <!-- "Create Note" link (optional) -->
                    <a href="{{ route('notes.create') }}" class="btn btn-primary">
                        Add New Note
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($notes->isEmpty())
        <p class="text-muted">You don’t have any notes yet.</p>
        <a href="{{ route('notes.create') }}" class="btn btn-primary">Create Note</a>
    @else
        @foreach($notes as $note)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">{{ $note->name }}</h5>
                    <small class="text-muted">
                        {{ $note->created_at->format('M d, Y h:i A') }}
                    </small>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $note->description }}</p>

                    <!-- Existing Remarks -->
                    @if($note->remarks->count())
                        <h6 class="fw-bold mt-3">Remarks</h6>
                        <ul class="list-unstyled ms-3">
                            @foreach($note->remarks as $remark)
                                <li>
                                    <strong>{{ $remark->user->name }}:</strong>
                                    {{ $remark->content }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mt-3">No remarks yet.</p>
                    @endif

                    <!-- Add Remark Form -->
                    <form action="{{ route('remarks.store', $note->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="remark-{{ $note->id }}" class="form-label">Add Remark</label>
                            <input type="text"
                                   class="form-control"
                                   name="content"
                                   id="remark-{{ $note->id }}"
                                   placeholder="Write your remark here"
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit Remark</button>
                    </form>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning me-2">Edit</a>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
