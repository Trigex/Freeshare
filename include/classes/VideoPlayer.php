<?php

class VideoPlayer
{
    var $video_info;

    function getPlayerCode($video_id)
    {
        global $config;
        $sql = "SELECT * FROM `videos` WHERE
               `video_id`=$video_id";
        $this->video_info = DB::fetch1($sql);

        if (! $this->video_info)
        {
            return 'video not found';
        }

        switch ($this->video_info['video_vtype'])
        {
            case 0:
                return $this->vshare_player();
                break;
            case 1:
                return $this->youtube();
                break;
            case 2:
                return $this->flv_url();
                break;
            case 3:
                return $this->divx();
                break;
            case 5:
                return $this->metcafe();
                break;
            case 6:
                return $this->embedded_code();
                break;
            case 7:
                return $this->dailymotion();
                break;
            default:
                break;
        }

    }

    function vshare_player()
    {
        global $config , $servers;

        $video_id = $this->video_info['video_id'];
        $video_folder = $this->video_info['video_folder'];

        $file = File::getVideoUrl($this->video_info['video_server_id'], $this->video_info['video_folder'], $this->video_info['video_flv_name']);
        $video_thumb_url = $servers[$this->video_info['video_thumb_server_id']];
        $vshare_player = Config::get('vshare_player');

        if ($vshare_player == 'videojs') {
            if (strpos($file, '.flv') !== false) {
                $vshare_player = 'JW Player';
            }
        }

        require VSHARE_DIR . '/include/player.inc';
        return $vshare_player;
    }

    function youtube()
    {
        global $config,$servers;
        $youtube_player = Config::get('youtube_player');

        if ($youtube_player == 'vshare')
        {
            $video_folder = $this->video_info['video_folder'];
            $file = 'http://www.youtube.com/v/' . $this->video_info['video_name'];
            $video_id = $this->video_info['video_id'];
            $video_thumb_url = $servers[$this->video_info['video_thumb_server_id']];
            $vshare_player = Config::get('vshare_player');

	        require VSHARE_DIR . '/include/player.inc';
	        return $vshare_player;
        }

        $vshare_player = '<iframe width="' . $config['player_width'] . '" height="' . $config['player_height'] . '" src="https://www.youtube.com/embed/' . $this->video_info['video_name'] . '?autoplay=' . $config['player_autostart'] . '" frameborder="0" allowfullscreen></iframe>';
        return $vshare_player;
    }

    function dailymotion()
    {
        global $config;

        $vshare_player = '<iframe frameborder="0" width="' . $config['player_width'] . '" height="' . $config['player_height'] . '" src="//www.dailymotion.com/embed/video/' . $this->video_info['video_name'] . '?logo=0&info=0&autoPlay=' . $config['player_autostart'] . '" allowfullscreen></iframe>';
        return $vshare_player;
    }

    function metcafe()
    {
        global $config;
        $vshare_player = '<iframe src="http://www.metacafe.com/embed/' . $this->video_info['video_name'] . '/?ap=' . $config['player_autostart'] . '" width="' . $config['player_width'] . '" height="' . $config['player_height'] . '" allowFullScreen frameborder="0"></iframe>';
        return $vshare_player;
    }

    function embedded_code()
    {
        return $this->video_info['video_embed_code'];
    }

    function flv_url()
    {
        global $config, $servers;
        $file = $this->video_info['video_embed_code'];
        $video_id = $this->video_info['video_id'];
        $video_folder = $this->video_info['video_folder'];
        $video_thumb_url = $servers[$this->video_info['video_thumb_server_id']];
        $vshare_player = "JW Player";
        require VSHARE_DIR . '/include/player.inc';
        return $vshare_player;
    }
}