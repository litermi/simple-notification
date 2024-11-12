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
        $withoutTrace = false,
    ):
    ?bool {
        $infoEndpoint = GetGlobalSpecialValuesFromRequestService::execute([]);
        $channelSlack = $channelSlack ?? config( 'simple-notification.default-channel-slack' );

        if($withoutTrace == false) {
            $infoEndpoint['tracker'] = GetTrackerService::execute(getArray: true);
            $infoEndpoint['tracker'] = self::printArrayRecursive($infoEndpoint['tracker']);
        }
        $infoEndpoint[ 'message' ] = $message;
        try {
            $infoEndpoint['extra_values'] = self::printArrayRecursive($extraValues);
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

    public static function  printArrayRecursive($data, $indent = 0) {
        $stringToReturn = "";
        if(is_array($data) == false){
            return $data;
        }

        foreach ($data as $key => $value) {
            // Indent the output for readability
            $indentStr = "".str_repeat('  ', $indent);

            // If the value is an array, recurse
            if (is_array($value)) {
                $textKey = "$indentStr$key:";
                if(is_int($key)==true){
                    $textKey="";
                }
                if($indent==0){
                    $stringToReturn.="\n\n\n";
                }
                if($indent==1){
                    $stringToReturn.="\n";
                }

                if($indent==0) {
                    $stringToReturn .= "$textKey";
                }else{
                    $stringToReturn .= "$textKey";
                }
                $stringToReturn .= self::printArrayRecursive($value, $indent + 1);
            } else {
                // Otherwise, print the key-value pair
                $stringToReturn .= "$indentStr$key: $value \n";
            }
        }

        return $stringToReturn ;
    }
}
