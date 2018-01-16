<?php

require VSHARE_DIR . '/include/language/' . LANG . '/lang_class.validate.php';

class Validate
{

    static function date($month, $day, $year)
    {
        global $lang;

        if (($month < 1) || ($month > 12))
        {
            return $lang['invalid_month'];
        }

        $leapday = 0;
        $A = (($year % 4) == 0) ? 1 : 0;
        $B = (($year % 100) == 0) ? 1 : 0;
        $C = (($year % 400) == 0) ? 1 : 0;
        $R = ($A && (! ($B)) && (! ($C))) || ($A && $B && $C);
        $months_with_31_days = array(
            1, 3, 5, 7, 8, 10, 12
        );

        if (in_array($month, $months_with_31_days))
        {
            $month31 = 1;
        }
        else
        {
            $month31 = 0;
        }

        if (($R && (($month == 2) && (($day < 1) || ($day > 29)))) || (! $R && (($month == 2) && (($day < 1) || ($day > 28)))))
        {
            return $lang['invalid_day'];
        }
        else
        {
            if (($month31 && (($day < 1) || ($day > 31))) || (! $month31 && (($day < 1) || ($day > 30))))
            {
                return $lang['invalid_day'];
            }
        }

        $now = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
        $dob = mktime(0, 0, 0, $month, $day, $year);

        if ($dob > $now)
        {
            return $lang['invalid_date'];
        }

        return 1;
    }

    static function email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
