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
require '../include/language/' . LANG . '/admin/group_edit.php';

Admin::auth();

if (isset($_POST['submit'])) {
    $_POST['keyword'] = preg_replace('/[\,\s]+/', ' ', $_POST['keyword']);

    $sql = "UPDATE `groups` SET
           `group_name`='" . DB::quote($_POST['group_name']) . "',
           `group_keyword`='" . DB::quote($_POST['keyword']) . "',
           `group_description`='" . DB::quote($_POST['gdescn']) . "',
           `group_url`='" . DB::quote($_POST['gurl']) . "',
           `group_type`='" . DB::quote($_POST['type']) . "',
           `group_featured`='" . DB::quote($_POST['featured']) . "',
           `group_upload`='" . DB::quote($_POST['gupload']) . "',
           `group_posting`='" . DB::quote($_POST['gposting']) . "',
           `group_image`='" . DB::quote($_POST['gimage']) . "' WHERE
           `group_id`='" . (int) $_GET['gid'] . "'";
    DB::query($sql);

    if (! isset($_POST['channel']) || count($_POST['channel']) < 1) {
        $err = $lang['group_channel_null'];
    } else {
        $sql = "UPDATE `groups` SET
               `group_channels`='0|" . implode('|', $_POST['channel']) . "|0' WHERE
               `group_id`='" . (int) $_GET['gid'] . "'";
        DB::query($sql);
    }

    if ($err == '') {
        set_message($lang['group_edited'], 'success');
        $redirect_url = VSHARE_URL . '/admin/group_view.php?group_id=' . $_GET['gid'];
        Http::redirect($redirect_url);
    }
}

$sql = "SELECT * FROM `groups` WHERE
       `group_id`='" . (int) $_GET['gid'] . "'";
$group_info = DB::fetch1($sql);

$type_public = $type_private = $type_protected = '';

if ($group_info['group_type'] == 'public') {
    $type_public = "selected=\"selected\"";
} else if ($group_info['group_type'] == 'private') {
    $type_private = "selected=\"selected\"";
} else if ($group_info['group_type'] == 'protected') {
    $type_protected = "selected=\"selected\"";
}

$type_box = "
<option value='public' $type_public>Public</option>
<option value='private' $type_private>Private</option>
<option value='protected' $type_protected>Protected</option>";

$smarty->assign('type_box', $type_box);

$gupload_immediate = $gupload_owner_approve = $gupload_owner_only = '';

if ($group_info['group_upload'] == 'immediate') {
    $gupload_immediate = "selected=\"selected\"";
} else if ($group_info['group_upload'] == 'owner_approve') {
    $gupload_owner_approve = "selected=\"selected\"";
} else if ($group_info['group_upload'] == 'owner_only') {
    $gupload_owner_only = "selected=\"selected\"";
}

$upload_box = "
<option value='immediate' $gupload_immediate>immediate</option>
<option value='owner_approve' $gupload_owner_approve>owner_approve</option>
<option value='owner_only' $gupload_owner_only>owner_only</option>";

$smarty->assign('upload_box', $upload_box);

$gposting_immediate = $gposting_owner_approve = $gposting_owner_only = '';

if ($group_info['group_posting'] == 'immediate') {
    $gposting_immediate = "selected=\"selected\"";
} else if ($group_info['group_posting'] == 'owner_approve') {
    $gposting_owner_approve = "selected=\"selected\"";
} else if ($group_info['group_posting'] == 'owner_only') {
    $gposting_owner_only = "selected=\"selected\"";
}

$posting_box = "
<option value='immediate' $gposting_immediate>immediate</option>
<option value='owner_approve' $gposting_owner_approve>owner_approve</option>
<option value='owner_only' $gposting_owner_only>owner_only</option>";

$smarty->assign('posting_box', $posting_box);

$gimage_immediate = $gimage_owner_only = '';

if ($group_info['group_image'] == 'immediate') {
    $gimage_immediate = "selected=\"selected\"";
} else if ($group_info['group_image'] == 'owner_only') {
    $gimage_owner_only = "selected=\"selected\"";
}

$icon_box = "
<option value='immediate' $gimage_immediate>immediate</option>
<option value='owner_only' $gimage_owner_only>owner_only</option>";

$smarty->assign('icon_box', $icon_box);

$featured_yes = $featured_no = '';

if ($group_info['group_featured'] == 'yes') {
    $featured_yes = "selected=\"selected\"";
} else {
    $featured_no = "selected=\"selected\"";
}

$featured_box = "
<option value='yes' $featured_yes>Yes</option>
<option value='no' $featured_no>No</option>";

$smarty->assign('featured_box', $featured_box);

$ch_checkbox = '';
$mych = explode('|', $group_info['group_channels']);
$ch = Channel::get();

for ($i = 0; $i < count($ch); $i ++) {
    if (in_array($ch[$i]['channel_id'], $mych)) {
        $checked = "checked=\"checked\"";
    } else {
        $checked = '';
    }
    $ch_checkbox .= '<div class="checkbox">' .
                    '<label for="channel-' . $ch[$i]['channel_id'] . '">' .
                    '<input type="checkbox" name="channel[]" value="' . $ch[$i]['channel_id'] . '"' . $checked . 'id="channel-' . $ch[$i]['channel_id'] . '">' .
                    htmlspecialchars($ch[$i]['channel_name'], ENT_QUOTES, 'UTF-8') .
                    '</label></div>';
}

$smarty->assign('ch_checkbox', $ch_checkbox);
$smarty->assign('group', $group_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
