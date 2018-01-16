<?php

class Http
{
    public static function redirect($url)
    {
        if (! headers_sent()) {
            header("Location: $url");
        } else {
            echo "<script language=Javascript>document.location.href='$url';</script>";
        }
        exit(0);
    }

    public static function download($source, $destination)
    {
        $written = null;
        $source = str_replace(' ', '%20', html_entity_decode($source));
        $read = fopen("$source", "r");
        $write = fopen("$destination", "wb");

        if (! $read) {
            $err = 0;
            return $err;
        }

        if (! $write) {
            $err = 1;
            return $err;
        }

        while (! feof($read)) {
            $written += fwrite($write, fread($read, 1024));
        }

        fclose($read);
        fclose($write);
        return $written;
    }
}
