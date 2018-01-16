<?php

require '../include/config.php';

$_COOKIE['video_queue'];

$cookie_arr = explode(',', $_COOKIE['video_queue']);

for ($i = 0;$i < count($cookie_arr);$i++)
{
    if ($_GET['id'] == $cookie_arr[$i])
    {
        unset($cookie_arr[$i]);
    }
}

$cookie = implode(',', $cookie_arr);
setcookie('video_queue', $cookie, time() + 86400,'/');
