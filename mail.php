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

User::is_logged_in();

$mail_folder = isset($_GET['folder']) ? $_GET['folder'] : 'inbox';

$mail_folder_types = array(
    'inbox',
    'outbox',
    'compose'
);

if (! in_array($mail_folder, $mail_folder_types)) {
    $mail_folder = 'inbox';
}

$mail_to = isset($_GET['receiver']) ? $_GET['receiver'] : '';
$mail_subject = isset($_GET['subject']) ? $_GET['subject'] : '';

$html_extra = '<script type="text/javascript" src="' . VSHARE_URL . '/js/mail.js"></script>';

if ($mail_folder != 'compose') {
    $html_extra .= '
    <script type="text/javascript">
    var mail = new Mail();
    mail.showbox("' . $mail_folder . '");
    </script>
    ';
} else {
    $html_extra .= '
    <script type="text/javascript">
    var mail = new Mail();
    mail.compose("' . $mail_to . '","' . $mail_subject . '");
    </script>
    ';
}

$smarty->assign('html_extra', $html_extra);
$smarty->display('header.tpl');
$smarty->display('mail.tpl');
$smarty->display('footer.tpl');
DB::close();
