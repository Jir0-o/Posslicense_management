@extends('layouts.master')
@section('content')
<h4 class="py-2 m-4"><span class="text-muted fw-light">Create New Role</span></h4>

<div class="row mt-5">
    <div class="col-12">
        {{-- Users --}}
        <div class="card">
            <div class="card-header">
                <h5>Create Role</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 position-relative">
                        <label for="roleName">Role Name</label>
                        <div class="d-flex align-items-center">
                            <input id="roleName" name="roleName" type="text" required class="form-control" value="" placeholder="Role Name">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="permissions">Permissions</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{Route('settings')}}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Create Role</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
