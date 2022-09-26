<?php

namespace Litermi\SimpleNotification\Services;

use Litermi\Logs\Facades\LogConsoleFacade;
use Litermi\Logs\Services\GetTrackerService;
use Exception;

/**
 *
 */
class SendEmailNotificationService
{
    /**
     * @param bool $directNotification
     * @return false
     */
    public static function execute(
        $to = null,
        $subject = null,
        $message = "",
        $extraValues = []
    ): bool {
        $infoEndpoint = $extraValues;
        $infoEndpoint[ 'tracker' ] = GetTrackerService::execute();
        $infoEndpoint[ 'message' ] = $message;

        try {
            TrySendMailService::execute($to, $subject, $infoEndpoint);
        }
        catch(Exception $exception) {
            LogConsoleFacade::full()->tracker()->log('error: ' . $exception->getMessage(), $infoEndpoint);
        }

        return false;
    }
}
