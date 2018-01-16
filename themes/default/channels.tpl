<div class="col-md-12">
<div class="page-header">
    <h1>All Channels</h1>
</div>

<div class="row">
    {section name=i loop=$channels}
    <div class="col-orient-ls col-sm-6 col-md-3 channel">
        <div class="thumbnail">
            <div class="preview">
                <a href="{$base_url}/channel/{$channels[i].channel_id}/{$channels[i].channel_seo_name}/">
                    <img class="img-responsive" width="100%" height="130" src="{$base_url}/chimg/{$channels[i].channel_id}.jpg" alt="channel">
                    <h5>
                        {$channels[i].channel_name_html}
                    </h5>
                </a>
            </div>

            <div class="caption">
                <p class="text-muted small">{$channels[i].channel_description|truncate:40} </p>
                {insert name=channel_count assign=infoch cid=$channels[i].channel_id}
                <p class="text-muted small">
                    <span class="glyphicon glyphicon-facetime-video"></span>
                    &nbsp;Today: <strong>{$infoch[0]}</strong> | Total: <strong>{$infoch[1]}</strong>
                </p>
                <p class="text-muted small">
                    <span class="glyphicon glyphicon-globe"></span>
                    Groups: <strong>{$infoch[2]}</strong>
                </p>
            </div>
        </div>
    </div>
    {/section}
</div>
</div>