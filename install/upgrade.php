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

$html_title = 'VSHARE UPGRADE';
require './tpl/header.php';
?>

<p class="text-danger lead"><span class="glyphicon glyphicon-warning-sign"></span> Before you continue with upgrade, you must
take backup of your database and files.</p>

<form action="upgrade_start.php" method="post">
<input type="submit" name="submit" class="btn btn-primary btn-lg" value="Continue with upgrade" />
</form>

<?php

require './tpl/footer.php';
