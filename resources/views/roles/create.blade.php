@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Role</h2>
    <form action="{{ route('roles.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label for="roleName">Role Name</label>
            <input type="text" name="name" class="form-control" id="roleName" placeholder="Enter Role Name" required>
        </div>
        <button type="submit" class="btn btn-info">Submit</button>
        <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
    </form>
</div>
@endsection
