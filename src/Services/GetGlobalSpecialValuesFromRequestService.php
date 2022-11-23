<?php

namespace Litermi\SimpleNotification\Services;

use Illuminate\Support\Str;

/**
 *
 */
class GetGlobalSpecialValuesFromRequestService
{

    /**
     * @return mixed
     */
    public static function execute( $values )
    {
        $request = request();
        foreach (config('logs.get_global_special_values_from_request') as $key => $item) {
            if ($request->$item) {
                $values[ $key ] = $request->$item;
            }
        }
        return $values;
    }
}
