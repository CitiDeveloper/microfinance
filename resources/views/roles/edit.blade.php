@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Role</h2>
    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="roleName">Role Name</label>
            <input type="text" name="name" class="form-control" id="roleName" value="{{ $role->name }}" required>
        </div>
        <button type="submit" class="btn btn-info">Update</button>
        <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
    </form>
</div>
@endsection
