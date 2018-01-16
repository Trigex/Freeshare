<?php

class Xss
{
    static function clean($string)
    {
        if (is_array($string)) {
            die('Xss::clean only clean strings. Do not pass array');
        }
        if (Config::get('allow_html')) {
            require VSHARE_DIR . '/include/htmlpurifier/HTMLPurifier.auto.php';
            $config = HTMLPurifier_Config::createDefault();
            $config->set('HTML.DefinitionID', 'User Comment Filter');
            $config->set('HTML.DefinitionRev', 1);
            $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
            $config->set('HTML.Allowed', 'a[href|title],img[src|alt|width|height],em,strong,p,pre,b');
            $config->set('AutoFormat.Linkify', true);
            $config->set('AutoFormat.AutoParagraph', true);
            $purifier = new HTMLPurifier($config);
            return $purifier->purify($string);
        } else {
            return htmlspecialchars_uni($string);
        }
    }
}
