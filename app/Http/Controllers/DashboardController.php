<?php

namespace App\Http\Controllers;

use App\Models\DetailLogin;
use App\Models\LoginInfo;
use App\Models\Notice;
use App\Models\Notification;
use App\Models\Task;
use App\Models\TitleName;
use App\Models\User;
use App\Models\WorkPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\License;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $now = Carbon::now();
        $in7 = $now->copy()->addDays(7);
        $in3 = $now->copy()->addDays(3);
        $in1 = $now->copy()->addDays(1);
        $in24h = $now->copy()->addHours(24);
        $in6h = $now->copy()->addHours(6);
        $in1h = $now->copy()->addHour();

        // Only non-lifetime licenses with an expires_at
        $baseQuery = License::where('is_lifetime', false)
            ->whereNotNull('expires_at')
            ->where('expires_at', '>=', $now); 

        // 7 days bucket (<= 7 days)
        $expiringWithin7Days = (clone $baseQuery)
            ->where('expires_at', '<=', $in7)
            ->orderBy('expires_at', 'asc')
            ->get();

        // 3 days bucket (<= 3 days)
        $expiringWithin3Days = (clone $baseQuery)
            ->where('expires_at', '<=', $in3)
            ->orderBy('expires_at', 'asc')
            ->get();

        // 1 day bucket (<= 1 day)
        $expiringWithin1Day = (clone $baseQuery)
            ->where('expires_at', '<=', $in1)
            ->orderBy('expires_at', 'asc')
            ->get();

        // hours: within 24h but greater than 1 day bucket (optional breakdown)
        $expiringWithin24Hours = (clone $baseQuery)
            ->where('expires_at', '<=', $in24h)
            ->orderBy('expires_at', 'asc')
            ->get();

        // Fine-grained short-hour buckets (<=1h, <=6h)
        $expiringWithin1Hour = (clone $baseQuery)
            ->where('expires_at', '<=', $in1h)
            ->orderBy('expires_at', 'asc')
            ->get();

        $expiringWithin6Hours = (clone $baseQuery)
            ->where('expires_at', '<=', $in6h)
            ->where('expires_at', '>', $in1h)
            ->orderBy('expires_at', 'asc')
            ->get();

        // Pass to view
        return view('dashboard', [
            // existing dashboard data...
            'expiringWithin7Days' => $expiringWithin7Days,
            'expiringWithin3Days' => $expiringWithin3Days,
            'expiringWithin1Day'  => $expiringWithin1Day,
            'expiringWithin24Hours'=> $expiringWithin24Hours,
            'expiringWithin6Hours' => $expiringWithin6Hours,
            'expiringWithin1Hour'  => $expiringWithin1Hour,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
