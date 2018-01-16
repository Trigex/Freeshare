<div class="page-header">
    <h1>Auto Import</h1>
</div>

{if $import_auto_info ne ''}

<table class="table table-striped table-hover">

    <tr>
        <td><b>Keywords</b></td>
        <td><b>User</b></td>
        <td><b>Import Method</b></td>
        <td><b>Action</b></td>
    </tr>

    {section name=i loop=$import_auto_info}
        <tr>
            <td>
                {$import_auto_info[i].import_auto_keywords}
            </td>
            <td>
                <a href="{$base_url}/admin/user_search.php?user_name={$import_auto_info[i].import_auto_user}">{$import_auto_info[i].import_auto_user}</a>
            </td>
            <td>
                {if $import_auto_info[i].import_auto_download eq '0'}Embed{else}Download{/if}
            </td>
            <td>
                <a href="{$base_url}/admin/import_auto_delete.php?id={$import_auto_info[i].import_auto_id}">Delete</a>
                |<a href="{$base_url}/admin/import_auto_edit.php?id={$import_auto_info[i].import_auto_id}">Edit</a>
            </td>
        </tr>
    {/section}
</table>

<div>&nbsp;</div>

{/if}

<form method="post" action="" id="auto-import" name="auto-import">

    <div>
        <label for="video_keywords">Keyword:</label>
        <input type="text" name="video_keywords" id="video_keywords" value="{$video_keywords}" />
    </div>

    <div>
        <label for="video_user_name">Video added to:</label>
        <input type="text" name="video_user_name" id="video_user_name" value="{$video_user_name}" />
    </div>

    <div>
        <label for="video_channel" >Channels:</label>
        <select name="video_channel">
            <option value="">-----------SELECT-----------</option>
            {section name=i loop=$channel_info}
            <option value="{$channel_info[i].channel_id}"{if $video_channel eq $channel_info[i].channel_id} selected="selected"{/if}>{$channel_info[i].channel_name}</option>
            {/section}
        </select>
    </div>

    <div>
        <label for="import_auto_download">Import Method:</label>
        <select name="import_auto_download" id="import_auto_download">
            <option value="">------Select---------</option>
            <option value="0"{if $import_auto_download eq 0} selected="selected"{/if}>Embed</option>
            <option value="1"{if $import_auto_download eq 1} selected="selected"{/if}>Download</option>
        </select>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Save" />
    </div>

</form>

<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/admin_import_auto.js"></script>

{literal}
<script type="text/javascript">
    $(function(){
        validate_import_auto_form();
    });
</script>
{/literal}
