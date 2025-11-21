<?php

namespace App\Http\Controllers;

use App\Models\LoginInfo;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\DetailLogin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function store(Request $request)
    { 
        // Validate incoming data
        $data = $request->validate([
            'user_id' => 'required|integer',
            'app_name' => 'required|string',
            'duration' => 'required|integer',  // Duration in seconds
            'timestamp' => 'required|date'
        ]);

        // Create a new activity record in the database
        Activity::create($data);

        return response()->json(['message' => 'Activity data stored successfully'], 201);
    }

    public function updateLoginTime(Request $request)
    {
        $login = DetailLogin::where('id', $request->login_id)->first();
    
        // Format active time to HH:MM:SS based on `active_seconds` received
        $activeDuration = gmdate('H:i:s', $request->active_seconds);
        $activeSeconds = $request->active_seconds;
    
        if ($login) {
            // Update DetailLogin
            DetailLogin::where('id', $request->login_id)
                ->update(['login_hour' => $activeDuration, 'updated_at' => now()]);
    
            // Update LoginInfo if status is 0
            LoginInfo::where('user_id', $login->user_id)
                ->where('status', 0)
                ->where('login_date', $login->login_date)
                ->update([
                    'login_hour' => $activeDuration,
                    'updated_at' => now()
                ]);
    
            return response()->json(['login_hour' => $activeDuration,
                                    'active_seconds' => $activeSeconds
                                ]);
        }
    
        return response()->json(['error' => 'Login session not found'], 404);
    }

    public function getAllActiveSessions($id)
    {
        $activeSession = LoginInfo::where('status', 0)
            ->where('id', $id)
            ->first(['id', 'login_hour']);
    
        if ($activeSession) {
            return response()->json(['login_hour' => $activeSession->login_hour]);
        }
    
        return response()->json(['error' => 'Session not found'], 404);
    }

    public function updateLogoutTime(Request $request)
    {
        $loginId = Auth::user()->id;
        $todayDate = Carbon::today()->toDateString();
    
        $logoutReason = $request->input('logout_reason');
            // Update LoginInfo if status is 0
            LoginInfo::where('user_id', $loginId)
                ->where('status', 0)
                ->where('login_date', $todayDate)
                ->update([
                    'logout_reason' => $logoutReason,
                    'updated_at' => now()
                ]);
    
            return response()->json(['logout_reason' => $logoutReason]);
    }

    public function updateNeverLoginTime(Request $request)
    {
        $login = DetailLogin::where('user_id', auth()->id())->where('status', 0)->first();

        if ($login) {
            // Get current login_hour and calculate difference
            $previousLoginHour = Carbon::parse($login->login_time); 
            $currentTime = now();
            $timeDifferenceInSeconds = $previousLoginHour->diffInSeconds($currentTime); 

            $totalSeconds = $timeDifferenceInSeconds + $request->active_seconds;
            $newLoginHour = gmdate('H:i:s', $totalSeconds);

            // Update DetailLogin
            $login->update([
                'login_hour' => $newLoginHour,
                'updated_at' => $currentTime,
            ]);

            // Update LoginInfo
            LoginInfo::where('user_id', auth()->id())
                ->where('status', 0)
                ->whereDate('login_date', $login->login_date)
                ->update([
                    'login_hour' => $newLoginHour,
                    'updated_at' => $currentTime,
                ]);

            return response()->json([
                'login_hour' => $newLoginHour,
                'time_difference' => $timeDifferenceInSeconds,
                'active_seconds' => $totalSeconds,
            ]);
        }

        return response()->json(['error' => 'Login session not found'], 404);
    }

}
