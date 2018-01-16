<?php

class VideoDuration
{

    private static $debug = false;

    public static function find($videoPath, $tool = 'ffmpeg', $debug = false)
    {
        self::$debug = $debug;

        if ($tool == 'mplayer') {
            $duration = self::_findWithMplayer($videoPath);
        } else if ($tool == 'ffmpeg') {
            $duration = self::_findWithFfmpeg($videoPath);
        } else {
            $duration = self::_findWithFfmpegPhp($videoPath);
        }
        return $duration;
    }

    private static function _findWithFfmpeg($videoPath)
    {
        global $config;
        $cmd = $config['ffmpeg'] . " -i '" . $videoPath . "'";
        @exec("$cmd 2>&1", $output);

        $output_all = implode("\n", $output);

        if (self::$debug) {
            echo "<p>$cmd</p>";
            echo "<pre>";
            print_r($output_all);
            echo "</pre>";
        }

        if (@preg_match('/Duration: ([0-9][0-9]:[0-9][0-9]:[0-9\.]+), .*/', $output_all, $regs)) {
            $sec = $regs[1];
            $duration_array = explode(":", $sec);
            $sec = ($duration_array[0] * 3600) + ($duration_array[1] * 60) + $duration_array[2];
            $sec = (int) $sec;
            if (self::$debug) echo "<p>Duration found = $sec seconds.</p>";
        } else {
            $sec = 0;
        }
        return $sec;
    }

    private static function _findWithMplayer($videoPath)
    {
        global $config;

        $cmd = $config['mplayer'] . " -vo null -ao null -frames 0 -identify '" . $videoPath . "'";
        @exec("$cmd 2>&1", $output);

        $output_all = implode("\n", $output);

        if (self::$debug) {
            echo "<p>$cmd</p>";
            echo "<pre>";
            print_r($output_all);
            echo "</pre>";
        }

        if (@preg_match('/ID_LENGTH=([0-9\.]+)/', $output_all, $regs)) {
            $sec = (int) $regs[1];
        } else {
            $sec = 0;
        }
        return $sec;
    }

    private static function _findWithFfmpegPhp($videoPath)
    {
        $output = new ffmpeg_movie($videoPath);
        $sec = $output->getDuration();
        $sec = round($sec, 2);
        return $sec;
    }
}
