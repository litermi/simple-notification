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
    public static function execute($to = null, $subject = null, $level = null, array $infoEndpoint = []): void
    {
        retry(
            5,
            static function () use ($to, $subject, $level, $infoEndpoint) {
                $users = config('simple-notification.mail-recipient');

                if(empty($to) === false){
                    $users = $to;
                }

                if(is_string($users)){
                    $users = explode(",", $users);
                }

                $data               = [];
                $data[ 'ip' ]       = $infoEndpoint[ 'from' ] ?? null;
                $data[ 'endpoint' ] = $infoEndpoint;
                $data[ 'alert' ]    = '';

                $data['endpoint'] = self::printArrayRecursive($data['endpoint']);

                Notification::route('mail', $users)
                    ->notify(new SimpleEmailNotification (['mail'], $subject, $level, $data));

            },
            100
        );
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
                    $stringToReturn.="<br><br><br>";
                }
                if($indent==1){
                    $stringToReturn.="<br>";
                }

                if($indent==0) {
                    $stringToReturn .= "<b>$textKey</b>";
                }else{
                    $stringToReturn .= "$textKey";
                }
                $stringToReturn .= self::printArrayRecursive($value, $indent + 1);
            } else {
                // Otherwise, print the key-value pair
                $stringToReturn .= "$indentStr$key: $value <br>";
            }
        }

        return $stringToReturn ;
    }
}
