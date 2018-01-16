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

$html_title = 'VSHARE INSTALLATION';
require '../include/config.php';
require './tpl/header.php';

$buyscript_pass = $_POST['buyscript_pass'];

echo <<<EOT

<p class="text-success lead"><strong>vShare Youtube Clone installation completed successfully.</strong></p>


<p>You can login to vShare admin area at:</p>

<p><a href='$config[baseurl]/admin/' target="_blank">$config[baseurl]/admin/</a><br>
Username : <strong>admin</strong><br />
Password : <strong>buyscripts</strong>
</p>

<p class="text-warning"><strong>You must change default admin password by logging into admin control panel.</strong></p>

<p>Test User Account</p>

<p><a href='$config[baseurl]/login.php' target="_blank">$config[baseurl]/login.php</a><br>

Username : <strong>vshare</strong><br />
Password : <strong>$buyscript_pass</strong>
</p>


<p class="text-danger"><strong>You must delete the "install" folder now. Also chmod 755 include/config.php</strong></p>

EOT;

require './tpl/footer.php';
