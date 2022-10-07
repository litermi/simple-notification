<?php

namespace Litermi\SimpleNotification\Services;

use Litermi\Logs\Facades\LogConsoleFacade;
use Litermi\SimpleNotification\Notifications\SimpleSlackNotification;
use Litermi\Logs\Services\SendLogConsoleService;
use Exception;
use Illuminate\Support\Facades\Notification;

/**
 *
 */
class SendSlackNotificationService
{
    /**
     * @param null $channelSlack
     * @return bool|null
     */
    public static function execute(
        $channelSlack = null,
        $subject = null,
        $level = null,
        $message = "",
        $extraValues = [],
    ):
    ?bool {
        $infoEndpoint = $extraValues;
        $channelSlack = $channelSlack ?? config( 'simple-notification.default-channel-slack' );
        $infoEndpoint[ 'tracker' ] = GetTrackerService::execute();
        $infoEndpoint[ 'message' ] = $message;
        try {
            Notification::route('slack', $channelSlack)
                ->notify(new SimpleSlackNotification($subject, $level, $infoEndpoint));
        }
        catch(Exception $exception) {
            LogConsoleFacade::full()->tracker()->log('error: ' . $exception->getMessage(), $infoEndpoint);
        }

        return false;
    }
}
