<?php

date_default_timezone_set('GMT');

function dd($debug_message)
{
    echo '<pre>';
    print_r($debug_message);
    exit;
}

function write_log($txt, $logfile = 1, $echo = 0, $extension = 'txt')
{
    global $config;

    if ($logfile == 1) {
        $log_file = '../templates_c/debug.txt';
    } else {
        $log_file = '../templates_c/' . $logfile . '.' . $extension;
    }

    $now = date("Y-m-d G:i:s");

    error_log("$now $txt\n\r", 3, $log_file);

    if ($echo == 1) {
        echo $txt;
    }

}
