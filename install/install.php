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
require 'tpl/header.php';
require 'inc/folders.php';

$error = '';

echo '<div class="page-header"><h1>Installation Instruction</h1></div>';
echo '<ul class=list-group>';

while (list($k, $v) = each($writable_folders))
{
    if ($v == 'DIR')
    {
        echo '<li class=list-group-item>Make a directory name <span class="text-primary"><b>' . $k . '</b></span> in your server. <span class="badge">Chmod it to 777</span>';
    }
    else if ($v == 'FILE')
    {
        echo '<li class=list-group-item>Set the property of file <span class="text-primary"><b>' . $k . '</b></span> to writable, <span class="badge">Chmod it to 777</span>';
    }
}

echo '</ul>';

?>
<div class="row">
    <div class="col-md-8 clearfix">
        <form name="myform1" id="foler-input-form" method="POST"
        action="./install_check_folder_permission.php"
        onsubmit="return check_folder();"><input type="hidden" name="step"
        value="1" /><p> Enter Directory Location below:</p>
            <div class="form-group">
                <input type="text" class="form-control" name="folder" value="<?php echo str_replace('/install/install.php', '', $_SERVER['SCRIPT_FILENAME']); ?>" />
            </div>
            <div class="form-group">
             <input type="submit" name="submit" class="col-md-6 btn btn-primary btn-lg" value="Start Installation" />
            </div>
        </form>
    </div>
</div>
<?php

require 'tpl/footer.php';
