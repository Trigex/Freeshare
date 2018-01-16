<?php

class Tag
{
    var $tags;
    var $vid;
    var $uid;
    var $channels;
    var $now;

    function Tag($keywords, $vid, $uid, $chid)
    {
        $this->vid = $vid;
        $this->uid = $uid;
        $keywords = $this->clean_tags($keywords);
        $keywords = preg_replace("/[,]+/", " ", $keywords);
        $keywords = preg_replace("/[\s]+/", " ", $keywords);
        $keywords = trim($keywords);
        $kw_arr = explode(' ', $keywords);
        $keywords_unique = array_unique($kw_arr);
        $new_kw_arr = array();

        foreach ($keywords_unique as $kw)
        {
            if (mb_strlen($kw, 'UTF-8') > 1 && mb_strlen($kw, 'UTF-8') < 20)
            {
                $kw = trim($kw);
                $new_kw_arr[] = $kw;
            }
        }

        $this->tags = $new_kw_arr;
        $this->channels = $chid;
        $this->now = time();
    }

    function delete($adjust_tag_count = 1)
    {
        $sql = "DELETE FROM `tag_video` WHERE
               `vid`='" . (int) $this->vid . "'";
        DB::query($sql);

        if ($adjust_tag_count == 1) {
            for ($i = 0; $i < count($this->tags); $i ++) {
                $sql = "SELECT * FROM `tags` WHERE
                       `tag`='" . $this->tags[$i] . "'";
                $tag_info = DB::fetch1($sql);

                if ($tag_info && $tag_info['tag_count'] > 0) {
                    $sql = "UPDATE `tags` SET `tag_count`=`tag_count`-1 WHERE
                           `tag`='" . $this->tags[$i] . "'";
                    DB::query($sql);
                }
            }
        }
    }

    function add()
    {
        foreach ($this->tags as $tag) {

            $sql = "SELECT * FROM `tags` WHERE
                   `tag`='" . DB::quote($tag) . "'";
            $tag_info = DB::fetch1($sql);

            if ($tag_info) {
                $sql = "UPDATE `tags` SET
                       `tag_count`=`tag_count`+1,
                       `used_on`='$this->now' WHERE
                       `tag`='" . DB::quote($tag) . "'";
                DB::query($sql);

                $sql = "INSERT INTO `tag_video` SET
                       `tag_id`='$tag_info[id]',
                       `vid`='$this->vid',
                       `chid`='$this->channels'";
                DB::query($sql);
            } else {
                $sql = "INSERT INTO `tags` SET
                       `tag`='$tag',
                       `tag_count`='1',
                       `used_on`='$this->now'";
                $tags_id = DB::insertGetId($sql);

                $sql = "INSERT INTO `tag_video` SET
                       `tag_id`=$tags_id,
                       `vid`=$this->vid,
                       `chid`='$this->channels'";
                DB::query($sql);
            }
        }
    }

    function settime($time)
    {
        $this->now = $time;
    }

    function clean_tags($tags)
    {
        $bad = array(
            "_",
            "^",
            ")",
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
            "%3d" // =
        );

        return stripslashes(str_replace($bad, '', $tags));
    }

    function get_tags()
    {
        return $this->tags;
    }
}
