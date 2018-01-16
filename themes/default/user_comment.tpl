{if $profile_comments ne ''}
    {section name = i loop=$profile_comments}
        {insert name=voter_name assign=name id=$profile_comments[i].profile_comment_posted_by}
        <div id="cid-{$profile_comments[i].profile_comment_id}" class="comment">
            <div class="media">
                <div class="media-left">
                    <a href="{$base_url}/{$name.name}">
                        {insert name=member_img UID=$profile_comments[i].profile_comment_posted_by type=1}
                    </a>
                </div>
                <div class="media-body">
                    <h5 class="media-heading">
                        <strong><a href="{$base_url}/{$name.name}">{$name.name}</a></strong>
                        <small>on {$profile_comments[i].profile_comment_date|date_format}</small>
                        {if $smarty.session.UID eq $profile_comments[i].profile_comment_user_id}
                            <a class="pull-right text-danger text-muted" id="btn-com-del-cid-{$profile_comments[i].profile_comment_id}" href="javascript:void(0)" onclick="delete_comment('{$profile_comments[i].profile_comment_id}')" style="display: none;" title="Delete">
                                <span class="glyphicon glyphicon-remove-circle"></span>
                            </a>
                        {/if}
                    </h5>
                    <p>{$profile_comments[i].profile_comment_text}</p>
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

    {if $page_links ne ""}
        <div>{$page_links}</div>
    {/if}

{else}

<div id="no-user-comments">
    No Comments
</div>

{/if}