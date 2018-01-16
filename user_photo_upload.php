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
require 'include/language/' . LANG . '/lang_user_photo_upload.php';

User::is_logged_in();

$userInfo = User::getById($_SESSION['UID']);

$allowedMimes = array(
    'image/jpeg',
    'image/pjpeg',
    'image/png',
);

if (isset($_FILES['photo']['tmp_name']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
    $fileType = $_FILES['photo']['type'];
    $fileTmpName = $_FILES['photo']['tmp_name'];
    if (in_array($fileType, $allowedMimes)) {
        $imageInfo = getimagesize($fileTmpName);
        if ($imageInfo[2] == 2 || $imageInfo[2] == 3) {
            User::upload_photo();
            $msg = $lang['photo_uploaded'];
        }
    } else {
        $err = str_replace('[FILE_TYPE]', $fileType, $lang['invalid_file']);
    }
}

$photoUrl = User::get_photo($userInfo['user_photo'], $userInfo['user_id']);

$smarty->assign('vshare_rand', $_SERVER['REQUEST_TIME']);
$smarty->assign('photo_url', $photoUrl);
$smarty->assign('uid', $_SESSION['UID']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('user_photo_upload.tpl');
$smarty->display('footer.tpl');
DB::close();
