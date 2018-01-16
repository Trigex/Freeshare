<?php

class File
{
    public static function get_extension($file)
    {
        $file_name = basename($file);
        $pos = strrpos($file_name, '.');
        return strtolower(substr($file_name, $pos + 1, strlen($file_name) - $pos));
    }

    public static function getVideoUrl($server_id, $folder, $name)
    {
        global $config;
        $folder = trim($folder);

        $sql = "SELECT * FROM `servers` WHERE
               `id`=$server_id";
        $server_info = DB::fetch1($sql);
        $secret = $server_info['server_secdownload_secret'];

        if ($server_info['server_type'] == 2 && $server_id != 0)
        {
            // lighttpd mod_secdownload
            $uri_prefix = '/dl/';
            $f = '/' . $folder . $name;
            $t = time();
            $t_hex = sprintf('%08x', $t);
            $m = md5($secret . $f . $t_hex);
            $file_url = $server_info['url'] .  $uri_prefix . $m . '/' . $t_hex . $f;
        }
        else if ($server_info['server_type'] == 3 && $server_id != 0)
        {
            // nginx ngx_http_secure_link_module
            $file_uri = '/' . $folder . $name;
            $time = time()+ 3600;
            $md5hash_sd = md5($time . '.' . $file_uri .'.' . $secret, true);
            $md5hash_sd = str_replace('=', '', strtr(base64_encode($md5hash_sd), '+/', '-_'));
            $file_url =  $server_info['url'] . '/media/' . $md5hash_sd . ',' .$time . $file_uri;
        }
        else if ($server_info['server_type'] == 0 && $server_id != 0) {
            $file_url = $server_info['url'] . '/' . $folder . $name;
        }
        else
        {
            $file_url = VSHARE_URL . '/flvideo/' . $folder . $name;
        }

        return $file_url;
    }
}
