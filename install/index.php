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

$version = '3.2';

if (file_exists('../include/config.php') && filesize('../include/config.php') > 0) {
    $vshare_installed = 1;
    $html_title = 'VSHARE UPGRADE';
} else {
    $vshare_installed = 0;
    $html_title = 'VSHARE INSTALLATION';
}

require './tpl/header.php';

if ($vshare_installed == 1) {

    require '../include/config.php';
?>

<div class="page-header">
    <h1>vShare <?php echo $version; ?> Upgrade</h1>
</div>

<div class="row">
    <div class="col-md-12">
    <p class="text-success"><strong>vShare <?php echo $config['version']; ?> is already installed...</strong></p>

    <p>(If you want to re-install vShare delete "include/config.php")</p>

    <p class="text-danger lead"><span class="glyphicon glyphicon-warning-sign"></span> Before you continue with upgrade, you must take backup of your database and files.</p>
    <a href="./upgrade_start.php" class="col-md-4 btn btn-primary btn-lg">Upgrade Now</a>
    </div>
</div>

<?php

} else {

?>
<div class="page-header">
    <h1><strong>vShare <?php echo $version; ?></strong><span class="text-muted"> Installation</span></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <p class="lead">YouTube Clone Script allow you to run your own video sharing portal.
        Visitors will be able to upload video to your web site, view existing video, comment on video, share video with others.</p>
    </div>
    <div class="col-md-4">
        <br>
         <a href="./install.php" class="btn btn-primary btn-lg btn-block">install vShare</a>
        <br>
    </div>
</div>
<?php } ?>


<?php

require './tpl/footer.php';

