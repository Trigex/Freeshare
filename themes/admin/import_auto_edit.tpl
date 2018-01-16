<h1>Edit Auto Import</h1>

<form method="post" action="" id="auto-import" name="auto-import">

	 <div>
        <label for="video_keywords">Keyword:</label>
        <input type="text" name="video_keywords" id="video_keywords" value="{$import_auto_info.import_auto_keywords}" />
    </div>
	
	 <div>
        <label for="video_user_name">Video added to:</label>
        <input type="text" name="video_user_name" id="video_user_name" value="{$import_auto_info.import_auto_user}" />
    </div>
	
	 <div>
        <label for="video_channel" >Channels:</label>
        <select name="video_channel">
            <option value="">-----------SELECT-----------</option>
            {section name=i loop=$channel_info} 
				<option value="{$channel_info[i].channel_id}" {if $import_auto_info.import_auto_channel eq $channel_info[i].channel_id} selected='selected'{/if}>{$channel_info[i].channel_name}</option>
			{/section} 
        </select>
    </div>
	
	<div>
        <label for="import_auto_download">Import Method:</label>
        <select name="import_auto_download" id="import_auto_download"> 
			<option value="">------Select---------</option> 
			<option value="0" {if $import_auto_info.import_auto_download eq '0'}selected='selected'{/if}>Embed</option>
            <option value="1" {if $import_auto_info.import_auto_download eq '1'}selected='selected'{/if}>Download</option>
		</select>
    </div>
	
	<div class="submit">
		<input type="hidden" name="import_auto_id" value="{$import_auto_info.import_auto_id}">
		<input type="submit" name="submit" value="Edit"/>
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