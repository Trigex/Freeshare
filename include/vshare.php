<?php

$vshare_version = '3.2';
date_default_timezone_set('GMT');
set_time_limit(0);

define('VSHARE_DIR', $config['basedir']);
define('VSHARE_URL', $config['baseurl']);
$config['TMB_DIR'] = VSHARE_DIR . '/thumb';

require VSHARE_DIR . '/include/smarty/libs/Smarty.class.php';

$smarty = new Smarty();
if (defined('ADMIN_AREA')) {
    $smarty->template_dir = VSHARE_DIR . '/themes';
    $img_css_url = VSHARE_URL . '/themes';
} else {
    if (! isset($config['theme'])) {
        $smarty->template_dir = VSHARE_DIR . '/templates';
        $img_css_url = VSHARE_URL . '/templates';
    } else {
        $smarty->template_dir = VSHARE_DIR . '/themes/' . $config['theme'];
        $img_css_url = VSHARE_URL . '/themes/' . $config['theme'];
    }
}
$smarty->compile_dir = VSHARE_DIR . '/templates_c';
$smarty->cache_dir = VSHARE_DIR . '/templates_c/cache';
$smarty->caching = 0;
$smarty->error_reporting = E_ALL & ~E_NOTICE;

function vshare_autoload ($my_class_name) {
        include(__DIR__ . '/classes/' . $my_class_name . ".php");
}

spl_autoload_register("vshare_autoload");

DB::connect($db_host, $db_user, $db_pass, $db_name);

require VSHARE_DIR . '/include/functions.php';

$sql = "SELECT * FROM `sconfig`";
$result = DB::query($sql);

while ($tmp = mysqli_fetch_assoc($result)) {
    $field = $tmp['soption'];
    $config[$field] = $tmp['svalue'];
}

DB::freeResult();
$smarty->assign($config);

$sql = "SELECT * FROM `servers`";
$result = DB::query($sql);

$servers[0] = VSHARE_URL;

if (mysqli_num_rows($result) > 0) {
    while ($tmp = mysqli_fetch_assoc($result)) {
        $tmp_server_id = $tmp['id'];
        $servers[$tmp_server_id] = $tmp['url'];
    }
}

define('IMG_CSS_URL', $img_css_url);

$smarty->assign(array(
    'servers' => $servers,
    'base_url' => VSHARE_URL,
    'base_dir' => VSHARE_DIR,
    'img_css_url' => IMG_CSS_URL,
    'html_head_extra' => '',
    'html_extra' => '',
    'html_title' => '',
    'sub_menu' => '',
    'err' => '',
    'msg' => '',
));

if ($config['approve'] == 1) {
    $active = "and `active`='1'";
}

if (! isset($language)) {
    $language = 'en';
}

set_include_path('.' . PATH_SEPARATOR . VSHARE_DIR . '/include/' . PATH_SEPARATOR . VSHARE_DIR . '/include/PEAR/' . PATH_SEPARATOR . get_include_path());

$result_per_page = 20;

$msg = '';
$err = '';

if (isset($_SESSION['vshare_message'])) {
    switch ($_SESSION['vshare_message_type']) {
        case 'success':
            $msg = $_SESSION['vshare_message'];
            break;
        case 'error':
            $err = $_SESSION['vshare_message'];
            break;
        default:
            $msg = $_SESSION['vshare_message'];
            break;
    }
    unset($_SESSION['vshare_message']);
    unset($_SESSION['vshare_message_type']);
}

if (! isset($_SESSION['CSS'])) {
    Css::cookie();
}

if (! isset($_SESSION['LANG'])) {
    Language::cookie();
}

if (! isset($_SESSION['USERNAME']) && isset($_COOKIE['VSHARE_AL_PASSWORD'])) {
    User::login_auto();
}
define('LANG', $_SESSION['LANG']);

if ($config['family_filter'] == 1) {
    if (! isset($_SESSION['FAMILY_FILTER'])) {
        $_SESSION['FAMILY_FILTER'] = 1;
    }
}

function dd($debug_message) {
    echo '<pre>';
    print_r($debug_message);
    exit;
}
