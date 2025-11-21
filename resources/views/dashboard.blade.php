@extends('layouts.master')
@section('content')
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<!-- Dashboard Container -->
<div class="container-fluid">
    <!-- Top Section: Summary Cards and Notice Board -->
    <div class="row mb-4">
        <!-- Summary Cards -->
        <div class="col-lg-7">
            <div class="row">
                @if (Auth::user()->hasRole('Super Admin'))
                <!-- Total Login Users -->
                <div class="col-6 mb-3">
                    <a href="{{ route('login_details.index') }}" style="text-decoration: none;">
                        <div class="card" style="height: 120px;">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="card-body">
                                    <h6 class="d-block text-500 font-medium mb-2">TODAY LOGIN USERS</h6>
                                    <div class="text-900 fs-5" id="total_login_users">1</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded"
                                    style="width: 2.5rem; height: 2.5rem; margin-top: 10px; margin-right: 5px">
                                    <i class='bx bxs-user-check'></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Not Logged In Users -->
                <div class="col-6 mb-3">
                    <a href="{{ route('login_details.index') }}" style="text-decoration: none;">
                        <div class="card" style="height: 120px;">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="card-body">
                                    <h6 class="d-block text-500 font-medium mb-2">TODAY NOT LOGGED IN</h6>
                                    <div class="text-900 fs-5" id="not_logged_in_users">2</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded"
                                    style="width: 2.5rem; height: 2.5rem; margin-top: 10px; margin-right: 5px">
                                    <i class='bx bxs-user-x'></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endif

                <!-- Total Running Projects -->
                <div class="col-6 mb-3">
                    <a @if (Auth::user()->hasRole('Super Admin')) href="#" @else href="#" @endif style="text-decoration: none;">
                        <div class="card" style="height: 120px;">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="card-body">
                                    <h6 class="d-block text-500 font-medium mb-2">@if (Auth::user()->hasRole('Super Admin')) TOTAL RUNNING PROJECTS @else ASSIGNED PROJECTS @endif</h6>
                                    <div class="text-900 fs-5" id="total_running_projects">@if (Auth::user()->hasRole('Super Admin'))1 @else 2 @endif</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded"
                                    style="width: 2.5rem; height: 2.5rem; margin-top: 10px; margin-right: 5px">
                                    <i class='bx bxs-folder-open'></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Running Tasks -->
                <div class="col-6 mb-3">
                    <a @if (Auth::user()->hasRole('Super Admin')) href="#" @else href="#" @endif style="text-decoration: none;">
                        <div class="card" style="height: 120px;">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="card-body">
                                    <h6 class="d-block text-500 font-medium mb-2">@if (Auth::user()->hasRole('Super Admin'))RUNNING TASKS @else PENDING TASKS @endif</h6>
                                    <div class="text-900 fs-5" id="running_tasks">@if (Auth::user()->hasRole('Super Admin'))1 @else 2 @endif</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded"
                                    style="width: 2.5rem; height: 2.5rem; margin-top: 10px; margin-right: 5px">
                                    <i class='bx bx-task'></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Running Workplans -->
                <div class="col-6 mb-3">
                    <a @if (Auth::user()->hasRole('Super Admin')) href="#" @else href="#" @endif style="text-decoration: none;">
                        <div class="card" style="height: 120px;">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="card-body">
                                    <h6 class="d-block text-500 font-medium mb-2">@if (Auth::user()->hasRole('Super Admin'))RUNNING WORKPLANS @else PENDING WORKPLANS @endif</h6>
                                    <div class="text-900 fs-5" id="running_workplans">@if (Auth::user()->hasRole('Super Admin'))1 @else 2 @endif</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded"
                                    style="width: 2.5rem; height: 2.5rem; margin-top: 10px; margin-right: 5px">
                                    <i class='bx bx-calendar-event'></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card p-3">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>


<script>
    calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['timeline', 'dayGrid', 'timeGrid', 'interaction'],
        editable: true,
        header: {
            left: 'today prev,next',
            center: 'title',
            right: 'timelineDay,timeGridWeek,dayGridMonth'
        },
        defaultView: 'dayGridMonth',
        displayEventEnd: true,
        selectable: true,
    });
    calendar.render();

</script>
@endsection
