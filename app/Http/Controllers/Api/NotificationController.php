<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getUserNotifications(Request $request)
    {
        $notifications = $request->user->notifications;
        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'notifications' => $notifications,

        ], 200);
    }


    public function getUnReadNotifications(Request $request)
    {
        $countNotifications = $request->user->unreadnotifications->count();
        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'countNotifications' => $countNotifications,

        ], 200);
    }




    public function markAllAsRead(Request $request)
    {
        $request->user->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'All notifications marked as read',
            'status_code' => 200,
        ], 200);
    }

    public function markAsRead($notificationId, Request $request)
    {
        $notification = $request->user->notifications->where('id', $notificationId)->first();

        if (!$notification) {
            return response()->json([
                'message' => 'Notification not found',
                'status_code' => 404,

            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',

        ], 200);
    }
}