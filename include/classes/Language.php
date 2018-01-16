<?php

class Language
{
    public static function set($lang)
    {
        language::validate($lang);

        if (isset($_SERVER['HTTP_REFERER'])) {
            $redirect_url = $_SERVER['HTTP_REFERER'];
        }

        if (stripos($redirect_url, VSHARE_URL) === false) {
            $redirect_url = VSHARE_URL . '/';
        }

        Http::redirect($redirect_url);
    }

    public static function validate($lang)
    {
        global $language;

        $allowedLaguages = array(
            'en', 'fr'
        );

        if (! in_array($lang, $allowedLaguages)) {
            $lang = $language;
        }

        $_SESSION['LANG'] = $lang;
        setcookie('LANG', $lang, time() + 2592000); /* expire in 30 days */
    }

    public static function cookie()
    {
        $lang = isset($_COOKIE['LANG']) ? $_COOKIE['LANG'] : '';
        language::validate($lang);
    }
}
