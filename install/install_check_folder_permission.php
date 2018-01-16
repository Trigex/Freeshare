<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 3.2
 *   LICENSE: http://buyscripts.in/vshare-license
 *   WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 *   This program is a commercial software and any kind of using it must agree
 *   to vShare license.
 *
 ******************************************************************************/

$html_title = 'VSHARE INSTALLATION';
require 'tpl/header.php';
require 'inc/folders.php';

if (strlen($_POST['folder']) < 2)
{
    echo '<br><div class="alert alert-warning"><strong>You must enter Directory Location </strong></div>';
    exit();
}

?>

<div class="page-header">
    <h1>Checking Default Directories</h1>
</div>

<?php

$error = 0;

echo '<ul id="check-default-folders" class=list-group>';

while (list($k, $v) = each($writable_folders))
{
    $dir = $_POST['folder'] . '/' . $k;

    $class = '';

    if (! is_writable($dir))
    {
        $status = '<span class="pull-right text-danger"><span class="glyphicon glyphicon-remove"></span><strong> Error
        </strong></span><!--  $dir  -->';
        $class = " class=\"error\"";
        $error = 1;
    }
    else
    {
        $status = '<span class="pull-right text-success"><span class="glyphicon glyphicon-ok"></span><strong> Success</strong></span>';
    }

    echo '<li class=list-group-item>Set permission for ' . $v . ' <span class="text-primary"><b>' . $k . '</b></span> to 777  ' . $status . '</li>';
}

echo '</ul>';

if ($error == 1)
{
    echo "<div class=row><div class=col-md-12><form method='POST' action=''>
    <div class=form-group>
        <input type='submit' class='col-md-4 btn btn-primary btn-lg' name='submit' value='check Again'>
        <input type='hidden' name='folder' value='{$_POST['folder']}'></div>
        </form></div></div>";
}
else
{
    echo "<div class=row><div class=col-md-12><form method='POST' action='./install_collect_info.php'>
        <div class=form-group><input type='submit' class='col-md-4 btn btn-primary btn-lg' name='submit' value='Continue Installation'>
        <input type='hidden' name='folder' value='{$_POST['folder']}'></div>
        </form></div></div>";
}

require './tpl/footer.php';
