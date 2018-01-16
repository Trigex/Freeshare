<div class="page-header">
    <a class="btn btn-default pull-right btn-video-share" href="javascript:void(0)" title="Close">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <h3>Share Details</h3>
</div>
<div class="btn-group">
    <a class="btn btn-default btn-xs" href="{$base_url}/friends/recommend/{$view.video_info.video_id}/" title="Recommend Friends by E-Mail"><img src="{$baseurl}/themes/default/images/icon_mail.png" width="45" height="45" border="0" alt="Mail"></a>
    <a class="btn btn-default btn-xs" href="http://www.facebook.com/share.php?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;t={$view.video_info.video_title}" title="FaceBook" target="_blank"><img src="{$baseurl}/themes/default/images/icon_facebook.png" width="45" height="45" border="0" alt="facebook"></a>
    <a class="btn btn-default btn-xs" href="https://plus.google.com/share?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" title="Google+" target="_blank"><img src="{$baseurl}/themes/default/images/icon_google-plus.png" width="45" height="45" border="0" alt="Google+"></a>
    <a class="btn btn-default btn-xs" href="http://digg.com/submit?phase=2&amp;url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="Digg It!" target="_blank"><img src="{$baseurl}/themes/default/images/icon_digg.png" width="45" height="45" border="0" alt="digg"></a>
    <a class="btn btn-default btn-xs" href="http://del.icio.us/post?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="del.icio.us" target="_blank"><img src="{$baseurl}/themes/default/images/icon_delicious.png" width="45" height="45" border="0" alt="delicious"></a>
    <a class="btn btn-default btn-xs" href="http://newsvine.com/_tools/seed&amp;save?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;u={$view.video_info.video_title}" title="NewsVine" target="_blank"><img src="{$baseurl}/themes/default/images/icon_newsvine.png" width="45" height="45" border="0" alt="newsvine"></a>
    <a class="btn btn-default btn-xs" href="http://reddit.com/submit?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="reddit" target="_blank"><img src="{$baseurl}/themes/default/images/icon_reddit.png" width="45" height="45" border="0" alt="reddit"></a>
    <a class="btn btn-default btn-xs" href="http://simpy.com/simpy/LinkAdd.do?href={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="Simpy" target="_blank"><img src="{$baseurl}/themes/default/images/icon_simpy.png" width="45" height="45" border="0" alt="simpy"></a>
    <a class="btn btn-default btn-xs" href="http://spurl.net/spurl.php?title={$view.video_info.title}&amp;url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" title="Spurl" target="_blank"><img src="{$baseurl}/themes/default/images/icon_spurl.png" width="45" height="45" border="0" alt="spurl"></a>
    <a class="btn btn-default btn-xs" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;t={$view.video_info.video_title}" title="My Yahoo!" target="_blank"><img src="{$baseurl}/themes/default/images/icon_yahoo.png" width="45" height="45" border="0" alt="yahoo"></a>
</div>
<div class="clearfix">&nbsp;</div>
<form role="form">
    <div class="form-group">
        <label>Video URL (Permanent Link):</label>
        <input class="form-control" value="{$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" onclick="javascript:this.focus();this.select();" readonly="readonly">
    </div>
    {if $view.video_info.video_vtype eq "0" && ($view.video_info.video_type == "public" || $view.video_info.video_user_id == $smarty.session.UID)}
        {if $view.video_info.video_allow_embed eq "enabled" && $embed_show eq 1}
            <div class="form-group">
                <label>Embeddable Player:</label>
                <input class="form-control" value='{if $embed_type eq "0"}<iframe vspace="0" hspace="0" allowtransparency="true" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:0px;" width="600" height="500" SRC="{$base_url}/show.php?id={$view.video_info.video_id}"></iframe>{else}<object width="560" height="340"><param name="movie" value="{$base_url}/v/{$view.video_info.video_id}&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="{$base_url}/v/{$view.video_info.video_id}&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed></object>{/if}' onclick="javascript:this.focus();this.select();" readonly="readonly">
                <div class="help-block">(Put this video on your website. Works on Friendster, eBay, Blogger, MySpace!)</div>
            </div>
        {/if}
    {/if}
</form>