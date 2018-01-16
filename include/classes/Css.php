<?php

class Css
{
    public static function set($css)
    {
        css::validate($css);

        $redirect_url = '';

        if (isset($_SERVER['HTTP_REFERER'])) {
            $redirect_url = $_SERVER['HTTP_REFERER'];
        }

        if (stripos($redirect_url, VSHARE_URL) === false) {
            $redirect_url = VSHARE_URL . '/';
        }

        Http::redirect($redirect_url);
    }

    public static function validate($css)
    {
        $valid_css = array(
            'default', 'black'
        );

        if (! in_array($css, $valid_css)) {
            $css = 'default';
        }
        $_SESSION['CSS'] = $css;
        setcookie('CSS', $css, time() + 2592000); /* expire in 30 days */
    }

    public static function cookie()
    {
        $css = isset($_COOKIE['CSS']) ? $_COOKIE['CSS'] : '';
        css::validate($css);
    }
}
