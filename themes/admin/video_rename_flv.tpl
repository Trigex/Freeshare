{if $err eq ""}

<div class="page-header">
    <h1>Rename FLV Video</h1>
</div>

<table class="table table-striped table-hover">

<tr>
    <td>Video Id</td>
    <td>{$video_info.video_id}</td>
</tr>

<tr>
    <td>Old FLV Name</td>
    <td>{$old_name}</td>
</tr>

<tr>
    <td>New FLV Name</td>
    <td>{$new_flv_name}</td>
</tr>

<tr>
    <td>Title</td>
    <td>{$video_info.video_title}</td>
</tr>

<tr>
    <td>Type</td>
    <td>{$video_info.video_type}</td>
</tr>

</table>

<div>
    <a class="btn btn-default btn-lg" href="javascript:history.go(-1);">Go Back</a>
</div>

{/if}