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

ob_start();
phpinfo();
$phpinfo_txt = ob_get_contents();
ob_end_clean();

preg_match ('%<style type="text/css">(.*?)</style>.*?<body>(.*?)</body>%s', $phpinfo_txt, $matches);

$phpinfo_no_css = '<div id="vshare-phpinfo">' . $matches[2] . '</div>';

$phpinfo_css = "<style>
#vshare-phpinfo { font-family: verdana; font-size: 12pt; }
#vshare-phpinfo td,
#vshare-phpinfo th,
#vshare-phpinfo h1,
#vshare-phpinfo h2 {font-family: sans-serif;}
#vshare-phpinfo pre {margin: 0px; font-family: monospace;}
#vshare-phpinfo a:link {color: #000099; text-decoration: none; background-color: #ffffff;}
#vshare-phpinfo a:hover {text-decoration: underline;}
#vshare-phpinfo table {border-collapse: collapse;}
#vshare-phpinfo .center {text-align: center;}
#vshare-phpinfo .center table { margin-left: auto; margin-right: auto; text-align: left;}
#vshare-phpinfo .center th { text-align: center !important; }
#vshare-phpinfo td, #vshare-phpinfo th { border: 1px solid #000000; font-size: 75%; vertical-align: baseline;}
#vshare-phpinfo h1 {font-size: 150%;}
#vshare-phpinfo h2 {font-size: 125%;}
#vshare-phpinfo .p {text-align: left;}
#vshare-phpinfo .e {background-color: #ccccff; font-weight: bold; color: #000000;}
#vshare-phpinfo .h {background-color: #9999cc; font-weight: bold; color: #000000;}
#vshare-phpinfo .v {background-color: #cccccc; color: #000000;}
#vshare-phpinfo .vr {background-color: #cccccc; text-align: right; color: #000000;}
#vshare-phpinfo img {float: right; border: 0px;}
#vshare-phpinfo hr {width: 600px; background-color: #cccccc; border: 0px; height: 1px; color: #000000;}
</style>";

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
echo $phpinfo_no_css;
echo $phpinfo_css;
$smarty->display('admin/footer.tpl');
DB::close();
