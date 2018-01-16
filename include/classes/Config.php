<?php

class Config
{
    public static function get($config_name)
    {
        $sql = "SELECT * FROM `config` WHERE
               `config_name`='$config_name'";
        $config_data = DB::fetch1($sql);
        return $config_data['config_value'];
    }

    public static function exists($config_name)
    {
        $sql = "SELECT * FROM `config` WHERE
               `config_name`='" . DB::quote($config_name) . "'";
        if (DB::fetch1($sql)) {
            return 1;
        } else {
            return 0;
        }
    }
}
