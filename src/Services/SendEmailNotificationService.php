<?php

namespace Litermi\SimpleNotification\Services;

use Litermi\Logs\Facades\LogConsoleFacade;
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
        $level = null,
        $message = "",
        $extraValues = []
    ): bool {
        $infoEndpoint                 = GetGlobalSpecialValuesFromRequestService::execute([]);
        $infoEndpoint['message']      = $message;
        $infoEndpoint['extra_values'] = $extraValues;
        $infoEndpoint['tracker']      = GetTrackerService::execute();

        try {
            TrySendMailService::execute($to, $subject, $level, $infoEndpoint);
        }
        catch(Exception $exception) {
            LogConsoleFacade::full()->tracker()->log('error: ' . $exception->getMessage(), $infoEndpoint);
        }

        return false;
    }
}
