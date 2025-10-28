<?php

namespace App\Services;
use App\Enums\RoleEnum;
use App\Models\Notification;
class NotificationService
{

    public static function getUnReadNotifications($user)
    {
        if (UserService::hasRoleByUser($user,RoleEnum::ROLE_SUPER_ADMIN)){
            $notifications =  Notification::whereNull('read_at');
        }else{
            $notifications =  Notification::whereReceiverId($user->id)->whereNull('read_at');
        }
        return $notifications->orderBy('created_at', 'DESC')->limit(10)->get()->toJson();
    }

    public static function listByPagination($user, $limit = 20)
    {
        return Notification::whereReceiverId($user->id)
            ->whereNull('read_at')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
    }
    public static function findByField($field, $value)
    {
        return Notification::where($field, $value)->first();
    }
}
