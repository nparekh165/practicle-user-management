@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User List</h2>

    <form method="GET" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name" class="form-control w-25 d-inline">
        <button class="btn btn-primary">Search</button>
        <a href="{{ route('users.create') }}" class="btn btn-success float-end">+ Add User</a>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ \Carbon\Carbon::parse($user->dob)->format('d-m-Y') }}</td>
                <td>{{ $user->gender }}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>

    @if ($users->hasPages())
        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    @endif

</div>
@endsection