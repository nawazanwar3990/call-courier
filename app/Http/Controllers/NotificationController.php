<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationListRequest;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(NotificationListRequest $request)
    {
        if ($request->ajax()) {
            return $request->processRequest();
        }
        $params = [
            'pageTitle' => __('general.notifications'),
            'breadCrumbs' => [
                __('general.dashboard') => route('admin.dashboard'),
                __('general.notifications') => '',
            ],
        ];
        return view('admin.notifications.index', $params);
    }

    public function userNotifications()
    {
        $user = Auth::user();
        $notifications = Notification::where('notifiable_id',$user->id)->whereNull('read_at')->latest()->get();
        $pageTitle = __('general.notifications');
        return view('website.notifications', [
            'pageTitle' => $pageTitle,
            'notifications' => $notifications
        ]);
    }

    public function read(Request $request): JsonResponse
    {

        $notification_type = $request->input('notification_type');
        $notification_id = $request->input('notification_id');
        $notification_position = $request->input('notification_position');
        $user_id = $request->input('user_id');
        if ($notification_type === 'all') {
            Notification::where('notifiable_id', $user_id)->update(['read_at' => now(),]);
            $data = ['success' => true, 'msg' => 'Notification read successfully', 'notification_position' => $notification_position];
        } else {
            Notification::where('id', $notification_id)->update(['read_at' => now(),]);
            $data = ['success' => true, 'msg' => 'Notification read successfully', 'notification_position' => $notification_position];
        }
        return response()->json($data);
    }
}
