@extends('layouts.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h4 class="py-2 m2-4">
    <span class="text-muted fw-light">License Devices</span>
</h4>

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ $license->name }}</h5>
                    <small class="text-muted">Serial: {{ $license->serial }}</small>
                </div>

                <a href="{{ route('licenses.index') }}" class="btn btn-sm btn-outline-secondary">
                    Back
                </a>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <strong>Max Devices:</strong><br>
                        {{ $license->max_devices ?? 1 }}
                    </div>

                    <div class="col-md-3">
                        <strong>Approved Devices:</strong><br>
                        {{ $approvedCount ?? 0 }}
                    </div>

                    <div class="col-md-3">
                        <strong>Lifetime:</strong><br>
                        {{ $license->is_lifetime ? 'Yes' : 'No' }}
                    </div>

                    <div class="col-md-3">
                        <strong>Expires At:</strong><br>
                        {{ $license->expires_at?->format('Y-m-d H:i') ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Device Requests</h5>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Fingerprint</th>
                            <th>Processor</th>
                            <th>IP</th>
                            <th>Status</th>
                            <th>Requested</th>
                            <th>Approved</th>
                            <th width="240">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($devices as $device)
                            <tr>
                                <td>
                                    <strong>{{ $device->device_name ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        {{ $device->machine_user ?? '-' }}
                                        @if($device->os)
                                            / {{ $device->os }}
                                        @endif
                                        @if($device->app_version)
                                            / v{{ $device->app_version }}
                                        @endif
                                    </small>
                                </td>

                                <td style="max-width:280px; word-break:break-all;">
                                    {{ $device->device_fingerprint }}
                                </td>

                                <td style="max-width:220px; word-break:break-all;">
                                    {{ $device->processor_id ?? '-' }}
                                </td>

                                <td>{{ $device->ip_address ?? '-' }}</td>

                                <td>
                                    @if($device->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($device->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($device->status === 'blocked')
                                        <span class="badge bg-danger">Blocked</span>
                                    @elseif($device->status === 'rejected')
                                        <span class="badge bg-secondary">Rejected</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ ucfirst($device->status) }}</span>
                                    @endif
                                </td>

                                <td>{{ $device->requested_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                <td>{{ $device->approved_at?->format('Y-m-d H:i') ?? '-' }}</td>

                                <td>
                                    @if($device->status !== 'approved')
                                        <form method="POST"
                                              action="{{ route('license-devices.approve', $device->id) }}"
                                              class="d-inline action-form"
                                              data-message="Approve this device?">
                                            @csrf
                                            <button class="btn btn-sm btn-success" type="submit">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    @if($device->status !== 'rejected')
                                        <form method="POST"
                                              action="{{ route('license-devices.reject', $device->id) }}"
                                              class="d-inline action-form"
                                              data-message="Reject this device?">
                                            @csrf
                                            <button class="btn btn-sm btn-warning" type="submit">
                                                Reject
                                            </button>
                                        </form>
                                    @endif

                                    @if($device->status !== 'blocked')
                                        <form method="POST"
                                              action="{{ route('license-devices.block', $device->id) }}"
                                              class="d-inline action-form"
                                              data-message="Block this device? This device will not be able to login.">
                                            @csrf
                                            <button class="btn btn-sm btn-danger" type="submit">
                                                Block
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No device request found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end">
                    {{ $devices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.action-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: form.dataset.message || 'Confirm this action?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(function(result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection