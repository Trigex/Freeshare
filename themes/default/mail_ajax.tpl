<div class="page-header">
    <h2>{$mail_folder|capitalize}</h2>
</div>

<table class="table table-striped">
    <thead>
	    {if $mails|@count gt "0"}
		    <tr class="bg2">
		        <th width="5%">&nbsp;</th>
		        <th width="20%">{if $mail_folder eq 'inbox'}From{else}To{/if}</th>
		        <th width="">Subject</th>
		        <th width="15%">Date</th>
		    </tr>
	    {/if}
    </thead>

    <tbody>
	    {section name=i loop=$mails}
	        <tr rel="mail-list" valign="top">
	            <td align="center">
	                <input type="checkbox" name="mid[]" value="{$mails[i].mail_id}" />
	            </td>
                <td align="left">
                    {if $mail_folder eq 'inbox'}
                        <a href="{$base_url}/{$mails[i].mail_sender}">{$mails[i].mail_sender}
                    {else}
                        <a href="{$base_url}/{$mails[i].mail_receiver}">{$mails[i].mail_receiver}
                    {/if}

	                    <div rel="mail-detail" class="thumbnail" id="mail-photo-{$mails[i].mail_id}" style="display: none;">
	                        {insert name=member_img UID=$mails[i].user_id}
	                    </div>
                    </a>
                </td>
	            <td align="left">
	                <a href="javascript:void(0);" onclick="mail.detail('{$mails[i].mail_id}', '{$mail_folder}', '{$mails[i].mail_read}');">
	                    {if $mails[i].mail_read == "0" AND $mail_folder eq 'inbox'}
                            <strong>{$mails[i].mail_subject}</strong>
                        {else}
                            {$mails[i].mail_subject}
                        {/if}
	                </a>
	                <div rel="mail-detail" id="mail-body-{$mails[i].mail_id}" style="display: none;">
                        <br>
                        <p>{$mails[i].mail_body}</p>
                    </div>

	                {if $mail_folder ne 'outbox'}
                        <p rel="mail-detail" id="mail-reply-{$mails[i].mail_id}" style="display: none;">
                            <a class="btn btn-default btn-sm" id="mail-reply-bttn" href="javascript:void(0);" onclick="mail.compose('{$mails[i].mail_sender}','Re: {$mails[i].mail_subject}');">Reply</a>
                        </p>
                    {/if}
	            </td>
	            <td align="left">
	                {$mails[i].mail_date}
	            </td>
	        </tr>
	    {sectionelse}
	        <tr>
	            <td colspan="4" align="center">
                    <h4>There are no messages in this folder.</h4>
                </td>
	        </tr>
	    {/section}
    </tbody>

    {if $mails|@count gt "0"}
	    <tr>
	        <td align="center">
                <input type="checkbox" name="select_all" id="select_all">
            </td>
	        <td align="left">
                <button type="button" class="btn btn-default btn-sm" id="del-mails" onclick="mail.del('{$mail_folder}');" title="Delete">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </td>
	        <td align="right" colspan="2">
                {if $page_link ne ''}{$page_link}{else}&nbsp;{/if}
            </td>
	    </tr>
    {/if}
</table>

{literal}
<script type="text/javascript">
$(function(){
	$("#select_all").click(function(){
		var checked_status = this.checked;
		$("input[name='mid[]']").each(function(){
			this.checked = checked_status;
		});
	});
});
mail.rowcolor();
</script>
{/literal}