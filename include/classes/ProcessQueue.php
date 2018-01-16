<?php

class ProcessQueue {

    public static function create($data = array())
    {
        $sql = "INSERT INTO `process_queue` SET
               `user`='" . DB::quote($data['user']) . "',
               `title`='" . DB::quote($data['title']) . "',
               `description`='" . DB::quote($data['description']) . "',
               `keywords`='" . DB::quote($data['keywords']) . "',
               `channels`='" . DB::quote($data['channels']) . "',
               `type`='" . DB::quote($data['type']) . "',
               `process_queue_upload_ip`='" . DB::quote(User::get_ip()) . "'";

        if (isset($data['status'])) {
            $sql .= ",`status`='" . DB::quote($data['status']) . "'";
        } else {
            $sql .= ",`status`='2'";
        }

        if (isset($data['url'])) {
            $sql .= ",`url`='" . DB::quote($data['url']) . "'";
        } else {
            $sql .= ",`url`=''";
        }

        if (isset($data['file'])) {
            $sql .= ",`file`='" . DB::quote($data['file']) . "'";
        } else {
            $sql .= ",`file`=''";
        }

        if (isset($data['vid'])) {
            $sql .= ",`vid`='" . DB::quote($data['vid']) . "'";
        } else {
            $sql .= ",`vid`='0'";
        }

        if (isset($data['import_track_id'])) {
            $sql .= ",`import_track_id`='" . DB::quote($data['import_track_id']) . "'";
        } else {
            $sql .= ",`import_track_id`='0'";
        }

        if (isset($data['adult'])) {
            $sql .= ",`adult`='" . DB::quote($data['adult']) . "'";
        } else {
            $sql .= ",`adult`='0'";
        }

        $id = DB::insertGetId($sql);

        return $id;
    }
}
