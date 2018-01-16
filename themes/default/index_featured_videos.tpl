
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span> <strong>Today's Featured Videos</strong> <span class="pull-right">
        <a href="{$base_url}/featured/"> <span class="glyphicon glyphicon-plus"></span> More</a></span></h3>
    </div>
    <div class="panel-body">
        <div class="video-block">
            <div class="row">
            {section name=i loop=$featured_videos}
                {section name=i loop=$featured_videos}
                    {include file="videos_grid_view.tpl" video_info=$featured_videos[i]}
                {sectionelse}
                    <br>
                    <center><h4>There are no videos found.</h4></center>
                {/section}
            {/section}
            </div>
        </div>
    </div>
</div>