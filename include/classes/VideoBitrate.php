<?php

class VideoBitrate
{
    static function find($videoPath)
    {
        global $config;
        $bitrate = 0;
        $cmd = $config['ffmpeg'] . ' -i ' . $videoPath;
        @exec("$cmd 2>&1", $output_ffmpeg);

        $output_all_ffmpeg = implode("\n", $output_ffmpeg);

        if (@preg_match('/bitrate: ([0-9][0-9]+) .*/', $output_all_ffmpeg, $regs)) {
            $bitrate = (int) $regs[1];
        }

        return $bitrate;
    }

/*    static function findVideoBitrateMplayer($duration_arr)
    {
        global $config;
        $bitrate = 0;

        $video = $duration_arr['src'];
        $cmd = $config['mplayer'] . " -vo null -ao null -frames 0 -identify " . $video;
        @exec("$cmd 2>&1", $output_mplayer);
        $output_all_mplayer = implode("\n", $output_mplayer);

        if (@preg_match('/ID_VIDEO_BITRATE=([0-9\.]+)/', $output_all_mplayer, $regs))
        {
            $bitrate = (int) $regs[1] / 1000;
        }

        return $bitrate;
    }*/
}
