<?php

namespace Litermi\SimpleNotification\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static self email()
 * @method static self slack()
 * @method static self channelSlack(string $channel)
 * @method static self toEmail(string $email)
 * @method static void notification(string $message, array $extraValues = [])
 *
 */
class SimpleNotificationFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'simple-notification-service';
    }
}
