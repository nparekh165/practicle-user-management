@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create User</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @include('users.form')
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection