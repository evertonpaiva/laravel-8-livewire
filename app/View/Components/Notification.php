<?php

namespace App\View\Components;

class Notification
{
    public static $notificationTypes = [
        'success' => [
            'color' => 'green',
            'icon' => 'fa-check-circle',
            'duration' => '5',
        ],
        'error' => [
            'color' => 'red',
            'icon' => 'fa-exclamation-circle',
            'duration' => '60',
        ],
        'warning' => [
            'color' => 'yellow',
            'icon' => 'fa-exclamation-triangle',
            'duration' => '5',
        ],
        'info' => [
            'color' => 'blue',
            'icon' => 'fa-info-circle',
            'duration' => '5',
        ],
    ];

    /**
     * Recuperar a cor por tipo
     * @param $type tipo de notificação
     * @return string cor da notificação
     */
    public static function getColorByType($type)
    {
        return Notification::$notificationTypes[$type]['color'];
    }

    /**
     * Recuperar ícone por tipo
     * @param $type tipo de notificação
     * @return string cor da notificação
     */
    public static function getIconByType($type)
    {
        return Notification::$notificationTypes[$type]['icon'];
    }

    /**
     * Recuperar a duração da mensagem na tela
     * @param $type tipo de notificação
     * @return string cor da notificação
     */
    public static function getDurationByType($type)
    {
        return Notification::$notificationTypes[$type]['duration'];
    }

    /**
     * Monta uma classe com as informação da notificação através de seu tipo
     * @param $type tipo de notificação
     * @return \stdClass Classe para guardar os dados da notificação
     */
    public static function retrieveNotification($type)
    {
        $notification = new \stdClass();
        $notification->type = $type;
        $notification->color = Notification::getColorByType($notification->type);
        $notification->icon = Notification::getIconByType($notification->type);
        $notification->duration = Notification::getDurationByType($notification->type);
        $notification->message = session()->get($notification->type);
        return $notification;
    }
}
