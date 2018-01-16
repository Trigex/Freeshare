<?php

class Group
{
    static function getById($group_id)
    {
        $sql = 'SELECT * FROM `groups` WHERE
               `group_id`=' . (int) $group_id ;
        return DB::fetch1($sql);
    }
}
