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

require 'include/config.php';
require 'include/language/' . LANG . '/lang_playlist.php';

User::is_logged_in();

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$redirect_url = VSHARE_URL . '/' . $_SESSION['USERNAME'] . '/playlist/' . $page;

$playlist_id = isset($_GET['pl_id']) ? $_GET['pl_id'] : '';

if ($playlist_id == '')
{
    DB::close();
    Http::redirect($redirect_url);
}

if (isset($_GET['action']))
{
    if ($_GET['action'] == "vdo_del" )
    {
        $sql = "SELECT * FROM `playlists` WHERE
               `playlist_id`='" . (int) $playlist_id . "' AND
               `playlist_user_id`='" . (int) $_SESSION['UID'] . "'";
        $playlist_info = DB::fetch1($sql);

        if ($playlist_info)
        {
            $sql = "DELETE FROM `playlists_videos` WHERE
	               `playlists_videos_playlist_id`='" . (int) $playlist_info['playlist_id'] . "' AND
	               `playlists_videos_video_id`='" . (int) $_GET['vid'] . "'";
	        DB::query($sql);

	        set_message($lang['video_removed'], 'success');
	        $redirect_url = VSHARE_URL . '/' . $_SESSION['USERNAME'] . '/playlist/' . $playlist_info['playlist_name'] . '/' . $page;
        }
    }
    else if ($_GET['action'] == "pl_del")
    {
        $sql = "SELECT * FROM `playlists` WHERE
               `playlist_id`='" . (int) $playlist_id . "' AND
               `playlist_user_id`='" . (int) $_SESSION['UID'] . "'";
        $playlist_info = DB::fetch1($sql);

        if ($playlist_info)
        {
	        $sql = "DELETE FROM `playlists_videos` WHERE
	               `playlists_videos_playlist_id`='" . (int) $playlist_id . "'";
	        DB::query($sql);

	        $sql = "DELETE FROM `playlists` WHERE
	               `playlist_user_id`='" . (int) $_SESSION['UID'] . "' AND
	               `playlist_id`='" . (int) $playlist_id . "'";
	        DB::query($sql);

	        set_message($lang['playlist_deleted'], 'success');
        }
    }
}

DB::close();
Http::redirect($redirect_url);
