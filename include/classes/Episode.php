<?php

class Episode {

    public static function get()
    {
        $sql = "SELECT * FROM `episodes`
                ORDER BY `episode_name` ASC";
        $episodes = DB::fetch($sql);
        return $episodes;
    }

    public static function exists($name, $id = 0)
    {
        $sql = "SELECT * FROM `episodes` WHERE
               `episode_name`='" . DB::quote($name) . "'";
        $episode_info = DB::fetch1($sql);
        if ($episode_info) {
            if ($episode_info['episode_id'] == $id) {
                return false;
            }
        }
        return $episode_info;
    }

    public static function add($name)
    {
        $sql = "INSERT INTO `episodes` SET
               `episode_name`='" . DB::quote($name) . "'";
        return DB::insertGetId($sql);
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM `episodes` WHERE
               `episode_id`='" . (int) $id . "'";
        return DB::fetch1($sql);
    }

    public static function getNameById($id)
    {
        $episode_info = self::getById($id);
        return $episode_info['episode_name'];
    }

    public static function delete($id)
    {
        EpisodeVideo::deleteByEpisode($id);

        $sql = "DELETE FROM `episodes` WHERE
               `episode_id`='$id'";
        DB::query($sql);
        return true;
    }
}