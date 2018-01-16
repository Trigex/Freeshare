<?php

$displayheight = $config['player_height'] - 20;

if ($vshare_player == "StrobeMediaPlayback")
{
    $vshare_player = <<<EOT
    <p id="vshare_player">
       <a href="http://www.adobe.com/go/getflashplayer">
           <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
       </a>
   </p>
   <script src="{$config['baseurl']}/player/swfobject.js"></script>
   <script src="{$config['baseurl']}/player/jquery.strobemediaplayback.js"></script>
   <script type="text/javascript">
   var parameterNames = new Array();
   var parameters =
   {   id: "1"
   ,   src: "{$file}"
   ,   src_title: "VSHARE : Title"
   ,   autoPlay: "{$config['player_autostart']}"
   ,   width: "{$config['player_width']}"
   ,   height: "{$displayheight}"
   ,   controlBarAutoHide: "false"
   ,   controlBarPosition: "bottom"
   ,   poster: "{$video_thumb_url}/thumb/{$video_folder}{$video_id}.jpg"
   ,   plugin_youtube: "{$config['baseurl']}/player/YouTubePlugin.swf"
   };

   for (var i=0; i<parameterNames.length; i++)
   {
   var parameterName = parameterNames[i];
   parameters[parameterName] = parameters[parameterName];
   }

   swfobject.embedSWF
   ( "{$config['baseurl']}/player/StrobeMediaPlayback.swf"
   , "vshare_player"
   , parameters["width"], parameters["height"]
   , "10.0.0"
   , {}
   , parameters
   , { allowFullScreen: "true" }
   , { name: "StrobeMediaPlayback" }
   );
   </script>

EOT;

} else if ($vshare_player == 'videojs') {

    $vshare_player = <<<EOT
<link href="{$config['baseurl']}/css/video-js.css" rel="stylesheet">
<script src="{$config['baseurl']}/js/video.js"></script>
<script src="{$config['baseurl']}/js/videojs.watermark.js"></script>
<video id="vshare_player" class="video-js vjs-big-play-centered vjs-16-9" controls preload="auto" width="100%" poster="{$video_thumb_url}/thumb/{$video_folder}{$video_id}.jpg" data-setup='{ "plugins": { "watermark": { "file": "{$config['watermark_image_url']}", "xpos": "500", "ypos": "50", "clickable": "true", "url": "{$config["watermark_url"]}" } } }'>
    <source src="{$file}" type='video/mp4'>
    <p class="vjs-no-js">
        To view this video please enable JavaScript, and consider upgrading to a web browser that
        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
</video>
EOT;

}
else
{
$vshare_player = <<<EOT

<script type="text/javascript" src="{$config['baseurl']}/player/jwplayer.js"></script>

<p id="vshare_player">
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
</p>

<script type="text/javascript">
jwplayer("vshare_player").setup({
    file: "{$file}",
    image: "{$video_thumb_url}/thumb/{$video_folder}{$video_id}.jpg",
    logo: {
        file: "{$config['watermark_image_url']}",
        link: "{$config["watermark_url"]}"
    },
    width: "100%",
    aspectratio: "16:9",
    autostart: "{$config['player_autostart']}",
    bufferlength: "{$config['player_bufferlength']}"
});
</script>

EOT;

}
