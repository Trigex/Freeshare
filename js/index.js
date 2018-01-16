$(function(){
    $('div.home-video-box').hover(function(){
        $(this).addClass('home-video-box-hover');
    }, function(){
        $(this).removeClass('home-video-box-hover');
    });
    display_recently_watched();
});

function display_recently_watched()
{
    var flashvars = {
        xml_path: baseurl + "/recent_viewed_xml.php",
        title: "Videos being watched right now..."
    };
    var params = {
        menu: "false",
        wmode:"opaque",
        bgcolor: recently_played_bg
    };
    var attributes = {
      id: "vshare-swf",
      name: "vshare-swf"
    };
    swfobject.embedSWF(baseurl+"/player/recent.swf", "flash_recent_videos", "650", "160", "9.0.0",false, flashvars, params, attributes);
}
