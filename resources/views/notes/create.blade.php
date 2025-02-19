@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Note</h2>

    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
