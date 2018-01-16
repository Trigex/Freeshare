<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_playlist.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (! isset($_SESSION['UID'])) {
    Ajax::returnJson($lang['must_login'], 'error');
    exit(0);
}

if ($action == 'create_playlist') {
    $playlist_name = isset($_GET['playlist_name']) ? $_GET['playlist_name'] : '';

    if ($playlist_name == '') {
        Ajax::returnJson($lang['playlist_name_empty'], 'error');
        exit(0);
    } else {
        $sql = "SELECT * FROM `playlists` WHERE
               `playlist_user_id`='" . (int) $_SESSION['UID'] . "' AND
               `playlist_name`='" . DB::quote($playlist_name) . "'";
        $playlist_exists = DB::fetch($sql);

        if (! $playlist_exists) {
            $sql = "INSERT INTO `playlists` SET
                   `playlist_user_id`='" . (int) $_SESSION['UID'] . "',
                   `playlist_name`='" . DB::quote($playlist_name) . "',
                   `playlist_add_date`='" . (int) time() . "'";
            Ajax::returnJson(DB::insertGetId($sql), 'success');
        } else {
            Ajax::returnJson($lang['playlist_duplicate'], 'error');
        }
        exit(0);
    }
} else if ($action == 'show_playlist') {
    $video_id = isset($_GET['video_id']) ? (int) $_GET['video_id'] : 0;

    if ($video_id == 0) {
        $err = $lang['playlist_vid_invalid'];
        Ajax::returnJson($err, 'error');
        exit(0);
    }

    $sql = "SELECT * FROM `playlists` WHERE
           `playlist_user_id`='" . (int) $_SESSION['UID'] . "'
            ORDER BY `playlist_id` DESC";
    $user_playlists = DB::fetch($sql);

    $return = '
        <li role="presentation">
            <a role="menuitem" tabindex="-1" onclick="video_add_favorite(' . $video_id . ');">
                <span class="glyphicon glyphicon-heart"></span> Favorites
            </a>
        </li>
        <li role="presentation" class="divider"></li>';
    if (count($user_playlists)) {
        foreach ($user_playlists as $playlist) {
            $return .= '
            <li role="presentation">
                <a role="menuitem" tabindex="-1" id="' . (int) $playlist['playlist_id'] . '" rel="pl-items">
                    <span class="glyphicon glyphicon-play"></span> ' . $playlist['playlist_name'] . '
                </a>
            </li>';
        }
        $return .= '<li role="presentation" class="divider"></li>';
    }

    $return .= '
    <li role="presentation">
        <a id="create_pl" class="text-nowrap">Create new playlist</a>
        <span id="pl_txt_box" class="col-md-12" style="display: none;">
            <form id="pl-frm" action="javascript:void(0);" onsubmit="javascript:create_playlist();">
                <input type="text" name="playlist_name" id="playlist_name" class="form-control" onclick="return false;">
            </form>
        </span>
    </li>';

    $return .= '
    <script type="text/javascript">
        $("#create_pl").click(function(){
           $(this).remove();
           $("#pl_txt_box").show();
           $("#playlist_name").focus();
           return false;
        });
        $(".pl-lists a[rel=pl-items]").each(function(){
            $(this).click(function(){
                add_video_playlist($(this).attr("id"));
                return true;
            });
        });
    </script>';
    Ajax::returnJson($return, 'success');
} else if ($action == 'add_playlist_video') {

    $video_id = isset($_GET['video_id']) ? $_GET['video_id'] : '';
    $playlist_id = isset($_GET['playlist_id']) ? $_GET['playlist_id'] : '';

    if ($video_id == '') {
        $err = $lang['playlist_vid_invalid'];
    }
    if ($playlist_id == '') {
        $err = $lang['playlist_id_invalid'];
    }

    if (! empty($err)) {
        Ajax::returnJson($err, 'error');
        exit(0);
    }

        $sql = "SELECT * FROM `playlists` AS `p`, `playlists_videos` AS `pv` WHERE
                p.playlist_id='" . (int) $playlist_id . "' AND
                p.playlist_user_id='" . (int) $_SESSION['UID'] . "' AND
                p.playlist_id=pv.playlists_videos_playlist_id AND
                pv.playlists_videos_video_id='" . (int) $video_id . "'";
        $video_in_playlist = DB::fetch($sql);

        if (! $video_in_playlist) {
            $sql = "INSERT INTO `playlists_videos` SET
                   `playlists_videos_playlist_id`='" . (int) $playlist_id . "',
                   `playlists_videos_video_id`='" . (int) $video_id . "'";
            DB::query($sql);

            Ajax::returnJson($lang['playlist_video_added'], 'success');
        } else {
            Ajax::returnJson($lang['playlist_video_duplicate'], 'success');
        }
}
