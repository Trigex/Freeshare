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
session_start();

$html_title = 'VSHARE INSTALLATION';

$error = '';

if (isset($_POST['connect_info']))
{

    $site_url = $_POST['site_url'];

    if (strlen($site_url) < 12) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span> <strong>Site url invalid</strong>.</li>';
    }

    $ffmpeg_path = $_POST['ffmpeg_path'];

    if (! file_exists($ffmpeg_path)) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span> <strong>ffmpeg not found</strong> ' . $ffmpeg_path . '</li>';
    }

    $mplayer_path = $_POST['mplayer_path'];

    if (! file_exists($mplayer_path)) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span> <strong>mplayer not found</strong>  ' . $mplayer_path . '</li>';
    }

    $mencoder_path = $_POST['mencoder_path'];

    if (! file_exists($mencoder_path)) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span> mencoder not found ' . $mencoder_path . '</li>';
    }

    $flvtool_path = $_POST['flvtool_path'];

    if (! file_exists($flvtool_path)) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span> <strong>flvtool2 not found</strong> ' . $flvtool_path . '</li>';
    }

    $qtfaststart_path = $_POST['qtfaststart_path'];

    if (! file_exists($qtfaststart_path)) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span> <strong>Qt-faststart not found</strong> ' . $qtfaststart_path . '</li>';
    }

    $db_server = $_POST['db_server'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $folder = $_POST['folder'];

    if (! is_dir($folder)) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span> <strong>folder not found</strong> ' . $folder . '</li>';
    }

    $link = @mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if (! $link) {
        $error .= '<li><span class="glyphicon glyphicon-remove"></span><strong> Failed to connect to database server</strong>.</li>';
    } else {
        $_SESSION['VSHARE_INSTALL']['DB_NAME'] = $db_name;
        $_SESSION['VSHARE_INSTALL']['DB_USER'] = $db_user;
        $_SESSION['VSHARE_INSTALL']['DB_PASSWORD'] = $db_pass;
        $_SESSION['VSHARE_INSTALL']['DB_HOST'] = $db_server;
    }

    if ($error == '')
    {
        $fp = fopen('../include/config.php', 'w');
        fputs($fp, '<?php');

        $vshare_config = <<<EOT

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();

\$db_host     = '$db_server';
\$db_name     = '$db_name';
\$db_user     = '$db_user';
\$db_pass     = '$db_pass';

\$language = 'en';

\$config = array();
\$config['ffmpeg']          =  '$_POST[ffmpeg_path]';
\$config['mplayer']          =  '$_POST[mplayer_path]';
\$config['mencoder']          =  '$_POST[mencoder_path]';
\$config['flvtool']          =  '$_POST[flvtool_path]';
\$config['qt-faststart']   =  '$_POST[qtfaststart_path]';
\$config['basedir']        =  '$_POST[folder]';
\$config['baseurl']        =  '$_POST[site_url]';
\$config['theme']          =  'default';

include(\$config['basedir'] . '/include/vshare.php');


EOT;

        fputs($fp, $vshare_config);
        fclose($fp);

        require './tpl/header.php';

        ?>

<div class="row">
    <div class="col-md-12">

        <div class="alert alert-success">
            <strong>Configuration file created</strong>
            (include/config.php)
        </div>

        <form method="post" action="install_create_tables.php"><input
        type="submit" class="col-md-4 btn btn-primary btn-lg" name=submit value="Continue Installation">
        <input type="hidden" name="db_host" value="<?php
        echo $db_server;
        ?>"> <input
        type="hidden" name="db_name" value="<?php
        echo $db_name;
        ?>"> <input
        type="hidden" name="db_user" value="<?php
        echo $db_user;
        ?>"> <input
        type="hidden" name="db_pass" value="<?php
        echo $db_pass;
        ?>"> <input
        type="hidden" name="action" value="create_tables">
        </form>
    </div>
</div>
<?php

        require 'tpl/footer.php';
        exit(0);
    }
}
else
{

    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $site_url = str_replace('/install/install_collect_info.php', '', $url);

    $ffmpeg_path = '';

    if (file_exists('/usr/bin/ffmpeg'))
    {
        $ffmpeg_path = '/usr/bin/ffmpeg';
    }
    else if (file_exists('/usr/local/bin/ffmpeg'))
    {
        $ffmpeg_path = '/usr/local/bin/ffmpeg';
    }

    $mplayer_path = '';

    if (file_exists('/usr/bin/mplayer'))
    {
        $mplayer_path = '/usr/bin/mplayer';
    }
    else if (file_exists('/usr/local/bin/mplayer'))
    {
        $mplayer_path = '/usr/local/bin/mplayer';
    }

    $mencoder_path = '';

    if (file_exists('/usr/bin/mencoder'))
    {
        $mencoder_path = '/usr/bin/mencoder';
    }
    else if (file_exists('/usr/local/bin/mencoder'))
    {
        $mencoder_path = '/usr/local/bin/mencoder';
    }

    $flvtool_path = '';

    if (file_exists('/usr/bin/flvtool2'))
    {
        $flvtool_path = '/usr/bin/flvtool2';
    }
    else if (file_exists('/usr/local/bin/flvtool2'))
    {
        $flvtool_path = '/usr/local/bin/flvtool2';
    }

    $qtfaststart_path = '';

    if (file_exists('/usr/bin/qt-faststart'))
    {
        $qtfaststart_path = '/usr/bin/qt-faststart';
    }
    else if (file_exists('/usr/local/bin/qt-faststart'))
    {
        $qtfaststart_path = '/usr/local/bin/qt-faststart';
    }

    $db_name = $db_user = $db_pass = '';
    $db_server = 'localhost';
}
require 'tpl/header.php';

if ($error != '')
{
    echo '<div class="text-danger"><ul class=list-unstyled>' . $error . '</ul></div>';
}

?>
<div class="page-header">
    <h1>Database &amp; Website Settings</h1>
</div>

<p>vShare only run if your server support all <a
	href="https://www.buyscripts.in/vshare-requirements" target="_blank">requirements</a>.
If you don't know path to ffmpeg, mencoder, flvtool2, etc... installed
on your server, ask your server provider.</p>
<hr>

<form class="form-horizontal" name="myform2" method="POST" action="">
    <div class="form-group">
        <label class="control-label col-md-3">Site URL</label>
        <div class="col-md-5">
            <input type="text" class="form-control" name="site_url" size="33"
            value="<?php
            echo $site_url;
            ?>">
        </div>
        <div class="col-md-4">
            (i.e. <i>http://yoursite.com/vshare</i>)
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Site Path</label>
        <div class="col-md-5">
            <input type="text" class="form-control" name="folder" size="33"
            value="<?php
            echo $_POST['folder'];
            ?>">
        </div>
        <div class="col-md-4">
            (i.e. <i>/home/username/public_html</i>)
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">FFMpeg binary</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="ffmpeg_path" size="33"
            value="<?php
            echo $ffmpeg_path;
            ?>">
        </div>
        <div class="col-md-4">
            (i.e. <i>/usr/bin/ffmpeg</i>)
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Mencoder binary</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="mencoder_path" size="33"
            value="<?php
            echo $mencoder_path;
            ?>">
        </div>
        <div class="col-md-4">
            (i.e. <i>/usr/bin/mencoder</i>)
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Mplayer binary</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="mplayer_path" size="33"
            value="<?php
            echo $mplayer_path;
            ?>">
        </div>
        <div class="col-md-4">
            (i.e. <i>/usr/bin/mplayer</i>)
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">FLVTool binary</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="flvtool_path" size="33"
            value="<?php
            echo $flvtool_path;
            ?>">
        </div>
        <div class="col-md-4">
            (i.e. <i>/usr/bin/flvtool2</i>)
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-md-3">Qt-faststart binary</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="qtfaststart_path" size="33"
            value="<?php
            echo $qtfaststart_path;
            ?>">
        </div>
        <div class="col-md-4">
            (i.e. <i>/usr/bin/qt-faststart</i>)
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">MySQL database server</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="db_server" size="33"
            value="<?php
            echo $db_server;
            ?>">
        </div>
        <div class="col-md-4">
            usually <i>localhost</i>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Database name</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="db_name" size="33"
            value="<?php
            echo $db_name;
            ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Database user name</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="db_user" size="33"
            value="<?php
            echo $db_user;
            ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Database password</label>
        <div class="col-md-5">
            <input class="form-control" type="text" name="db_pass" size="33"
            value="<?php
            echo $db_pass;
            ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-3 col-md-5">
            <span class="text-info"><i>(NB : Don't use any ending slash in you path)</i></span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-3 col-md-4">
            <input type="submit" class='btn-block btn btn-primary btn-lg' name="connect_info"
            value="Continue Installation">
        </div>
    </div>
</form>

<?php

require 'tpl/footer.php';

