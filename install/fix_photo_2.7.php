<?php

require '../include/config.php';

$dir = VSHARE_DIR . '/photo/';

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (preg_match("/.jpg/i", $file)) {
                $user_id = str_replace('.jpg', '',$file);
                if (preg_match('/^[0123456789]+$/', $user_id)) {
                    $sql = "UPDATE `users` SET `user_photo`='1' WHERE `user_id`='" . (int) $user_id . "'";
                    DB::query($sql);
                    echo '<p>' . $sql . '</p>';
                }
            }

        }
        closedir($dh);
    }
}

echo '<h1>Finished</h1>';
