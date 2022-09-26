<?php

namespace Litermi\SimpleNotification\Services;

use Litermi\SimpleNotification\Notifications\SimpleEmailNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

/**
 *
 */
class TrySendMailService
{
    /**
     * @param null $to
     * @param null $subject
     * @param array $infoEndpoint
     * @return void
     */
    public static function execute($to = null, $subject = null, array $infoEndpoint = []): void
    {
        retry(
            5,
            static function () use ($to, $subject, $infoEndpoint) {
                $users = config('simple-notification.mail-recipient');

                if(empty($subject) === false){
                    $users = $subject;
                }
                $data               = [];
                $data[ 'ip' ]       = $infoEndpoint[ 'from' ] ?? null;
                $data[ 'endpoint' ] = $infoEndpoint;
                $data[ 'alert' ]    = '';

                Notification::route('mail', $users)
                    ->notify(new SimpleEmailNotification (['mail' ], $subject, $data));

            },
            100
        );
    }
}
