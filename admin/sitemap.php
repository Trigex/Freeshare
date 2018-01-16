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

$sitemap = new Sitemap();

if (isset($_POST['generate_sitemap']))
{
    $msg = $sitemap->generate();
}

$smarty->assign('msg', $msg);
$smarty->assign('sitemap', $sitemap->getSitemapInfo());
$smarty->display('admin/header.tpl');
$smarty->display('admin/sitemap.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
