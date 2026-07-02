@extends('layouts.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<h4 class="py-2 m2-4"><span class="text-muted fw-light">License Management</span></h4>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Licenses</h5>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    <button class="btn btn-outline-secondary btn-sm" id="refreshTableBtn" title="Refresh table">
                        <i class="bx bx-refresh"></i>
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLicenseModal">
                        <i class="bx bx-plus me-1"></i> Create License
                    </button>
                </div>
            </div>

            <div class="table-responsive text-nowrap p-3">
                <table id="licensesTable" class="table table-hover table-striped display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Max Devices</th>
                            <th>Lifetime</th>
                            <th>Expires At</th>
                            <th>Valid</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($licenses as $license)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-monospace">{{ $license->serial }}</td>
                            <td>{{ $license->name }}</td>
                            <td>{{ $license->max_devices ?? 1 }}</td>
                            <td>{{ $license->is_lifetime ? 'Yes' : 'No' }}</td>
                            <td>{{ $license->expires_at?->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s') ?? '-' }}</td>
                            <td>
                                @if($license->isValid())
                                    <span class="badge bg-success">Valid</span>
                                @else
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                            </td>
                            <td style="max-width:240px; white-space:normal;">
                                {{ \Illuminate\Support\Str::limit($license->notes ?? '-', 120) }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-secondary copy-serial"
                                            data-serial="{{ $license->serial }}"
                                            title="Copy serial">
                                        <i class="bx bx-copy"></i>
                                    </button>

                                    <a class="btn btn-sm btn-outline-info"
                                       href="{{ route('licenses.devices', $license->id) }}"
                                       title="Devices">
                                        Devices
                                    </a>

                                    <a class="btn btn-sm btn-outline-primary edit-license"
                                       href="#"
                                       data-id="{{ $license->id }}"
                                       data-serial="{{ $license->serial }}"
                                       data-name="{{ $license->name }}"
                                       data-max_devices="{{ $license->max_devices ?? 1 }}"
                                       data-is_lifetime="{{ $license->is_lifetime ? 1 : 0 }}"
                                       data-expires_at="{{ $license->expires_at?->format('Y-m-d\TH:i') ?? '' }}"
                                       data-notes="{{ $license->notes ?? '' }}"
                                       title="Edit">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>

                                    <form id="delete-{{ $license->id }}"
                                          action="{{ route('licenses.destroy', $license->id) }}"
                                          method="POST"
                                          class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger delete-btn"
                                                data-id="{{ $license->id }}">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(method_exists($licenses, 'links'))
                    <div class="p-3 d-flex justify-content-end">{{ $licenses->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createLicenseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form id="createLicenseForm" class="needs-validation" novalidate>
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create License</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label for="name">License Name</label>
                <input id="name" name="name" type="text" required class="form-control" placeholder="e.g. Pro-User-001">
                <div class="invalid-feedback">License name is required.</div>
            </div>

            <div class="mb-3">
                <label for="max_devices">Max Devices</label>
                <input id="max_devices" name="max_devices" type="number" min="1" value="1" required class="form-control">
                <div class="form-text">How many POS devices can use this license.</div>
            </div>

            <div class="mb-3">
                <label class="form-check">
                    <input id="is_lifetime" name="is_lifetime" type="checkbox" class="form-check-input">
                    <span class="form-check-label">Lifetime</span>
                </label>
            </div>

            <div class="mb-3" id="expiresAtBlock">
                <label for="expires_at">Expires At</label>
                <input id="expires_at" name="expires_at" type="datetime-local" class="form-control">
            </div>

            <div class="mb-3">
                <label for="notes">Notes (optional)</label>
                <textarea id="notes" name="notes" rows="2" class="form-control"></textarea>
            </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
          <button class="btn btn-primary" type="submit">Create</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editLicenseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form id="editLicenseForm" method="POST" class="needs-validation" novalidate>
      @csrf
      @method('PUT')
      <input type="hidden" id="edit_license_id" name="id">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit License</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label for="edit_name">License Name</label>
                <input id="edit_name" name="name" type="text" required class="form-control">
                <div class="invalid-feedback">License name is required.</div>
            </div>

            <div class="mb-3">
                <label for="edit_max_devices">Max Devices</label>
                <input id="edit_max_devices" name="max_devices" type="number" min="1" required class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-check">
                    <input id="edit_is_lifetime" name="is_lifetime" type="checkbox" class="form-check-input">
                    <span class="form-check-label">Lifetime</span>
                </label>
            </div>

            <div class="mb-3" id="editExpiresAtBlock">
                <label for="edit_expires_at">Expires At</label>
                <input id="edit_expires_at" name="expires_at" type="datetime-local" class="form-control">
            </div>

            <div class="mb-3">
                <label for="edit_notes">Notes (optional)</label>
                <textarea id="edit_notes" name="notes" rows="2" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Serial</label>
                <input id="edit_serial" type="text" class="form-control" readonly>
            </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
          <button id="saveLicenseBtn" class="btn btn-primary" type="button">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(function () {
    var table = $('#licensesTable').DataTable({
        responsive: true,
        lengthMenu: [10, 25, 50, 100],
        pageLength: 25,
        order: [[5, 'asc']],
        columnDefs: [
            { orderable: false, targets: [0, 7, 8] },
            { searchable: true, targets: [1,2,6,7] },
            { className: 'dt-center', targets: [0,3,4,6] },
            { width: '220px', targets: 7 }
        ],
        dom: '<"d-flex justify-content-between mb-2"<"dt-left"l><"dt-right"Bf>>rtip',
        buttons: [
            { extend: 'copyHtml5', text: '<i class="bx bx-copy"></i> Copy', className: 'btn btn-outline-secondary btn-sm' },
            { extend: 'csvHtml5', text: '<i class="bx bx-file"></i> CSV', className: 'btn btn-outline-secondary btn-sm' },
            { extend: 'excelHtml5', text: '<i class="bx bx-table"></i> Excel', className: 'btn btn-outline-secondary btn-sm' },
            { extend: 'pdfHtml5', text: '<i class="bx bx-file-pdf"></i> PDF', className: 'btn btn-outline-secondary btn-sm' },
            { extend: 'print', text: '<i class="bx bx-printer"></i> Print', className: 'btn btn-outline-secondary btn-sm' }
        ]
    });

    $('#refreshTableBtn').on('click', function () {
        location.reload();
    });

    $(document).on('click', '.copy-serial', function () {
        const serial = $(this).data('serial') || '';
        if (!serial) return;

        navigator.clipboard?.writeText(serial).then(function () {
            Swal.fire({ icon: 'success', title: 'Copied', text: serial, timer: 1200, showConfirmButton: false });
        }).catch(function () {
            Swal.fire('Copy failed', 'Select and press Ctrl+C to copy.', 'warning');
        });
    });

    $('#is_lifetime').on('change', function () {
        $('#expiresAtBlock').toggle(!this.checked);
    });

    $('#edit_is_lifetime').on('change', function () {
        $('#editExpiresAtBlock').toggle(!this.checked);
    });

    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })();

    $('#createLicenseForm').on('submit', function (e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return;
        }

        const fd = new FormData(this);
        fd.set('is_lifetime', $('#is_lifetime').is(':checked') ? 1 : 0);
        fd.set('max_devices', $('#max_devices').val() || 1);

        $.ajax({
            url: "{{ route('licenses.store') }}",
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            beforeSend() {
                $('.modal .btn-primary').prop('disabled', true);
            },
            success: function (res) {
                $('#createLicenseModal').modal('hide');
                Swal.fire('Created', res.license?.serial || 'License created', 'success')
                    .then(() => location.reload());
            },
            error: function (xhr) {
                let msg = 'Failed to create license';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire('Error', msg, 'error');
            },
            complete() {
                $('.modal .btn-primary').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.edit-license', function (e) {
        e.preventDefault();

        const btn = $(this);

        $('#edit_license_id').val(btn.data('id'));
        $('#edit_name').val(btn.data('name'));
        $('#edit_serial').val(btn.data('serial'));
        $('#edit_notes').val(btn.data('notes'));
        $('#edit_max_devices').val(btn.data('max_devices') || 1);

        const isLifetime = Number(btn.data('is_lifetime')) === 1;

        $('#edit_is_lifetime').prop('checked', isLifetime);
        $('#edit_expires_at').val(btn.data('expires_at'));
        $('#editExpiresAtBlock').toggle(!isLifetime);
        $('#editLicenseModal').modal('show');
    });

    $('#saveLicenseBtn').on('click', function () {
        const form = document.getElementById('editLicenseForm');

        if (!form.checkValidity()) {
            $(form).addClass('was-validated');
            return;
        }

        const id = $('#edit_license_id').val();
        const fd = new FormData();

        fd.append('_method', 'PUT');
        fd.append('name', $('#edit_name').val());
        fd.append('max_devices', $('#edit_max_devices').val() || 1);
        fd.append('is_lifetime', $('#edit_is_lifetime').is(':checked') ? 1 : 0);
        fd.append('expires_at', $('#edit_expires_at').val() || '');
        fd.append('notes', $('#edit_notes').val() || '');

        $.ajax({
            url: "{{ url('licenses') }}/" + id,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            beforeSend() {
                $('#saveLicenseBtn').prop('disabled', true);
            },
            success: function () {
                $('#editLicenseModal').modal('hide');
                Swal.fire('Saved', 'License updated', 'success')
                    .then(() => location.reload());
            },
            error: function (xhr) {
                let msg = 'Failed to update license';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire('Error', msg, 'error');
            },
            complete() {
                $('#saveLicenseBtn').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the license and its device records.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (!result.isConfirmed) return;

            const form = $('#delete-' + id);
            const url = form.attr('action');
            const token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: url,
                type: 'POST',
                data: {_method: 'DELETE', _token: token},
                success: function(res) {
                    if (res.ok) {
                        Swal.fire('Deleted', 'License removed.', 'success');
                        form.closest('tr').fadeOut(300, function() { $(this).remove(); });
                    } else {
                        Swal.fire('Error', res.message || 'Delete failed', 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Delete failed', 'error');
                    console.error(xhr.responseText);
                }
            });
        });
    });
});
</script>

<style>
    .dt-left { float: left; }
    .dt-right { float: right; }
    .dataTables_wrapper .dt-buttons .btn { margin-right: 6px; }
    .table td .btn { padding: 0.35rem 0.45rem; }
    .text-monospace { font-family: monospace; }
</style>
@endsection