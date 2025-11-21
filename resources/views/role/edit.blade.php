@extends('layouts.master')
@section('content')
<h4 class="py-2 m-4"><span class="text-muted fw-light">Edit Role</span></h4>

<div class="row mt-5">
    <div class="col-12">
        {{-- Users --}}
        <div class="card">
            <div class="card-header">
                <h5>Edit Role</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 position-relative">
                        <label for="roleName">Role Name</label>
                        <div class="d-flex align-items-center">
                            <input id="roleName" name="roleName" type="text" required class="form-control" value="{{ $role->name }}" placeholder="Role Name">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="permissions">Permissions</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="permissions[]" 
                                            value="{{ $permission->id }}" 
                                            id="permission-{{ $permission->id }}" 
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{Route('settings')}}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update Role</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
