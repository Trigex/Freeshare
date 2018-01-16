<?php

require '../include/config.php';
require '../include/class.file.php';

$dir = VSHARE_DIR . '/photo/';

if (! is_dir($dir))
{
    echo "<p>$dir is  is NOT a directory</p>";
    exit();
}

$dh = opendir($dir);

if (! $dh)
{
    echo 'Unable to open folder';
    exit();
}

while (($file = readdir($dh)) !== false)
{

    if (is_file($dir . $file))
    {
        $file_extn = File::get_extension($file);
        if ($file_extn == 'jpg')
        {
            $size = getimagesize($dir . $file);

            if ($size[0] > 121 || $size[1] > 91)
            {
                echo '<p>Resizing image : ' . $file . '</p>';

                $user_id = str_replace('.jpg', '', $file);

                $location_photo = VSHARE_DIR . '/photo/' . $user_id . '.jpg';
                $location_avatar = VSHARE_DIR . '/photo/1_' . $user_id . '.jpg';

                $current_file = $dir . $file;
                $file_tmp_name = $dir . $user_id . '_tmp.jpg';
                rename($current_file, $file_tmp_name);

                Image::createThumb($file_tmp_name, $location_photo, $config['img_max_width'], $config['img_max_height']);
                Image::createThumb($file_tmp_name, $location_avatar, 50, 40);
                unlink($file_tmp_name);
            }
        }
    }
}

closedir($dh);

