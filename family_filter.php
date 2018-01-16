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

if ($config['family_filter'] == 0) {
    DB::close();
    Http::redirect(VSHARE_URL);
}

if (! isset($_SESSION['REDIRECT']) || empty($_SESSION['REDIRECT'])) {
    if (! preg_match('/family_filter/i', $_SERVER['HTTP_REFERER'])) {
        if (preg_match("/" . preg_quote(VSHARE_URL, '/') . "/i", $_SERVER['HTTP_REFERER'])) {
            $_SESSION['REDIRECT'] = $_SERVER['HTTP_REFERER'];
        } else {
        	$_SESSION['REDIRECT'] = VSHARE_URL;
        }
    } else {
    	$_SESSION['REDIRECT'] = VSHARE_URL;
    }
}

if ($_SESSION['FAMILY_FILTER'] == 0) {
    $_SESSION['FAMILY_FILTER'] = 1;
    if (isset($_SESSION['UID'])) {
        $sql = "UPDATE `users` SET `user_adult`='1' WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        DB::query($sql);
    }
    $redirect_url = $_SESSION['REDIRECT'];
    unset($_SESSION['REDIRECT']);
    DB::close();
    Http::redirect($redirect_url);
} else {

    if (isset($_POST['submit'])) {
        $_SESSION['FAMILY_FILTER'] = 0;

        if (isset($_SESSION['UID'])) {
            $sql = "UPDATE `users` SET `user_adult`='0' WHERE
                   `user_id`='" . (int) $_SESSION['UID'] . "'";
            DB::query($sql);
        }

        $redirect_url = $_SESSION['REDIRECT'];
        unset($_SESSION['REDIRECT']);

        DB::close();
        Http::redirect($redirect_url);
    }
}

$smarty->assign('age_minimum', Config::get('signup_age_min'));
$smarty->display('header.tpl');
$smarty->display('family_filter.tpl');
$smarty->display('footer.tpl');
DB::close();
