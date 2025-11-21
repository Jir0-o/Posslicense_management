@extends('layouts.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <h4 class="py-2 m2-4"><span class="text-muted fw-light">Users,Roles & Permissions</span></h4>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <!-- Roles -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5>Roles</h5>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="float-end">

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                        <i class="bx bx-edit-alt me-1"></i> Create Role
                                    </a>
                                </button>

                                <!-- Modal -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap p-3">
                    <table id="datatable2" class="table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $role->name }}</td>
                                    <th class="py-4 px-6" style="width: 500px;">
                                        <div id="permission{{ $role->id }}" class="hidden flex gap-4 flex-wrap">
                                            @foreach ($role->permissions as $item)
                                                <div class="p-1 rounded font-bold">
                                                    {{ $item->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </th>
                                    <td><span class="badge bg-label-primary me-1">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i
                                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <form id="delete-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item" onclick="confirmDelete({{ $role->id}})">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>       

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Roles -->
        </div>
        <!-- Create User Modal -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createUserForm">
                            @csrf
                            <div class="mb-3">
                                <label for="name">User Name</label>
                                <input id="name" name="name" type="text" required class="form-control" placeholder="User Name">
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" required class="form-control" placeholder="User Email">
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" required class="form-control" placeholder="User Password">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input id="confirm_password" name="password_confirmation" type="password" required class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="mb-3">
                                <label for="user_role">Role</label>
                                <select id="user_role" name="role[]" class="form-control" multiple="multiple" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="profile_picture">Profile Picture</label>
                                <input id="profile_picture" name="profile_picture" type="file" class="form-control" accept="image/*">
                                <img id="profilePreview" src="" class="img-fluid mt-2" style="max-height: 150px;">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Edit user Model --}}
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="editUserId" name="userId">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">User Name</label>
                            <input type="text" id="edit_name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password (Optional)</label>
                            <input type="password" id="edit_password" name="password" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" id="edit_confirm_password" name="password_confirmation" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select id="edit_role" name="role[]" class="form-control" multiple required>
                                @foreach ($roles as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="mb-3">
                            <label for="edit_profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" id="edit_profile_picture" name="profile_picture" class="form-control" accept="image/*">
                            <img id="editprofilePreview" src="" alt="Profile Picture" class="img-fluid mt-2" style="max-height: 150px;">
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="saveUserBtn" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-12 col-md-6 col-lg-6">
            {{-- Permissions --}}
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5>Permissions</h5>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="float-end">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="">
                                <a href="{{ route('permission.create') }}" class="btn btn-primary">
                                    <i class="bx bx-edit-alt me-1"></i> Create Permission
                                </a>
                            </button>
                                <!-- Modal -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap p-3">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Permission Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $permission->name }}</td>
                                    <td><span class="badge bg-label-primary me-1">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('permission.edit', $permission->id) }}"><i
                                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <form id="delete-{{ $permission->id }}" action="{{ route('permission.destroy', $permission->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="dropdown-item" onclick="confirmDelete({{ $permission->id}})">
                                                                <i class="bx bx-trash me-1"></i> Delete
                                                            </button>
                                                        </form>                                                    
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Permissions -->
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 col-md-12 col-lg-12">
            {{-- Users --}}
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5>Users</h5>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="float-end">
                                <!-- Button trigger modal -->
                                <button type="button"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                    <i class="bx bx-edit-alt me-1"></i> Create User
                                </button>
                                <!-- Modal -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap p-3">
                    <table id="datatable1" class="table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @if ($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Picture" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="https://via.placeholder.com/50" alt="Default Profile" width="50" height="50" class="rounded-circle">
                                        @endif
                                    </td>
                                   
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            {{$role->name }}
                                        @endforeach
                                    </td>
                                    <td><span class="badge bg-label-primary me-1">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" 
                                                   href="#" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#editUserModal" 
                                                   data-id="{{ $user->id }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>              
                                                <form id="delete-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item" onclick="confirmDelete({{ $user->id}})">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                function confirmDelete(DeleteId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to delete this element? You will get back any deleted Data",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-${DeleteId}`).submit();
                        }
                    });
                } 
            </script> 
            <!--/ Permissions -->
        </div>
    </div>
<style>
    /* Limit z-index to modal-specific select2 */
    .select2-container {
    z-index: 9999 !important;
    }
</style>
<script>
        $(document).ready(function() {
        $('#createUserModal').on('shown.bs.modal', function() {
        $('#user_role').select2({
            placeholder: 'Select Role',
            allowClear: true,
            width: '100%'
            });
        });
        $('#editUserModal').on('shown.bs.modal', function() {
        $('#edit_role').select2({
            placeholder: 'Select Role',
            allowClear: true,
            width: '100%'
            });
        });
        // Handle form submission with AJAX
        $('#createUserForm').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('user.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#createUserModal').modal('hide');

                    // SweetAlert2 Success Message
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload(); // Reload the page or refresh the table
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    for (let field in errors) {
                        errorMessage += `${errors[field]}\n`; // Aggregate error messages
                    }

                    // SweetAlert2 Error Message
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage || 'Something went wrong.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                },
            });
        });


     // Trigger modal and fetch user data via AJAX
     $('#editUserModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); 
        const userId = button.data('id'); 

        // Clear previous values in the modal
        $('#editUserModal').find('input, select').val('');
        $('#editprofilePreview').attr('src', '/default-profile.png'); 

        $.ajax({
            url: "{{ route('user.edit', ':id') }}".replace(':id', userId),
            type: 'GET',
            success: function (response) {
                console.log(response);
                // Populate the modal with user data
                $('#editUserId').val(response.user.id);
                $('#edit_name').val(response.user.name);
                $('#edit_email').val(response.user.email);
                $('#edit_role').val(response.user.roles).trigger('change'); 
                $('#editprofilePreview').attr('src', response.user.profile_picture_url);
            },
            error: function (xhr) {
                alert('Failed to fetch user data. Please try again.');
                console.error(xhr.responseText);
            },
        });
    });

        // Preview profile picture before upload
        $('#edit_profile_picture').on('change', function (e) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#editprofilePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });

            // Preview profile picture before upload
            $('#profile_picture').on('change', function (e) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#profilePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });

        $('#saveUserBtn').on('click', function () {
        const userId = $('#editUserId').val();
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', $('#edit_name').val());
        formData.append('email', $('#edit_email').val());
        formData.append('password', $('#edit_password').val());
        formData.append('password_confirmation', $('#edit_confirm_password').val());

        // Ensure roles are appended as an array
        $('#edit_role').find(':selected').each(function () {
            formData.append('role[]', $(this).val());
        });

        if ($('#edit_profile_picture')[0].files[0]) {
            formData.append('profile_picture', $('#edit_profile_picture')[0].files[0]);
        }

        $.ajax({
            url: "{{ route('user.update', ':id') }}".replace(':id', userId),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('#editUserModal').modal('hide');
                Swal.fire({
                    title: 'Success!',
                    text: 'User updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                }).then(() => {
                    $('#editUserModal').modal('hide');
                    location.reload();
                });
            },
            error: function (xhr) {
                $('#editUserModal').modal('hide');
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update user. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                console.error(xhr.responseText);
            },
        });
    });


    });

</script>
@endsection
