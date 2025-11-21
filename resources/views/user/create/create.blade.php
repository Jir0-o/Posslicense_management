@extends('layouts.master')
@section('content')
<h4 class="py-2 m-4"><span class="text-muted fw-light">Create User</span></h4>

<div class="row mt-5">
    <div class="col-12">
        <div class="card"> 
            <div class="card-header">
                <h5>Create User</h5>
            </div>
            <div class="card-body">
                <form action="{{route('user.store')}}" method="POST">
                    @csrf
                    <div class="mb-3 position-relative">
                        <label for="name">User name</label>
                        <div class="d-flex align-items-center">
                            <input id="name" name="name" type="text" required class="form-control" placeholder="User Name">
                        </div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="email">Email</label>
                        <div class="d-flex align-items-center">
                            <input id="email" name="email" type="text" required class="form-control" placeholder="User Email">
                        </div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password">Password</label>
                        <div class="d-flex align-items-center">
                            <input id="password" name="password" type="password" required class="form-control" placeholder="User Password">
                        </div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="d-flex align-items-center">
                            <input id="confirm_password" name="password_confirmation" type="password" required class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select id="role" name="role[]" class="form-control" multiple="multiple" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->name}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture">Profile Picture</label>
                        <input id="profile_picture" name="profile_picture" type="file" class="form-control" accept="image/*">
                    </div>
                    <a href="/settings" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#role').select2({
            placeholder: 'Select User Role',
            allowClear: true
        });
    });
</script>
@endsection
