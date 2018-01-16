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

$html_title = 'VSHARE UPGRADE FINISHED';
require '../include/config.php';
require './tpl/header.php';
echo '<h1 class="page-header">Upgrade Finished</h1>';
echo '<p class="text-success"><strong>vShare upgraded to version ' . $config['version'] . '</strong></p>';
echo '<p class="text-danger lead"><span class="glyphicon glyphicon-warning-sign"></span> You must delete the "install" folder now.</p>';
require './tpl/footer.php';
