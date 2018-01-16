<div class="page-header">
    <h1>Add Video to Episode</h1>
</div>

<p class="lead">{$video_info.video_title}</p>

<form method="post" action="" class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-md-2">&nbsp;</label>
        <div class="col-md-4">
            <div class="radio">
                <label>
                    <input type="radio" name="episode_new" value="no" checked> Existing Episode
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="episode_new" value="yes"> New Episode
                </label>
            </div>
        </div>
    </div>
    <div class="form-group episode-select">
        <label class="control-label col-md-2">Select Episode</label>
        <div class="col-md-4">
            <select class="form-control" name="episode_id" id="episode_id">
                <option value="">-- Select --</option>
                {foreach Episode::get() as $episode}
                <option value="{$episode.episode_id}">{$episode.episode_name}</option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="form-group episode-new hidden">
        <label class="control-label col-md-2">New Episode</label>
        <div class="col-md-4">
            <input class="form-control" name="episode_name" id="episode_name">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <input type="submit" name="submit" value="Add" class="btn btn-default btn-lg">
        </div>
    </div>
</form>

<script>
$(function(){
    var episode_new = $("input[name=episode_new]:checked").val();
    show_form_field(episode_new);
    $("input[name=episode_new]").click(function(){
        episode_new = $("input[name=episode_new]:checked").val();
        show_form_field(episode_new);
    });
    function show_form_field(episode_new) {
        if (episode_new == 'yes') {
            $(".episode-select").addClass("hidden");
            $(".episode-new").removeClass("hidden");
            $("#episode_id").prop("required", false);
            $("#episode_name").prop("required", true);
        } else {
            $(".episode-new").addClass("hidden");
            $(".episode-select").removeClass("hidden");
            $("#episode_id").prop("required", true);
            $("#episode_name").prop("required", false);
        }
    }
});
</script>