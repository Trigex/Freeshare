<script type="text/javascript" src="{$base_url}/js/poll.js"></script>
<script>
$.get(baseurl + "/recent_viewed_html.php", function(data){
    $("#flash_recent_videos").html(data);
});
</script>