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

Admin::auth();

$sql = "DELETE FROM `import_auto` WHERE
        `import_auto_id`='" . (int) $_GET['id'] . "'";
DB::query($sql);

$msg = 'Auto import keywords deleted.';
set_message($msg, 'success');

$redirect_url = VSHARE_URL . '/admin/import_auto.php';
Http::redirect($redirect_url);
