@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary  text-center">
                    <h3 class="text-white">Edit User: {{ $user->name }}</h3>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="pt-3">
                        @csrf
                        @method('patch')

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                            <label for="name">Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}">
                            <label for="username">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                            <label for="email">Email Address</label>
                        </div>

                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            <label for="phone">Phone</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-control" id="role" name="role">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="vendor" {{ old('role', $user->role) == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            <label for="role">Role</label>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="active" value="active" {{ old('status', $user->status) == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive" {{ old('status', $user->status) == 'inactive' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                        

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                            @if($user->image)
                            <div class="mt-2">
                                <img src="{{Storage::url($user->image) }}" alt="User Image" class="img-thumbnail" width="150">
                            </div>
                            @else
                                <div class="mt-2">
                                    <p>No image available for this user.</p>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
