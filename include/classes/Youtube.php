<?php

class Youtube
{
    public static function getFlvUrl($url)
    {
        $content = file_get_contents($url);

        if (preg_match('/"video_id": "(.*?)"/', $content, $match) && preg_match('/"t": "(.*?)"/', $content, $match1)) {
            $url = "http://www.youtube.com/get_video?video_id=" . $match[1] . "&t=" . $match1[1];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $cookie_name = md5(rand() . time());
            $cookiefile = VSHARE_DIR . '/templates_c/' . $cookie_name;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
            $data = curl_exec($ch);

            unlink($cookiefile);

            if (preg_match('/Location: (.*?)[\r\n]+/', $data, $match) || preg_match('/http-equiv=\'Refresh\' content=\'[0-9]+;url=(.*?)\'/s', $data, $match)) {
                return $match[1];
            }
        } else {
            echo "<p>failed to find youtube video url.</p>";
            exit();
        }
    }

    public static function getVideos($search_string, $max_results, $page = '')
    {
        $search_string = urlencode($search_string);
        $youtube_api_key = Config::get('youtube_api_key');
        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . $search_string . '&type=video&key=' . $youtube_api_key . '&videoEmbeddable=true&maxResults=' . $max_results . '&order=relevance&pageToken=' . $page;
        $contents = self::getContents($url);
        $contents = json_decode($contents, true);

        $videos = array();
        $videos['total'] = $contents['pageInfo']['totalResults'];
        $videos['next_page'] = isset($contents['nextPageToken']) ? $contents['nextPageToken'] : '';
        $videos['prev_page'] = isset($contents['prevPageToken']) ? $contents['prevPageToken'] : '';
        $videos['videos'] = array();

        foreach ($contents['items'] as $key => $item) {
            $videoId = '';
            if (isset($item['id']['videoId'])) {
                $videoId = $item['id']['videoId'];
            } else if (isset($item['snippet']['resourceId']['videoId'])) {
                $videoId = $item['snippet']['resourceId']['videoId'];
            }
            if ($videoId == '') continue;

            $video['video_id'] = $videoId;
            $video['thumb_url'] = $item['snippet']['thumbnails']['medium']['url'];
            $video['video_title'] = $item['snippet']['title'];
            $video['video_title'] = htmlspecialchars($video['video_title'], ENT_QUOTES, 'UTF-8');
            $video['video_description'] = $item['snippet']['description'];
            $video['video_description'] = htmlspecialchars($video['video_description'], ENT_QUOTES, 'UTF-8');
            $video['video_duration'] = self::getVideoDuration($videoId);
            $video['video_length'] = sec2hms($video['video_duration']);
            $video['imported'] = BulkImport::checkImported($video['video_id'], 'youtube');
            $videos['videos'][] = $video;
        }

        return $videos;
    }

    public static function getVideoDuration($id)
    {
        $youtube_api_key = Config::get('youtube_api_key');
        $url = 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=' . $id . '&key=' . $youtube_api_key;
        $contents = self::getContents($url);
        $contents = json_decode($contents, true);
        $video_info = $contents['items'][0];

        $duration_text = $video_info['contentDetails']['duration'];
        $duration_text_arr = preg_split('/[A-Z]+/', $duration_text);
        $duration_text_arr = array_filter($duration_text_arr, 'strlen');
        $duration_text_arr_count = count($duration_text_arr);

        if ($duration_text_arr_count == 3) {
            $seconds = ($duration_text_arr[1] * 3600);
            $seconds += $duration_text_arr[2] * 60;
            $seconds += $duration_text_arr[3];
        } else if ($duration_text_arr_count == 2) {
            $seconds = $duration_text_arr[1] * 60;
            $seconds += $duration_text_arr[2];
        } else {
            $seconds = $duration_text_arr[1];
        }
        return $seconds;
    }

    public static function getVideoInfo($id)
    {
        $youtube_api_key = Config::get('youtube_api_key');
        $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $id . '&key=' . $youtube_api_key;
        $contents = self::getContents($url);
        $contents = json_decode($contents, true);
        $item = $contents['items'][0];

        $video = array();
        $video['video_id'] = $id;
        $video['thumb_url'] = $item['snippet']['thumbnails']['medium']['url'];
        $video['video_title'] = $item['snippet']['title'];
        $video['video_title'] = htmlspecialchars($video['video_title'], ENT_QUOTES, 'UTF-8');
        $video['video_description'] = $item['snippet']['description'];
        $video['video_description'] = htmlspecialchars($video['video_description'], ENT_QUOTES, 'UTF-8');
        $video['video_keywords'] = '';
        $video['video_duration'] = self::getVideoDuration($video['video_id']);
        $video['video_length'] = sec2hms($video['video_duration']);
        return $video;
    }

    public static function getContents($url)
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $data = curl_exec($ch);
            $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($return_code != 200 && $return_code != 302 && $return_code != 304) {
                exit($return_code . ': Invalid url');
            }
        } else {
            $data = file_get_contents($url);
        }

        return $data;
    }

}
