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
        $extraValues = [],
        $withoutTrace= false,
    ): bool {
        $infoEndpoint                 = GetGlobalSpecialValuesFromRequestService::execute([]);
        $infoEndpoint['message']      = $message;
        $infoEndpoint['extra_values'] = $extraValues;
        if($withoutTrace == false){
            $infoEndpoint['tracker']      = GetTrackerService::execute(getArray: true);
        }

        try {
            TrySendMailService::execute($to, $subject, $level, $infoEndpoint);
        }
        catch(Exception $exception) {
            LogConsoleFacade::full()->tracker()->log('error: ' . $exception->getMessage(), $infoEndpoint);
        }

        return false;
    }
}
