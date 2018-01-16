{literal}

<script type="text/javascript">

$(function(){
    var selected = 0;
    $("#local_videos_checkbox").click(function(){
        if (selected == 0) {
            $("input[rel=local_videos]").prop("checked", true);
            selected = 1;
        } else {
            $("input[rel=local_videos]").prop("checked", false);
            selected = 0;
        }
    });
});

function validate()
{
	var j = 0;
	var elms = document.frm.elements.length;

	for (var i = 0;i < elms;i++) {
		if ( document.frm.elements[i].checked == true) {
			j = 1;
		}
	}

	if (j == 0) {
		alert('Please select atleast one file to move.');
		return false;
	} else if ( document.frm.server.value == '') {
		alert('Please select server.');
		return false;
	} else if (j == 1) {
		document.frm.submit();
	}
}
</script>

{/literal}

<h1>Local Videos ({$total})</h1>

{if $total gt 0}

<form method="post" name="frm" id="frm" action="video_local_move.php">

<table class="table table-striped table-hover">

<tr>
<td width="10%">
	<b>ID</b>
	<a href="video_local.php?sort=video_id+asc&page={$page}">
		<span class="glyphicon glyphicon-arrow-up"></span>
	</a>
	<a href="video_local.php?sort=video_id+desc&page={$page}">
		<span class="glyphicon glyphicon-arrow-down"></span>
	</a>
</td>

<td>
	<b>Title</b>
	<a href="video_local.php?sort=video_title+asc&page={$page}">
		<span class="glyphicon glyphicon-arrow-up"></span>
	</a>
	<a href="video_local.php?sort=video_title+desc&page={$page}">
		<span class="glyphicon glyphicon-arrow-down"></span>
	</a>
</td>
<td width="10%">
	<b>Type</b>
	<a href="video_local.php?sort=video_type+asc&page={$page}">
		<span class="glyphicon glyphicon-arrow-up"></span>
	</a>
	<a href="video_local.php?sort=video_type+desc&page={$page}">
		<span class="glyphicon glyphicon-arrow-down"></span>
	</a>
</td>
<td width="15%">
	<b>Duration</b>
	<a href="video_local.php?sort=video_duration+asc&page={$page}">
		<span class="glyphicon glyphicon-arrow-up"></span>
	</a>
	<a href="video_local.php?sort=video_duration+desc&page={$page}">
		<span class="glyphicon glyphicon-arrow-down"></span>
	</a>
</td>
<td width="10%">
	<b>Date</b>
	<a href="video_local.php?sort=video_add_date+asc&page={$page}">
		<span class="glyphicon glyphicon-arrow-up"></span>
	</a>
	<a href="video_local.php?sort=video_add_date+desc&page={$page}">
		<span class="glyphicon glyphicon-arrow-down"></span>
	</a>
</td>

<td><input type="checkbox" id="local_videos_checkbox" name="local_video_checkbox" value="1" /></td>

</tr>

{foreach from=$videos_local_all item=video_local}

<tr>
	<td>{$video_local.video_id}</td>
	<td><a href="video_details.php?a={$a}&id={$video_local.video_id}&page={$page}">{$video_local.video_title}</a></td>
	<td align="center">{$video_local.video_type}</td>
	<td align="center">{$video_local.video_length}</td>
	<td align="center">{$video_local.video_add_date|date_format}</td>
    <td><input type="checkbox" name="local_videos[]" rel="local_videos" value="{$video_local.video_id}" /></td>
</tr>

{/foreach}

</table>

<div class="row">
    <div class="col-md-8">{$links}</div>
    <div class="col-md-4">
        <select class="form-control" name="server">
            <option value=''> - - Select Server - - - -</option>
            {section name=i loop=$servers}
            <option value="{$servers[i].id}">
                {$servers[i].url}
                {if $servers[i].server_type eq 0}
                    (VIDEO SERVER)
                {elseif $servers[i].server_type eq 2}
                    (SECDOWNLOAD)
                {/if}
            </option>
            {/section}
        </select>
        <input type="submit" name="submit" value="Move" onclick="return validate();" class="btn btn-default btn-lg" />
    </div>
</div>



</form>
{else}
	<center>There is no video found.</center>
{/if}
