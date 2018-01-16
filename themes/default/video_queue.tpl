{if $video_info|@count gt '0'}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4>
                Quicklists({$video_info|@count})
                <a class="btn btn-danger btn-xs col-md-offset-1" id="ql_remove_all" href="javascript:void(0);">Remove all</a>
                <a class="btn btn-default btn-xs pull-right queue-btn-toggle" href="#collapseQueue" data-toggle="collapse" aria-expanded="false" aria-controls="collapseQueue">
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="glyphicon glyphicon-minus" style="display: none;"></span>
                </a>
            </h4>
        </div>
        <div class="panel-body collapse" id="collapseQueue">
            {section name=i loop=$video_info}
                <div id="div_{$video_info[i].video_id}">
                    <div class="col-md-5 col-sm-5">
                        <div class="row">
                            <div class="thumbnail">
                                <div class="preview">
                                    <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/" style="position: relative;">
                                        <img class="img-responsive" src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}/1_{$video_info[i].video_id}.jpg" width="100%">
                                    </a>
                                    <span class="badge video-time">{$video_info[i].video_length}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <h6>
                            <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">{$video_info[i].video_title|truncate:50}</a>
                        </h6>
                        <a class="text-danger pull-right" rel="ql_remove" id="{$video_info[i].video_id}" href="javascript:void(0);" title="Remove">
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        </a>
                        <p class="text-muted small">
                            {$video_info[i].video_view_number} views |
                            {$video_info[i].video_com_num} comments
                        </p>
                   </div>
               </div>
               <div class="clearfix"></div>
               <hr>
            {/section}
        </div>
    </div>
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
$('#collapseQueue').on('show.bs.collapse', function () {
    $.COOKIE('show', 1);
    $(".queue-btn-toggle").children("span:last").show();
    $(".queue-btn-toggle").children("span:first").hide();
});
$('#collapseQueue').on('hide.bs.collapse', function () {
    $.COOKIE('show', '');
    $(".queue-btn-toggle").children("span:last").hide();
    $(".queue-btn-toggle").children("span:first").show();
});

$("div.quicklist_box a#ql_remove_all").click(function(){
   $.COOKIE('video_queue', '');
   video_queue_display();
});

$("div.quicklist_box a[rel=ql_remove]").each(function(){
   $(this).click(function(){
       var box = $(this).attr("id");
       $("div#div_" + box).remove();

       var sUrl = baseurl + "/ajax/video_queue_remove.php?id=" + box;
        $.ajax({
            type: "GET",
            url: sUrl,
            dataType: 'html',
            success: function(html){
               video_queue_display();
            }
        });
   });
});
});
</script>
{/literal}

{/if}
