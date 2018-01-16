<?php

class Package
{
    public static function find($package_id)
    {
        $sql = "SELECT * FROM `packages` WHERE
                `package_id`=" . (int) $package_id;
        return DB::fetch1($sql);
    }
}
