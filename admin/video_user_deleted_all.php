<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: 3.2
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'admin_config.php';
require '../include/config.php';

Admin::auth();

$num_videos_per_refresh = 10;

$sql = "SELECT * FROM `videos` WHERE
	   `video_user_id`=0
	    ORDER BY `video_id` ASC
	    LIMIT $num_videos_per_refresh";
$deleted_videos_all = DB::fetch($sql);

if ($deleted_videos_all) {

    foreach ($deleted_videos_all as $deleted_video) {
        Video::delete($deleted_video['video_id'], $deleted_video['video_user_id'], 1);
    }

    echo "<script language=\"JavaScript\">
         <!--
         var randomnumber = Math.random() * 1000000;
         document.write('Files Deleting...');
         setTimeout('window.location.href = \"?x=' + randomnumber + '\"',2000);
         -->
         </script>";
} else {
    echo "All Files Deleted.";
}
