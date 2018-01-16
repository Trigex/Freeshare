{if Config::get('youtube_api_key') eq ""}
    <div class="alert alert-warning">
        <span class="glyphicon glyphicon-warning-sign"></span>
        <a href="settings_miscellaneous.php#youtube_api_key"  class="alert-link">
            You need to set Youtube API Key to add youtube videos.
        </a>
    </div>
{else}

<div class="page-header">
    <h1>Bulk Import</h1>
</div>

<script language="JavaScript" type="text/javascript" src="{$base_url}/js/admin_bulk_import.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>

{if $videos eq ''}

<p>Import videos from Youtube based on keyword.</p>

<form action="" method="get" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="keyword">Keyword:</label>
        <div class="col-sm-5">
            <input class="form-control" name="keyword" id="keyword" value="{$smarty.get.keyword}" required>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="user_name">Video added to:</label>
        <div class="col-sm-5">
            <input class="form-control" name="user_name" id="user_name" value="{$smarty.get.user_name}" required>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="channel" >Channel:</label>
        <div class="col-sm-5">
            <select class="form-control" name="channel" required>
                <option value="">-----------SELECT-----------</option>
                {section name=i loop=$channels}
                    <option value="{$channels[i].channel_id}"{if $channels[i].channel_id eq $smarty.get.channel}selected="selected"{/if}>{$channels[i].channel_name_html}</option>
                {/section}
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Search</button>
        </div>
    </div>

    </fieldset>

</form>

{literal}
<script>
    $(function(){
        validate_bulk_import_search_form();
    });
</script>
{/literal}

{/if}

{if $smarty.get.keyword ne ''}

{if $videos['total'] gt '0'}

<form action="import_bulk_process.php" method="post" name="bulk_import" onsubmit="return validate_frm();" class="form-horizontal">

    {section name=i loop=$videos['videos']}
        <input type="hidden" name="video_title[{$videos['videos'][i].video_id}]" value="{$videos['videos'][i].video_title}">
        <input type="hidden" name="video_description[{$videos['videos'][i].video_id}]" value="{$videos['videos'][i].video_description}">
        <input type="hidden" name="video_keywords[{$videos['videos'][i].video_id}]" value="">
        <input type="hidden" name="video_duration[{$videos['videos'][i].video_id}]" value="{$videos['videos'][i].video_duration}">
        <input type="hidden" name="page" value="{if isset($smarty.get.page)}{$smarty.get.page}{/if}">

        <div class="media{if $videos['videos'][i].imported ne "0"} bg-success{/if}">
            <div class="media-left">
                {if $videos['videos'][i].imported eq "0"}
                <input type="checkbox" name="video_id[]" value="{$videos['videos'][i].video_id}">
                {else}
                    <img src="{$img_css_url}/default/images/tick.png" alt="imported">
                {/if}
            </div>

            <a class="media-left" href="#">
                <div class="preview">
                    <img class="media-object" src="{$videos['videos'][i].thumb_url}" alt="{$videos['videos'][i].video_title}" height="130">
                </div>
            </a>

            <div class="media-body">
                <h4 class="media-heading">{$videos['videos'][i].video_title}</h4>
                <p>{$videos['videos'][i].video_description}</p>
                <p>Duration: {$videos['videos'][i].video_length}</p>
                <button type="button" class="btn btn-info btn-show-preview" data-toggle="modal" data-id="{$videos['videos'][i].video_id}">Preview</button>
                {if $videos['videos'][i].imported ne "0"}
                    &nbsp;&nbsp;<span class="label label-success">Already Imported.</span>
                {/if}
                <div class="clearfix">&nbsp;</div>
            </div>
        </div>

    {/section}

    <input type="hidden" name="import_site" value="youtube">
    <input type="hidden" name="keyword" value="{$smarty.get.keyword}">
    <input type="hidden" name="user_name" value="{$user_name}">
    <input type="hidden" name="channel_id" value="{$channel_id}">

    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="select_all" id="select_all"> Select All
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-4">
            <select name="import_method" class="form-control">
                <option value="embed">Embed (NO space, bandwidth needed)</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-default" name="submit" value="Import Selected Videos">
        </div>
    </div>
</form>

<div class="modal fade video-preview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item video-preview-frame" width="100%" height="100%" src="" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<script>
$(".btn-show-preview").on("click", function(e){
    var youtubeVideoId = $(this).attr("data-id");
    $(".video-preview-frame").attr("src", "https://www.youtube.com/embed/" + youtubeVideoId);
    $(".video-preview").modal("toggle");
});
</script>

{/if}


<div class="row">
    <div class="col-md-12">
        <div class="btn-group btn-group-lg">
            <a href="import_bulk.php?keyword={$smarty.get.keyword}&user_name={$user_name}&channel={$channel_id}&page={$videos['prev_page']}" class="btn btn-default{if $videos['prev_page'] eq ""} disabled{/if}">Prev Page</a>
            <span class="btn btn-default disabled">Total: {$videos['total']}</span>
            <a href="import_bulk.php?keyword={$smarty.get.keyword}&user_name={$user_name}&channel={$channel_id}&page={$videos['next_page']}" class="btn btn-default{if $videos['next_page'] eq ""} disabled{/if}">Next Page</a>
        </div>
    </div>
</div>

{/if}
{/if}