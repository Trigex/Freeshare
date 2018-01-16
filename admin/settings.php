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
require '../include/language/' . LANG . '/admin/settings.php';

Admin::auth();

if (isset($_POST['submit']))
{
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['site_name']) . "' WHERE
           `soption`='site_name'";
    DB::query($sql);

    $sql = "UPDATE `config` SET
           `config_value`='" . (int) $_POST['allow_html'] . "' WHERE
           `config_name`='allow_html'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['meta_keywords']) . "' WHERE
           `soption`='meta_keywords'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['meta_description']) . "' WHERE
           `soption`='meta_description'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['admin_email']) . "' WHERE
           `soption`='admin_email'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['items_per_page']) . "' WHERE
           `soption`='items_per_page'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['rel_video_per_page'] . "' WHERE
           `soption`='rel_video_per_page'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['num_watch_videos'] . "' WHERE
           `soption`='num_watch_videos'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['enable_package'] . "' WHERE
           `soption`='enable_package'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['approve'] . "' WHERE
           `soption`='approve'";
    DB::query($sql);

    $sql = 'UPDATE `config` SET
            `config_value`="' . $_POST['moderate_video_links'] . '" WHERE
            `config_name`="moderate_video_links"';
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['debug'] . "' WHERE
           `soption`='debug'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['notify_upload'] . "' WHERE
           `soption`='notify_upload'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['guest_limit'] . "' WHERE
           `soption`='guest_limit'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['embed_show'] . "' WHERE
           `soption`='embed_show'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['embed_type'] . "' WHERE
           `soption`='embed_type'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['cache_enable'] . "' WHERE
           `soption`='cache_enable'";
    DB::query($sql);

    if ($config['enable_package'] == 'yes')
    {
        $_POST['method'] = isset($_POST['method']) ? $_POST['method'] : '';

        if ($_POST['method'] == '')
        {
            $err = $lang['payment_method_empty'];
        }
        else
        {
            $payment_method = implode('|', $_POST['method']);
            $sql = "UPDATE `sconfig` SET
                   `svalue`='$payment_method' WHERE
                   `soption`='payment_method'";
            DB::query($sql);
        }

        if ($err == '')
        {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . DB::quote($_POST['paypal_receiver_email']) . "' WHERE
                   `soption`='paypal_receiver_email'";
            DB::query($sql);

            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . DB::quote($_POST['enable_test_payment']) . "' WHERE
                   `soption`='enable_test_payment'";
            DB::query($sql);

            if (preg_match("/CCBill/i", $payment_method))
            {
                if (! is_numeric($_POST['ccbill_ac_no']))
                {
                    $err = 'CCBill account number must be numeric';
                }
                else if (! is_numeric($_POST['ccbill_sub_ac_no']))
                {
                    $err = 'CCBill sub account number must be numeric';
                }
                else
                {
                    $_POST['ccbill_ac_no'] = isset($_POST['ccbill_ac_no']) ? $_POST['ccbill_ac_no'] : '';
                    $_POST['ccbill_ac_no'] = trim($_POST['ccbill_ac_no']);

                    if (Config::exists('ccbill_ac_no'))
                    {
                        $sql = "UPDATE `config` SET
                               `config_value`='" . DB::quote($_POST['ccbill_ac_no']) . "' WHERE
                               `config_name`='ccbill_ac_no'";
                        DB::query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `config` SET
                               `config_name`='ccbill_ac_no',
                               `config_value`='" . DB::quote($_POST['ccbill_ac_no']) . "'";
                        DB::query($sql);
                    }

                    $_POST['ccbill_sub_ac_no'] = isset($_POST['ccbill_sub_ac_no']) ? $_POST['ccbill_sub_ac_no'] : '';
                    $_POST['ccbill_sub_ac_no'] = trim($_POST['ccbill_sub_ac_no']);

                    if (Config::exists('ccbill_sub_ac_no'))
                    {
                        $sql = "UPDATE `config` SET
                               `config_value`='" . DB::quote($_POST['ccbill_sub_ac_no']) . "' WHERE
                               `config_name`='ccbill_sub_ac_no'";
                        DB::query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `config` SET
                               `config_name`='ccbill_sub_ac_no',
                               `config_value`='" . DB::quote($_POST['ccbill_sub_ac_no']) . "'";
                        DB::query($sql);
                    }

                    $_POST['ccbill_form_name'] = isset($_POST['ccbill_form_name']) ? $_POST['ccbill_form_name'] : '';
                    $_POST['ccbill_form_name'] = trim($_POST['ccbill_form_name']);

                    if (Config::exists('ccbill_form_name'))
                    {
                        $sql = "UPDATE `config` SET
                               `config_value`='" . DB::quote($_POST['ccbill_form_name']) . "' WHERE
                               `config_name`='ccbill_form_name'";
                        DB::query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `config` SET
                               `config_name`='ccbill_form_name',
                               `config_value`='" . DB::quote($_POST['ccbill_form_name']) . "'";
                        DB::query($sql);
                    }

                }
            }
        }
    }

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['family_filter']) . "' WHERE
           `soption`='family_filter'";
    DB::query($sql);

    $hotlink_protection = (int) $_POST['hotlink_protection'];

    $sql = 'UPDATE `config` SET
            `config_value`="' . $hotlink_protection . '" WHERE
            `config_name`="hotlink_protection"';
    DB::query($sql);

    if ($hotlink_protection == 0)
    {
        $fp = fopen(VSHARE_DIR . '/flvideo/.htaccess', 'w');
        fclose($fp);
    }
    else if ($hotlink_protection == 1)
    {
        $content = 'RewriteEngine On
RewriteBase /
RewriteCond %{HTTP_REFERER} !^' . VSHARE_URL . ' [NC]
';
        $fp = fopen(VSHARE_DIR . '/flvideo/.htaccess', 'w');
        fwrite($fp, $content, strlen($content));
        fclose($fp);
    }
    else if ($hotlink_protection == 2)
    {
        $content = 'RewriteEngine On
RewriteBase /
RewriteCond %{HTTP_REFERER} !^' . VSHARE_URL . ' [NC]
RewriteCond %{HTTP_COOKIE} !vShareAllow=yes [NC]
RewriteRule .* [F]
';
        $fp = fopen(VSHARE_DIR . '/flvideo/.htaccess', 'w');
        fwrite($fp, $content, strlen($content));
        fclose($fp);
    }

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['logo_url_md']) . "' WHERE
           `soption`='logo_url_md'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['logo_url_sm']) . "' WHERE
           `soption`='logo_url_sm'";
    DB::query($sql);

    if ($err == '')
    {
        set_message($lang['settings_updated'], 'success');
        $redirect_url = VSHARE_URL . '/admin/settings.php';
        Http::redirect($redirect_url);
    }
}

if ($config['enable_package'] == 'yes')
{
    $service_ops = "<option value='yes' selected=\"selected\">Enable Package</option><option value=\"no\">Free Service</option>";
}
else
{
    $service_ops = "<option value='yes'>Enable Package</option><option value='no' selected=\"selected\">Free Service</option>";
}

$smarty->assign('service_ops', $service_ops);

$ccbill_enabled = '';
$paypal_enabled = '';

if ($config['payment_method'] != '')
{
    $method = explode('|', $config['payment_method']);

    while (list($k, $v) = each($method))
    {
        if ($v == 'Paypal')
        {
            $paypal_enabled = "checked=\"checked\"";
        }
        else if ($v == 'CCBill')
        {
            $ccbill_enabled = "checked=\"checked\"";
        }
    }
}

$payment_method_ops = '<input type="checkbox" name="method[]" value="Paypal" ' . $paypal_enabled . ' /> Paypal <input type="checkbox" name="method[]" value="CCBill" ' . $ccbill_enabled . ' /> CCBill<br />';

$smarty->assign('ccbill_ac_no', Config::get('ccbill_ac_no'));
$smarty->assign('ccbill_sub_ac_no', Config::get('ccbill_sub_ac_no'));
$smarty->assign('ccbill_form_name', Config::get('ccbill_form_name'));
$smarty->assign('moderate_video_links', Config::get('moderate_video_links'));
$smarty->assign('hotlink_protection', Config::get('hotlink_protection'));

$smarty->assign('allow_html', Config::get('allow_html'));
$smarty->assign('payment_method_ops', $payment_method_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
