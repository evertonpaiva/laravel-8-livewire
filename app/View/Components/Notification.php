<?php

namespace App\View\Components;

class Notification
{
    public static $notificationTypes = [
        'success' => [
            'color' => 'green',
            'icon' => 'fa-check-circle',
        ],
        'error' => [
            'color' => 'red',
            'icon' => 'fa-exclamation-circle',
        ],
        'warning' => [
            'color' => 'yellow',
            'icon' => 'fa-exclamation-triangle',
        ],
        'info' => [
            'color' => 'blue',
            'icon' => 'fa-info-circle',
        ],
    ];

    public static function getColorByType($type)
    {
        return Notification::$notificationTypes[$type]['color'];
    }

    public static function getIconByType($type)
    {
        return Notification::$notificationTypes[$type]['icon'];
    }

    public static function retrieveNotification($type)
    {
        $notification = new \stdClass();
        $notification->type = $type;
        $notification->color = Notification::getColorByType($notification->type);
        $notification->icon = Notification::getIconByType($notification->type);
        $notification->message = session()->get($notification->type);
        return $notification;
    }
}
