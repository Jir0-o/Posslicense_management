@extends('layouts.master')
@section('content')

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@php
    // safe defaults if controller didn't pass these collections
    $exp7 = $expiringWithin7Days ?? collect();
    $exp3 = $expiringWithin3Days ?? collect();
    $exp24 = $expiringWithin24Hours ?? collect();
    $exp6 = $expiringWithin6Hours ?? collect();
    $exp1 = $expiringWithin1Hour ?? collect();
    $totalExpiring = $exp7->unique('id')->count();
@endphp

<!-- Dashboard Container -->
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="row g-3">

                {{-- Summary cards (kept compact and actionable) --}}
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-2">
                            <small class="text-muted">Expiring ≤ 7d</small>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">{{ $exp7->count() }}</h4>
                                <i class="bx bx-calendar-event fs-3"></i>
                            </div>
                            <small class="text-muted d-block">Includes all non-lifetime licenses</small>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-2">
                            <small class="text-muted">Expiring ≤ 3d</small>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">{{ $exp3->count() }}</h4>
                                <i class="bx bx-alarm fs-3"></i>
                            </div>
                            <small class="text-muted d-block">High priority</small>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-2">
                            <small class="text-muted">Expiring ≤ 24h</small>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">{{ $exp24->count() }}</h4>
                                <i class="bx bx-time fs-3"></i>
                            </div>
                            <small class="text-muted d-block">Action recommended</small>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-2">
                            <small class="text-muted">Expiring ≤ 6h / ≤ 1h</small>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-0">{{ $exp6->count() }} / {{ $exp1->count() }}</h6>
                                </div>
                                <i class="bx bx-bolt fs-3"></i>
                            </div>
                            <small class="text-muted d-block">Immediate attention</small>
                        </div>
                    </div>
                </div>

                {{-- Quick controls --}}
                <div class="col-12 mt-2">
                    <div class="d-flex gap-2 align-items-center">
                        <input id="licenseSearch" class="form-control form-control-sm w-50" placeholder="Search serial / name..." aria-label="Search licenses">
                        <button id="exportCsvBtn" class="btn btn-sm btn-outline-secondary">Export CSV</button>
                        <button id="refreshWidgetBtn" class="btn btn-sm btn-outline-primary">Refresh</button>
                    </div>
                </div>

            </div>
        </div>

        {{-- Overall summary on right --}}
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-1">Expiring licenses overview</h6>
                    <p class="small text-muted">This widget highlights licenses that will expire soon. Lifetime licenses are excluded.</p>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Total in watch</small>
                            <strong>{{ $totalExpiring }}</strong>
                        </div>

                        @php
                            // simple severity ratio for visualization
                            $sev = $exp1->count() + $exp6->count() * 0.8 + $exp24->count() * 0.6 + $exp3->count() * 0.4 + $exp7->count() * 0.2;
                            $sevPercent = min(100, (int) (($sev / max(1, $exp7->count())) * 100));
                        @endphp

                        <div class="progress mt-2" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $sevPercent }}%;" aria-valuenow="{{ $sevPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Severity: {{ $sevPercent }}%</small>

                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detailed table --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Licenses expiring soon</h5>
                    <small class="text-muted ms-3">Showing unique licenses from all watch buckets sorted by expiry</small>
                    <div class="ms-auto">
                        <a href="{{ route('licenses.index') }}" class="btn btn-sm btn-outline-primary">Manage licenses</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="expiringLicensesTable" class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Expires At ({{ config('app.timezone') }})</th>
                                <th>Remaining</th>
                                <th>Bucket</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $merged = collect();
                                $merged = $merged->merge($exp7)->merge($exp3)->merge($exp24)->merge($exp6)->merge($exp1);
                                $rows = $merged->unique('id')->sortBy('expires_at');
                            @endphp

                            @forelse($rows as $lic)
                                @php
                                    $expiresAt = $lic->expires_at;
                                    $remaining = $expiresAt ? $expiresAt->diffForHumans(now(), ['parts'=>3, 'short'=>true]) : '-';
                                    $diffSeconds = $expiresAt ? $expiresAt->diffInSeconds(now()) : null;

                                    if (!$expiresAt) $bucket = 'No expiry';
                                    elseif ($diffSeconds <= 3600) $bucket = '≤ 1 hour';
                                    elseif ($diffSeconds <= 6*3600) $bucket = '≤ 6 hours';
                                    elseif ($diffSeconds <= 24*3600) $bucket = '≤ 24 hours';
                                    elseif ($diffSeconds <= 3*24*3600) $bucket = '≤ 3 days';
                                    elseif ($diffSeconds <= 7*24*3600) $bucket = '≤ 7 days';
                                    else $bucket = '> 7 days';
                                @endphp

                                <tr data-serial="{{ $lic->serial }}" data-name="{{ Str::lower($lic->name) }}">
                                    <td class="text-monospace">
                                        <button class="btn btn-sm btn-link p-0 copy-btn" data-serial="{{ $lic->serial }}" title="Copy serial to clipboard">
                                            {{ $lic->serial }}
                                        </button>
                                        <small class="text-muted d-block">{{ $lic->id }}</small>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $lic->name }}</div>
                                        <div class="text-muted small">Created: {{ optional($lic->created_at)->toDateString() }}</div>
                                    </td>

                                    <td class="text-nowrap">
                                        {{ $expiresAt ? $expiresAt->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s') : '-' }}
                                    </td>

                                    <td>{{ $remaining }}</td>

                                    <td>
                                        @if(Str::startsWith($bucket, '≤ 1 hour'))
                                            <span class="badge bg-danger">{{ $bucket }}</span>
                                        @elseif(Str::contains($bucket, '6 hours'))
                                            <span class="badge bg-warning text-dark">{{ $bucket }}</span>
                                        @elseif(Str::contains($bucket, '24 hours'))
                                            <span class="badge bg-info">{{ $bucket }}</span>
                                        @elseif(Str::contains($bucket, '3 days'))
                                            <span class="badge bg-primary">{{ $bucket }}</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ $bucket }}</span>
                                        @endif
                                    </td>

                                    <td class="text-truncate" style="max-width:200px;">
                                        {{ Str::limit($lic->notes ?? '-', 120) }}
                                    </td>

                                    <td>
                                        @if($lic->isValid())
                                            <span class="badge bg-success">Valid</span>
                                        @else
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="btn-group" role="group" aria-label="actions">
                                            @if(Route::has('licenses.edit'))
                                                <a href="{{ route('licenses.edit', $lic->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                            @endif
                                            <a href="{{ url('/api/license/'.$lic->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">API</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No licenses expiring soon.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-muted small">
                    Tip: Click serial to copy. Use "Export CSV" to download the table.
                </div>
            </div>
        </div>
    </div>

    {{-- Calendar Section --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-3">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts: keep simple and dependency-free where possible --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // FullCalendar init (safe guard if library not loaded)
    var calendarEl = document.getElementById('calendar');
    if (calendarEl && typeof FullCalendar !== 'undefined') {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: { left: 'today prev,next', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
            selectable: true,
            displayEventEnd: true
        });
        calendar.render();
    }

    // Copy serial to clipboard
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const text = this.dataset.serial;
            navigator.clipboard?.writeText(text).then(() => {
                this.innerText = 'Copied';
                setTimeout(() => this.innerText = text, 1200);
            }).catch(() => {
                alert('Copy failed. Select and Ctrl+C to copy.');
            });
        });
    });

    // Simple client-side filter for table
    const searchInput = document.getElementById('licenseSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            document.querySelectorAll('#expiringLicensesTable tbody tr').forEach(row => {
                const serial = (row.dataset.serial || '').toLowerCase();
                const name = (row.dataset.name || '').toLowerCase();
                row.style.display = (serial.includes(q) || name.includes(q)) ? '' : 'none';
            });
        });
    }

    // Export visible rows to CSV
    document.getElementById('exportCsvBtn').addEventListener('click', function () {
        const rows = Array.from(document.querySelectorAll('#expiringLicensesTable tbody tr'))
            .filter(r => r.style.display !== 'none' && r.querySelector('td'));
        if (!rows.length) { alert('No rows to export'); return; }

        const csv = [];
        csv.push(['Serial','Name','Expires At','Remaining','Bucket','Notes','Status'].join(','));
        rows.forEach(r => {
            const cols = r.querySelectorAll('td');
            const rowData = Array.from(cols).slice(0,7).map(td => {
                // sanitize commas/newlines
                return '"' + td.innerText.replace(/"/g, '""').replace(/\n/g, ' ') + '"';
            });
            csv.push(rowData.join(','));
        });

        const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'expiring_licenses_' + (new Date()).toISOString().slice(0,10) + '.csv';
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
    });

    // Refresh widget (simple reload of page fragment would be ideal; here we reload page)
    document.getElementById('refreshWidgetBtn').addEventListener('click', function () {
        location.reload();
    });

    // OPTIONAL: periodic auto-refresh every 5 minutes (unobtrusive)
    // setInterval(() => { /* location.reload(); */ }, 5 * 60 * 1000);

});
</script>
@endpush

@endsection
