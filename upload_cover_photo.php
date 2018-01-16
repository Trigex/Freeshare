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
require 'include/language/' . LANG . '/lang_upload_cover_photo.php';

User::is_logged_in();

$cover_photo_dir = VSHARE_DIR . '/photo/cover';
$allowed_mimes = array(
    'image/jpg',
    'image/jpeg',
);

if (! is_dir($cover_photo_dir)) {
    @mkdir($cover_photo_dir, 0755, true);
    @touch($cover_photo_dir . '/index.html');
}

if (is_uploaded_file($_FILES['cover_photo']['tmp_name'])) {
    if ($_FILES['cover_photo']['error'] == 0) {
        if (in_array($_FILES['cover_photo']['type'], $allowed_mimes)) {
            $filename = $_SESSION['UID'] . '.jpg';
            move_uploaded_file($_FILES['cover_photo']['tmp_name'], $cover_photo_dir . '/' . $filename);
            Ajax::returnJson($lang['upload_success'], 'success');
            exit();
        }
    }
}

Ajax::returnJson($lang['upload_failed'], 'error');
exit();
