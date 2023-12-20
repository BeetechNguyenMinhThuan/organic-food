<?php

namespace App\Helpers;

class IPHelper
{
    public static function getIp()
    {
        $args = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];
        foreach ($args as $key) {
            if (!key_exists($key, $_SERVER)) {
                continue;
            }

            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (strpos($ip, ':') !== false) {
                    $data = explode(":", $ip);
                    $ip = $data[0];
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }

        return "";
    }
}
