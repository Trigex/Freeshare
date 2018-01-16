<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: 3.2
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'include/language/' . LANG . '/lang_search.php';

$_GET['search'] = isset($_GET['search']) ? $_GET['search'] : '';

$search_string = htmlspecialchars_uni($_GET['search']);
$search_string = str_replace('=', ' ', $search_string);
$search_string = str_replace('(', ' ', $search_string);
$search_string = str_replace(')', ' ', $search_string);
$search_string = trim($search_string);

$search_type = $_GET['type'];

$search_type_arr = array(
    'video',
    'user',
    'group'
);

if (! in_array($search_type, $search_type_arr))
{
    $search_type = 'video';
}

if ($search_string == '')
{
    $err = $lang['search_empty'];
}

if (get_magic_quotes_gpc())
{
    $search_string = stripslashes($search_string);
}

if ($err == '')
{
    if ($search_type == 'user')
    {
        $sql = "SELECT `user_id` FROM `users` WHERE
               `user_name`='" . DB::quote($search_string) . "'";
        $user = DB::fetch1($sql);

        if ($user)
        {
            $redirect_url = VSHARE_URL . '/' . $search_string;
            Http::redirect($redirect_url);
        }
        else
        {
            $err = $lang['user_not_found'];
        }
    }
    else if ($search_type == 'group')
    {
        $redirect_url = VSHARE_URL . '/search_group.php?search=' . $search_string;
        Http::redirect($redirect_url);
    }
    else
    {
        $search_string = str_replace('/', ' ', $search_string);
        $search_string = preg_replace('!\s+!', '-', $search_string); ## change space chars to dashes.
        $redirect_url = VSHARE_URL . '/search/' . $search_string . '/';
        Http::redirect($redirect_url);
    }
}

DB::close();
set_message($err, 'error');
$redirect_url = VSHARE_URL . '/';
Http::redirect($redirect_url);
