{section name=i loop=$comments}
    <div class="comment" id="{$comments[i].comment_id}">
        <div class="media">
            <div class="media-left">
                <a href="{$base_url}/{$comments[i].user_name}">
                    {insert name=member_img UID=$comments[i].comment_user_id type=1}
                </a>
            </div>
            <div class="media-body">
                {insert name=time_range assign=comment_time time=$comments[i].comment_add_time}
                <h5 class="media-heading">
                    <strong>
                        <a href="{$base_url}/{$comments[i].user_name}">{$comments[i].user_name}</a>
                    </strong>
                    <small>{$comment_time}</small>
                    {if $smarty.session.UID ne '' && $smarty.session.UID eq $comments[i].video_user_id}
                        <a href="javascript:void(0);" class="pull-right text-danger text-muted" id="btn-com-del-{$comments[i].comment_id}" onclick="video_comment_delete('{$video_id}', '{$comments[i].comment_id}');" title="Delete" style="display: none;">
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        </a>
                    {/if}
                </h5>
                <p>{$comments[i].comment_text}</p>
            </div>
        </div>
    </div>
    <hr>
{/section}
<script>
$(".comment .media-left img").removeClass("preview").addClass("media-object");
$(".comment").hover(function(){
    $("a#btn-com-del-" + $(this).attr("id")).toggle();
});
</script>

{if $links ne ''}
    <div class="comment_pagination_block" align="right">
        {$links}
    </div>
{else}
    <br />
{/if}