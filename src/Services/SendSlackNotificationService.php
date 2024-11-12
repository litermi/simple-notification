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
        $infoEndpoint = GetGlobalSpecialValuesFromRequestService::execute([]);
        $channelSlack = $channelSlack ?? config( 'simple-notification.default-channel-slack' );
        $infoEndpoint[ 'tracker' ] = GetTrackerService::execute();
        $infoEndpoint[ 'message' ] = $message;
        try {
            $infoEndpoint['extra_values'] = json_encode($extraValues);
        }catch (Exception $exception){
            $infoEndpoint['extra_values'] = "error json code";
        }

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
