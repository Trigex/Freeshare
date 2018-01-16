<?php

class Spam {

    public static function isIPBanned($ip)
    {
        $ip_arr = explode('.', $ip);
        $ip_search = $ip_arr[0] . '.' . $ip_arr[1] . '.';

        $sql = "SELECT * FROM `banned_ips` WHERE
               `ip` LIKE '" . $ip_search . "%'";
        $banned_ip_info = DB::fetch($sql);

        foreach ($banned_ip_info as $banned) {
            $banned_ip = $banned['ip'];
            if ($ip == $banned_ip) {
                return true;
            } else {
                $pos_search = strpos($banned_ip, '*');

                if ($pos_search !== false) {
                    $ip_part = substr($ip, 0, $pos_search);
                    $banned_ip_part = substr($banned_ip, 0, $pos_search);

                    if ($ip_part == $banned_ip_part) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function banIP($ip)
    {
        $sql = "INSERT INTO `banned_ips` SET
               `ip`='" . DB::quote($ip) . "'";
        DB::query($sql);
    }

    public static function checkProxy($ip)
    {
        $host = gethostbyaddr($ip);

        if ($host != $ip) {
           return true;
        }

        $proxy_headers = array(
            'HTTP_VIA',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED',
            'HTTP_CLIENT_IP',
            'HTTP_FORWARDED_FOR_IP',
            'VIA',
            'X_FORWARDED_FOR',
            'FORWARDED_FOR',
            'X_FORWARDED',
            'FORWARDED',
            'CLIENT_IP',
            'FORWARDED_FOR_IP',
            'HTTP_PROXY_CONNECTION'
        );

        foreach($proxy_headers as $x) {
            if (isset($_SERVER[$x])) {
                return true;
            }
        }

        if (@fsockopen($ip, 80, $errno, $errstr, 1)) {
            return true;
        }

        return false;
    }

    public static function foundOnSFS($ip, $username = '', $email = '')
    {
        $sfs_url = 'http://www.stopforumspam.com/api';
        $sfs_query = '?f=serial';
        $sfs_query .= '&ip=' . $ip;

        if (! empty($username)) {
            $sfs_query .= '&username=' . $username;
        }

        if (! empty($email)) {
            $sfs_query .= '&email=' . $email;
        }

        $sfs_result = file_get_contents("$sfs_url$sfs_query");
        $sfs_result = unserialize($sfs_result);
        $score = 0;

        if ($sfs_result['success'] == 1) {
            if (isset($sfs_result['username'])) {
                if ($sfs_result['username']['appears'] > 0) {
                    $score++;
                }
            }

            if (isset($sfs_result['email'])) {
                if ($sfs_result['email']['appears'] > 0) {
                    $score++;
                }
            }

            if (isset($sfs_result['ip'])) {
                if ($sfs_result['ip']['appears'] > 0) {
                    $score++;
                }
            }
        }

        return $score;
    }
}
