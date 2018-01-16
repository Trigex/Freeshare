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

require './include/config.php';

$qid = $_SERVER['argv'][1];
write_log("Starting Background video conversion - $qid");
$video_id = Upload::processVideo($qid, 0);
write_log("End of Background video conversion - $qid");
DB::close();
