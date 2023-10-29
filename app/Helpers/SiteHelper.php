<?php

namespace App\Helpers;



class SiteHelper
{
    public static function getOperator($site, $sequence_id)
    {
        return (($site << 24) & 0xFF000000) | ($sequence_id & 0x00FFFFFF);
    }

    public static function getSiteInfo($operator)
    {
        return (($operator >> 24) & 0xFF);
    }

    public static function getUserId($operator)
    {
        return $operator & 0x00FFFFFF;
    }
}
