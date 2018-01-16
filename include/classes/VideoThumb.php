<?php

/*
video => thumbnail
input ==> video path, vid
*/

class VideoThumb
{
    public static function make($video_data)
    {
        if (! isset($video_data['duration'])) {
            $video_data['duration'] = VideoDuration::find($video_data['src'], $video_data['tool'], $video_data['debug']);
        }

        if ($video_data['tool'] == 'mplayer') {
            $tmp = self::_createWithMplayer($video_data);
        } else {
            $tmp = self::_createWithFfmpeg($video_data);
        }

        return $tmp;
    }

    private static function _createWithFfmpeg($t_info)
    {

        global $config;

        $duration = $t_info['duration'];
        $debug = isset($t_info['debug']) ? $t_info['debug'] : 0;
        $step = intval($t_info['duration'] / 5);

        if ($step < 2) {
            $step = 1;
        } else if ($step > 20) {
            $step_c = intval($step / 20);
            $step_a = $step - $step_c;
            $step_b = $step + $step_c;
            $step = rand($step_a, $step_b);
        }

        $i = 1;

        if ($debug) {
            echo "<h2>Creating Thumbnail with ffmpeg</h2>";
        }

        $thumb_folder = VSHARE_DIR . '/thumb/' . $t_info['video_folder'];
        $no_thumb_image = VSHARE_DIR . '/themes/default/images/no_thumbnail.gif';
        @unlink($thumb_folder . '/' . $t_info['vid'] . ".jpg");
        @unlink($thumb_folder . '/1_' . $t_info['vid'] . ".jpg");
        @unlink($thumb_folder . '/2_' . $t_info['vid'] . ".jpg");
        @unlink($thumb_folder . '/3_' . $t_info['vid'] . ".jpg");

        $fc = 0;

        for ($pos = 1; $pos <= $duration; $pos += $step) {

            # echo "<h1>$pos = 1; $pos < $duration; $pos += $step</h1>";

            $pos_this = $pos;

            if ($fc == 0) {
                $maxwidth = 500;
                $maxheight = 300;
                $pos_this = rand(1, $duration);
                $fd = $thumb_folder . '/' . $t_info['vid'] . ".jpg";
            } else {
                $maxwidth = $config['img_max_width'];
                $maxheight = $config['img_max_height'];
                $fd = $thumb_folder . "/" . $fc . "_" . $t_info['vid'] . ".jpg";
                if ($fc == 1) {
                    $pos_this = rand(1, $duration);
                }
            }

            $thumb_position = sec2hms($pos_this);

            if (strlen($thumb_position) == 5) {
                $thumb_position = '00:' . $thumb_position;
            }

            if ($debug) {
                echo "<p>$fd</p>";
            }

            $cmd = "$config[ffmpeg] -ss $thumb_position -i '$t_info[src]' -s " . $maxwidth . 'x' . $maxheight . " '$fd' -r 1 -vframes 1 -an -vcodec mjpeg";
            @exec("$cmd 2>&1", $output);

            if ($debug) {
                echo "<pre>$cmd</pre>";
            }

            if (! file_exists($fd)) {
                copy($no_thumb_image, $fd);
            }

            $fc ++;

            if ($fc == 4) {
                break;
            }
        }

        if (file_exists($fd)){
            return 1;
        } else {
            return 0;
        }
    }

    private static function _createWithMplayer($t_info)
    {
        global $config;

        $debug = isset($t_info['debug']) ? $t_info['debug'] : 0;

        $output_folder = VSHARE_DIR . '/templates_c/' . $t_info['vid'] . '/';
        $thumb_folder = VSHARE_DIR . '/thumb/' . $t_info['video_folder'];

        mkdir($output_folder);

        $duration = intval($t_info['duration']);
        $sstep = intval($t_info['duration'] / 5);

        if ($sstep < 2) {
            $sstep = 0;
        } else if ($sstep > 20) {
            $sstep_c = intval($sstep / 20);
            $sstep_a = $sstep - $sstep_c;
            $sstep_b = $sstep + $sstep_c;
            $sstep = rand($sstep_a, $sstep_b);
        }

        $fc = 0;

        for ($i = 1; $i < $duration; $i += $sstep) {

            $cmd = $config['mplayer'] . " '$t_info[src]' -ss " . $i . " -nosound -vo jpeg:outdir=" . $output_folder . " -frames 2";
            @exec("$cmd 2>&1", $output_all);

            write_log($cmd);

            if ($debug) {
                echo "<h1>CREATING THUMBNAIL $fc</h1>";
                echo "<p>$cmd</p>";
                echo "<pre>";
                print_r($output_all);
                echo "</pre>";
            }

            if ($fc == 0) {
                $maxwidth = 500;
                $maxheight = 300;
                $fd = $thumb_folder . '/' . $t_info['vid'] . ".jpg";
            } else {
                $maxwidth = $config['img_max_width'];
                $maxheight = $config['img_max_height'];
                $fd = $thumb_folder . "/" . $fc . "_" . $t_info['vid'] . ".jpg";
            }

            if ($debug) {
                echo "<p>$fd</p>";
            }

            $source_image = $output_folder . "/00000002.jpg";

            if (! file_exists($source_image)) {
                $source_image = $output_folder . "/00000001.jpg";
            }

            if (! file_exists($source_image)) {
                $source_image = VSHARE_DIR . "/themes/default/images/no_thumbnail.gif";
            }

            Image::createThumb($source_image, $fd, $maxwidth, $maxheight);

            $fc ++;

            if ($fc == 4) {
                break;
            }
        }

        if (file_exists($output_folder . "/00000001.jpg")) {
            unlink($output_folder . "/00000001.jpg");
        } if (file_exists($output_folder . "/00000002.jpg")) {
            unlink($output_folder . "/00000002.jpg");
        }

        rmdir($output_folder);
    }
}
