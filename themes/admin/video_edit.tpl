<div class="page-header">
    <h1>Edit Video</h1>
</div>

<form action="video_edit.php?a={$a}&video_id={$video.video_id}" method="post" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-2 control-label">Video ID:</label>
        <div class="col-sm-5">
            <p class="form-control-static">{$video.video_id}</p>
        </div>
    </div>

    {if $video.video_vtype eq "2"}

        <div class="form-group">
            <label class="col-sm-2 control-label" for="video_embed_code"> URL: </label>
            <div class="col-sm-5">
                <input class="form-control" name="video_embed_code" id="video_embed_code" value="{$video.video_embed_code}" />
            </div>
        </div>

    {elseif $video.video_vtype eq "6"}

        <div class="form-group">
            <label class="col-sm-2 control-label" for="video_embed_code">Embed:</label>{$video.video_vtype}
            <div class="col-sm-5">
                <textarea class="form-control" name="video_embed_code" id="video_embed_code" rows="3">{$video.video_embed_code}</textarea>
            </div>
        </div>

    {/if}

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_title">Title:</label>
        <div class="col-sm-5">
            <input class="form-control" name="video_title" id="video_title" value="{$video.video_title}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_description">Description:</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="video_description" id="video_description" rows="3">{$video.video_description}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_keywords">Keywords:</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="video_keywords" id="video_keywords" rows="3">{$video.video_keywords}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_duration">Duration:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="video_duration" id="video_duration" value="{$video.video_duration}" /> (<i>in second</i>)
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Channels:</label>
        <div class="col-sm-5">
            {$ch_checkbox}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_type">Type:</label>
        <div class="col-sm-5">
            <select class="form-control" name="video_type" id="video_type">{$type_box}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_featured">Is featured?:</label>
        <div class="col-sm-5">
            <select class="form-control" name="video_featured" id="video_featured">{$featured_box}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_active">Is Active ?:</label>
        <div class="col-sm-5">
            <select class="form-control" name="video_active" id="video_active">{$active_box}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_allow_comment">Can be commented ?:</label>
        <div class="col-sm-5">
            <select class="form-control" name="video_allow_comment" id="video_allow_comment">{$comment_box}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_allow_rated">Can be rated ?:</label>
        <div class="col-sm-5">
            <select class="form-control" name="video_allow_rated" id="video_allow_rated">{$rate_box}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_allow_embed">Can be embedded ?:</label>
        <div class="col-sm-5">
            <select class="form-control" name="video_allow_embed" id="video_allow_embed">{$embed_box}:</select>
        </div>
    </div>

    {if $family_filter eq "1"}
	    <div class="form-group">
	        <label class="col-sm-2 control-label" for="video_adult">Adult Video ?:</label>
            <div class="col-sm-5">
    	        <select class="form-control" name="video_adult" id="video_adult">
    	            <option value="0" {if $video.video_adult eq "0"}selected{/if}>No</option>
    	            <option value="1" {if $video.video_adult eq "1"}selected{/if}>Yes</option>
    	        </select>
            </div>
	    </div>
	{else}
        <input class="form-control" type="hidden" name="video_adult" value="0" />
    {/if}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Save</button>
        </div>
    </div>

</form>