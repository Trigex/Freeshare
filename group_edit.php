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
require 'include/language/' . LANG . '/lang_group_edit.php';

User::is_logged_in();

if (isset($_POST['submit'])) {

    $_POST['group_name'] = htmlspecialchars_uni($_POST['group_name']);
    $_POST['group_name'] = trim($_POST['group_name']);
    $_POST['group_keyword'] = strip_tags($_POST['group_keyword']);
    $_POST['group_keyword'] = trim($_POST['group_keyword']);
    $_POST['group_description'] = htmlspecialchars_uni($_POST['group_description']);
    $_POST['group_description'] = trim($_POST['group_description']);

    if ($_POST['group_name'] == '') {
        $err = $lang['group_name_empty'];
    } else if (strlen($_POST['group_name']) < 2) {
        $err = $lang['group_name_short'];
    } else if ($_POST['group_keyword'] == '') {
        $err = $lang['group_tags_empty'];
    } else if ($_POST['group_description'] == '') {
        $err = $lang['group_description_empty'];
    }

    $group_type_all = array(
        'public',
        'protected',
        'private'
    );

    if (! in_array($_POST['group_type'], $group_type_all)) {
        $_POST['group_type'] = 'public';
    }

    $group_options_all = array(
        'immediate',
        'owner_approve',
        'owner_only'
    );

    if (! in_array($_POST['group_upload'], $group_options_all)) {
        $_POST['group_upload'] = 'immediate';
    }

    if (! in_array($_POST['group_posting'], $group_options_all)) {
        $_POST['group_posting'] = 'immediate';
    }

    if (! in_array($_POST['group_image'], $group_options_all)) {
        $_POST['group_image'] = 'immediate';
    }

    $_POST['group_keyword'] = preg_replace('/[\,\s]+/', ' ', $_POST['group_keyword']);

    if ($err == '') {

        $sql = "UPDATE `groups` SET
               `group_name`= '" . DB::quote($_POST['group_name']) . "',
               `group_keyword`= '" . DB::quote($_POST['group_keyword']) . "',
               `group_description`= '" . DB::quote($_POST['group_description']) . "',
               `group_type`= '" . DB::quote($_POST['group_type']) . "',
               `group_upload`= '" . DB::quote($_POST['group_upload']) . "',
               `group_posting`= '" . DB::quote($_POST['group_posting']) . "',
               `group_image`= '" . DB::quote($_POST['group_image']) . "' WHERE
               `group_owner_id`='" . (int) $_SESSION['UID'] . "' AND
               `group_url`='" . DB::quote($_GET['group_url']) . "'";
        DB::query($sql);
    }

    if (! isset($_POST['group_channels']) || count($_POST['group_channels']) < 1 || count($_POST['group_channels']) > 3) {
        $err = $lang['group_channel_empty'];
    } else {
        $channels = implode('|', $_POST['group_channels']);
        $sql = "UPDATE `groups` SET
               `group_channels`='0|" . DB::quote($channels) . "|0' WHERE
               `group_owner_id`='" . (int) $_SESSION['UID'] . "' AND
               `group_url`='" . DB::quote($_GET['group_url']) . "'";
        DB::query($sql);
    }

    if ($err == '') {
        set_message($lang['group_updated'], 'success');
        $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
        Http::redirect($redirect_url);
    }
}

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($_GET['group_url']) . "' AND
       `group_owner_id`='" . (int) $_SESSION['UID'] . "'";
$group_info = DB::fetch1($sql);

if (! $group_info) {
    Http::redirect(VSHARE_URL . '/' . $_SESSION['USERNAME'] . '/groups/');
}

$myChannels = explode('|', $group_info['group_channels']);
$channelsAll = Channel::get();
$ch_checkbox = '';

for ($i = 0; $i < count($channelsAll); $i ++) {
    if (in_array($channelsAll[$i]['channel_id'], $myChannels)) {
        $checked = 'checked="checked"';
    } else {
        $checked = '';
    }
    $ch_checkbox .= '
    <div class="checkbox">
        <label>
            <input type="checkbox" name="group_channels[]" value="' . $channelsAll[$i]['channel_id'] . '" ' . $checked . '>' . $channelsAll[$i]['channel_name_html'] . '
        </label>
    </div>';
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('group_info', $group_info);
$smarty->assign('ch_checkbox', $ch_checkbox);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');
$smarty->display('group_edit.tpl');
$smarty->display('footer.tpl');
DB::close();
