{if isset($view.episode_info)}
<table class="table">
    <tbody>
        {foreach $view.episode_videos as $video}
        <tr>
            <td>
                <a href="{$base_url}/view/{$video.video_id}/{$video.video_seo_name}/">{$video.video_title|truncate:80:"...":true}</a>
                <div class="pull-right">
                    <a href="{$base_url}/view/{$video.video_id}/{$video.video_seo_name}/" class="btn {if $view.video_info.video_id eq $video.video_id}btn-primary{else}btn-default{/if} btn-sm">Play Movie</a>
                </div>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{/if}