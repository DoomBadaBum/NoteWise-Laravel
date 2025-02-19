@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">All Notes</h2>

    <!-- Filter & "Add Note" Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <form action="{{ route('notes.index') }}" method="GET" class="row gx-2 gy-2 align-items-end">

                <!-- Text Search -->
                <div class="col-md-3">
                    <label for="search" class="form-label">Search (Name / Description)</label>
                    <input type="text"
                           name="search"
                           id="search"
                           class="form-control"
                           placeholder="e.g. Meeting"
                           value="{{ request('search') }}">
                </div>

                <!-- Start Date -->
                <div class="col-md-2">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date"
                           name="startDate"
                           id="startDate"
                           class="form-control"
                           value="{{ request('startDate') }}">
                </div>

                <!-- End Date -->
                <div class="col-md-2">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date"
                           name="endDate"
                           id="endDate"
                           class="form-control"
                           value="{{ request('endDate') }}">
                </div>

                <!-- Remarks Filter -->
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

                    <a href="{{ route('notes.create') }}"
                       class="btn btn-primary">
                       Add New Note
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Notes List -->
    @forelse($notes as $note)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">{{ $note->name }}</h5>
                <small class="text-muted">
                    {{ $note->created_at->format('M d, Y h:i A') }}
                </small>
            </div>

            <div class="card-body">
                <p class="card-text">{{ $note->description }}</p>

                <!-- Remarks Section -->
                <h6 class="fw-bold mt-3">Remarks</h6>
                @if($note->remarks->count())
                    <ul class="list-unstyled ms-3">
                        @foreach($note->remarks as $remark)
                            <li>
                                <strong>{{ $remark->user->name }}:</strong>
                                {{ $remark->content }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-2">No remarks yet.</p>
                @endif

                <!-- Add Remark Form -->
                <form action="{{ route('remarks.store', $note->id) }}"
                      method="POST"
                      class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="remark-{{ $note->id }}"
                               class="form-label">Add Remark</label>
                        <input type="text"
                               class="form-control"
                               name="content"
                               id="remark-{{ $note->id }}"
                               placeholder="Write your remark here"
                               required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Submit Remark
                    </button>
                </form>
            </div>

            <div class="card-footer d-flex justify-content-end">
                @if($note->user_id === auth()->id())
                    <a href="{{ route('notes.edit', $note->id) }}"
                       class="btn btn-warning me-2">
                       Edit
                    </a>
                    <form action="{{ route('notes.destroy', $note->id) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">No notes found.</p>
    @endforelse

    <!-- Example if you want pagination -->
    {{-- 
    <div class="mt-3">
        {{ $notes->links() }}
    </div>
    --}}
</div>
@endsection
