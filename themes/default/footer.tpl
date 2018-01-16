    </div> <!-- main -->

    <div class="clearfix">&nbsp;</div>

     <div class="clearfix center">
            {insert name=advertise adv_name='banner_bottom'}
        </div>

<div class="row">
    <div class="col-md-12">
        <footer class="clearfix">
            <div class="col-md-6 row">
                    <ul class="list-inline">
                    <li><a href="{$base_url}/pages/about.html">About Us</a></li>
                    <li><a href="{$base_url}/pages/help.html">Help</a></li>
                    <li><a href="{$base_url}/pages/advertise.html">Advertise</a></li>
                    <li><a href="{$base_url}/pages/terms.html">Terms of Use</a></li>
                    <li><a href="{$base_url}/pages/privacy.html">Privacy Policy</a></li>
                </ul>
                Copyright &copy; {$smarty.now|date_format:"%Y"} {$site_name}. All rights reserved.
                <!--
                REMOVING THE LINE BELOW CONSTITUTES A VIOLATION
                OF YOUR LICENSE AGREEMENT AND WILL RESULT IN
                SIGNIFICANT PENALITIES IF REMOVED.
                -->
                Powered by <a class="copy" href="https://www.buyscripts.in/vshare-youtube-clone" target="_blank">vShare</a>
            </div>

            <div class="col-md-6 row pull-right">
                <ul class="list-inline text-right">
                    {if $family_filter eq '1'}
                        <li>
                            <a class="btn btn-default btn-sm" href="{$base_url}/family_filter/">
                                <span class="glyphicon glyphicon-filter"></span> Family Filter
                                {if $smarty.session.FAMILY_FILTER eq '1'}
                                    <span class="label label-success">ON</span>
                                {else}
                                    <span class="label label-default">OFF</span>
                                {/if}
                            </a>
                        </li>
                    {/if}
                    <li>
                        <a class="btn btn-default btn-sm" href="{$base_url}/rss/new/">
                            <span class="glyphicon glyphicon-list"></span> RSS
                        </a>
                    </li>
                </ul>
            </div>
        </footer>
    </div>
</div>

</div> <!-- container -->
<div class="col-md-3 col-sm-5 quicklist_box" id="quicklist_box"></div>
<script src="{$base_url}/js/bootstrap.min.js"></script>
</body>
</html>
<script language="JavaScript" type="text/javascript">
var baseurl='{$base_url}';
</script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/vshare.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/video_queue.js"></script>
{$html_extra}
