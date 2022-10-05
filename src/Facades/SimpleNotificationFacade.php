<?php

namespace Litermi\SimpleNotification\Facades;

use Illuminate\Support\Facades\Facade;
use Litermi\SimpleNotification\Services\SendSimpleNotificationService;

/**
 * @method static SendSimpleNotificationService email()
 * @method static SendSimpleNotificationService slack()
 * @method static SendSimpleNotificationService channelSlack(string $channel)
 * @method static SendSimpleNotificationService toEmail(array $email)
 * @method static SendSimpleNotificationService level(int $level)
 * @method static void notification(string $subject, string $message, array $extraValues = [])
 *
 */
class SimpleNotificationFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'simple-notification-service';
    }
}
