@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">Note Details</h2>

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title mb-0">{{ $note->name }}</h5>
            <small class="text-muted">
                {{ $note->created_at->format('M d, Y h:i A') }}
            </small>
        </div>

        <div class="card-body">
            <p class="card-text">{{ $note->description }}</p>

            <!-- Display Remarks -->
            <h6 class="fw-bold mt-3">Remarks</h6>
            @if($note->remarks->count())
                <ul class="list-unstyled ms-3">
                    @foreach($note->remarks as $remark)
                        <li>
                            <strong>{{ $remark->user->name }}:</strong> {{ $remark->content }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-2">No remarks yet.</p>
            @endif

            <!-- Add Remark Form -->
            <form action="{{ route('remarks.store', $note->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label for="content-{{ $note->id }}" class="form-label">Add a Remark</label>
                    <input type="text" id="content-{{ $note->id }}" name="content" 
                           class="form-control" placeholder="Write your remark here" required>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Submit Remark</button>
            </form>
        </div>

        <div class="card-footer">
            <a href="{{ route('notes.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
</div>
@endsection
