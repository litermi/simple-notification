<?php

namespace Litermi\SimpleNotification\Services;

/**
 *
 */
class GetIconByLevelNotificationService
{

    /**
     * code: 1=log, 2=warning, 3=error
     *
     * @param $code
     * @return string
     */
    public static function execute($code = 0)
    {
        if($code === 1){
           return '💥';
        }

        if($code === 2){
            return '🚩';
        }

        return '📗';
    }

}
