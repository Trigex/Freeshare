<?php

class Url
{
    public static function seoName($s)
    {
        $s = stripslashes($s);
        $s = strip_tags($s);
        $s = preg_replace('!&[^;\s]+;!', '', $s);
        $s = self::convertHighAscii($s);
        $s = self::cleanSpecialChrs($s);
        $s = mb_strtolower($s, 'UTF-8');
        $s = trim($s);
        $s = preg_replace('!\s+!', '-', $s);

        if ($s == '')
        {
            $s = '-';
        }
        return $s;
    }

    public static function convertHighAscii($title)
    {
        $HighASCII = array(
            "!\xc0!" => 'A', # A`
            "!\xe0!" => 'a', # a`
            "!\xc1!" => 'A', # A'
            "!\xe1!" => 'a', # a'
            "!\xc2!" => 'A', # A^
            "!\xe2!" => 'a', # a^
            "!\xc4!" => 'Ae', # A:
            "!\xe4!" => 'ae', # a:
            "!\xc3!" => 'A', # A~
            "!\xe3!" => 'a', # a~
            "!\xc8!" => 'E', # E`
            "!\xe8!" => 'e', # e`
            "!\xc9!" => 'E', # E'
            "!\xe9!" => 'e', # e'
            "!\xca!" => 'E', # E^
            "!\xea!" => 'e', # e^
            "!\xcb!" => 'Ee', # E:
            "!\xeb!" => 'ee', # e:
            "!\xcc!" => 'I', # I`
            "!\xec!" => 'i', # i`
            "!\xcd!" => 'I', # I'
            "!\xed!" => 'i', # i'
            "!\xce!" => 'I', # I^
            "!\xee!" => 'i', # i^
            "!\xcf!" => 'Ie', # I:
            "!\xef!" => 'ie', # i:
            "!\xd2!" => 'O', # O`
            "!\xf2!" => 'o', # o`
            "!\xd3!" => 'O', # O'
            "!\xf3!" => 'o', # o'
            "!\xd4!" => 'O', # O^
            "!\xf4!" => 'o', # o^
            "!\xd6!" => 'Oe', # O:
            "!\xf6!" => 'oe', # o:
            "!\xd5!" => 'O', # O~
            "!\xf5!" => 'o', # o~
            "!\xd8!" => 'Oe', # O/
            "!\xf8!" => 'oe', # o/
            "!\xd9!" => 'U', # U`
            "!\xf9!" => 'u', # u`
            "!\xda!" => 'U', # U'
            "!\xfa!" => 'u', # u'
            "!\xdb!" => 'U', # U^
            "!\xfb!" => 'u', # u^
            "!\xdc!" => 'Ue', # U:
            "!\xfc!" => 'ue', # u:
            "!\xc7!" => 'C', # ,C
            "!\xe7!" => 'c', # ,c
            "!\xd1!" => 'N', # N~
            "!\xf1!" => 'n', # n~
            "!\xdf!" => 'ss'
        );

        $find = array_keys($HighASCII);
        $replace = array_values($HighASCII);
        $s = preg_replace($find, $replace, $title);
        return $title;
    }

    public static function cleanSpecialChrs($title)
    {
        $bad = array(
            "_",
            "-",
            "^",
            ")",
            ".",
            "(",
            "%",
            "!",
            "@",
            "*",
            "../",
            "./",
            "<!--",
            "-->",
            "<",
            ">",
            "'",
            '"',
            '&',
            '$',
            '#',
            '{',
            '}',
            '[',
            ']',
            '=',
            ';',
            '?',
            '/',
            ':',
            ',',
            '|',
            "%20",
            "%22",
            "%3c", // <
            "%253c", // <
            "%3e", // >
            "%0e", // >
            "%28", // (
            "%29", // )
            "%2528", // (
            "%26", // &
            "%24", // $
            "%3f", // ?
            "%3b", // ;
            "%3d"
        );

        return stripslashes(str_replace($bad, '', $title));
    }
}