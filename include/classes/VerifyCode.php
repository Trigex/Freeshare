<?php

class VerifyCode {

    public static function create($data = array())
    {
        $sql = "INSERT INTO `verify_code` SET
               `vkey`='" . DB::quote($data['vkey']) . "'";

        if (isset($data['data1'])) {
            $sql .= ",`data1`='" . DB::quote($data['data1']) . "'";
        } else {
            $sql .= ",`data1`=''";
        }

        if (isset($data['data2'])) {
            $sql .= ",`data2`='" . DB::quote($data['data2']) . "'";
        } else {
            $sql .= ",`data2`=''";
        }

        $id = DB::insertGetId($sql);

        return $id;
    }
}
