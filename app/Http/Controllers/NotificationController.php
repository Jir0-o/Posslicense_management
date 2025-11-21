<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Cache\Lock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    //

    public function notificationCount()
    {
        try {
            $user = Auth::user();
            $count = Notification::where('to_user_id', $user->id)->where('is_read', 0)->count();
    
            return response()->json([
                'status' => true,
                'message' => 'Notification count retrieved successfully',
                'data' => [
                    'count' => $count
                ]
            ], 201); 
    
        } catch (\Exception $e) {
            Log::error('Error retrieving notification count: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve notification count',
                'error' => $e->getMessage()
            ], 500); 
        }
    }
    

    public function getNotifications()
    {
        try {
        $user = Auth::user();
        $notifications = Notification::where('to_user_id', $user->id)->with('user')->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Notifications retrieved successfully',
            'data' => [
                'notifications' => $notifications
            ]
        ], 201);

    } catch (\Exception $e) {
        Log::error('Error creating project: '.$e->getMessage());

        // Return a JSON error response
        return response()->json([
            'status' => false,
            'message' => 'Failed to retrieve notifications',
            'error' => $e->getMessage()
        ], 500); 
        }
    }

    public function markAsRead($id)
{
    try {
        $notification = Notification::findOrFail($id);
        $notification->is_read = 1;
        $notification->save();

        return response()->json(['status' => true, 'message' => 'Notification marked as read']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Failed to mark notification as read'], 500);
    }
}
public function markAllAsRead()
{
    try {
        $user = Auth::user();

        // Update all notifications to mark them as read
        Notification::where('to_user_id', $user->id)->update(['is_read' => 1]);

        return response()->json(['status' => true, 'message' => 'All notifications marked as read']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Failed to mark notifications as read'], 500);
    }
}

public function clearNotifications()
{
    try {
        $user = Auth::user();

        // Update all notifications to mark them as read
        Notification::where('to_user_id', $user->id)->delete();

        return response()->json(['status' => true, 'message' => 'All notifications marked as read']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Failed to mark notifications as read'], 500);
    }
}

public function deleteNotification($id)
{
    try {
        $user = Auth::user();
        $notification = Notification::where('id', $id)->where('to_user_id', $user->id)->firstOrFail(); // Ensure the notification belongs to the logged-in user
        $notification->delete();

        return response()->json(['status' => true, 'message' => 'Notification deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Failed to delete notification', 'error' => $e->getMessage()], 500);
    }
}

}
