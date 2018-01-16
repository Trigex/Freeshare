<?php

class EpisodeVideo {

    public static function getByVideoId($video_id)
    {
        $sql = "SELECT * FROM `episode_videos` WHERE
               `ep_video_vid`='" . (int) $video_id . "'";
        return DB::fetch1($sql);
    }

    public static function add($episode_id, $video_id)
    {
        $ep_video_info = self::getByVideoId($video_id);

        if (! $ep_video_info) {
            $sql = "INSERT INTO `episode_videos` SET
                   `ep_video_eid`='" . (int) $episode_id . "',
                   `ep_video_vid`='" . (int) $video_id . "'";
            return DB::insertGetId($sql);
        } else {
            $sql = "UPDATE `episode_videos` SET
                   `ep_video_eid`='" . (int) $episode_id . "' WHERE
                   `ep_video_id`='" . (int) $ep_video_info['ep_video_id'] . "'";
            DB::query($sql);
            return $ep_video_info['ep_video_id'];
        }
    }

    public static function count($eid)
    {
        $sql = "SELECT COUNT(`ep_video_id`) AS `total`
                FROM `episode_videos` WHERE
               `ep_video_eid`='" . (int) $eid . "'";
        $total = DB::getTotal($sql);
        return $total;
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM `episode_videos` WHERE
               `ep_video_id`='" . (int) $id . "'";
        $video = DB::fetch1($sql);
        return $video;
    }

    public static function getInfo($eid)
    {
        $sql = "SELECT ev.*, v.video_id, v.video_title, v.video_seo_name FROM
               `episode_videos` AS `ev`, `videos` AS `v` WHERE
                ev.ep_video_vid=v.video_id AND
                ev.ep_video_eid='" . (int) $eid . "'";
        $videos = DB::fetch($sql);
        return $videos;
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM `episode_videos` WHERE
               `ep_video_id`='" . (int) $id . "'";
        DB::query($sql);
        return true;
    }

    public static function deleteByEpisode($eid)
    {
        $sql = "DELETE FROM `episode_videos` WHERE
               `ep_video_eid`='" . (int) $eid . "'";
        DB::query($sql);
        return true;
    }
}
