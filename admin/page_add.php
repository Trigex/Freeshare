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

require 'admin_config.php';
require '../include/config.php';
require '../include/language/' . LANG . '/admin/page_add.php';

Admin::auth();

if (isset($_POST['submit'])) {
    $name_old = $_POST['page_name'];
    $name = trim($name_old);
    $name = strtolower($name);
    $name = preg_replace('/[^a-z0-9]/', "-", $name);

    if ($name_old != $name) {
        $err = $lang['invalid_page_name'];
        $err = str_replace('[NAME]', $name, $err);
        $err = str_replace('[NAME_OLD]', $name_old, $err);
    } else if (strlen($_POST['page_name']) < 3) {
        $err = $lang['name_too_short'];
    } else if (strlen($_POST['title']) < 6) {
        $err = $lang['title_too_short'];
    } else if (strlen($_POST['content']) < 20) {
        $err = $lang['content_too_short'];
    } else if (strlen($_POST['description']) < 6) {
        $err = $lang['description_too_short'];
    } else if (strlen($_POST['keywords']) < 6) {
        $err = $lang['keyword_too_short'];
    }

    if ($err == '') {
        $sql = "SELECT * FROM `pages` WHERE
               `page_name`='" . DB::quote($name) . "'";
        $page = DB::fetch1($sql);
        if ($page) {
            $err = $lang['duplicate_name'];
        }
    }

    if ($err == '') {
        $sql = "INSERT INTO `pages` SET
               `page_name`='" . DB::quote($name) . "',
               `page_title`='" . DB::quote($_POST['title']) . "',
               `page_keywords`='" . DB::quote($_POST['keywords']) . "',
               `page_description`='" . DB::quote($_POST['description']) . "',
               `page_content`='" . DB::quote($_POST['content']) . "',
               `page_counter`='1',
               `page_members_only`='" . DB::quote($_POST['members_only']) . "'";
        DB::query($sql);
        set_message($lang['page_created'], 'success');
        $redirect_url = VSHARE_URL . '/admin/page.php?name=' . $name;
        Http::redirect($redirect_url);
    }
    $smarty->assign('name', $name);
}

$smarty->assign('editor_wysiwyg_admin', Config::get('editor_wysiwyg_admin'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/page_add.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
