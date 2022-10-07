<?php

namespace Litermi\SimpleNotification\Services;

/**
 *
 */
class GetIconByLevelNotificationService
{

    /**
     * code: 0=log, 1=warning, 2=error
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
