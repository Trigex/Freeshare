{if $err eq ""}
    <img src="{$video_thumb_url}/thumb/{$video_folder}{$smarty.get.id}.jpg" alt="video thumb" /><br />
    <img src="{$video_thumb_url}/thumb/{$video_folder}1_{$smarty.get.id}.jpg" alt="video thumb" /><br />
    <img src="{$video_thumb_url}/thumb/{$video_folder}2_{$smarty.get.id}.jpg" alt="video thumb" /><br />
    <img src="{$video_thumb_url}/thumb/{$video_folder}3_{$smarty.get.id}.jpg" alt="video thumb" /><br />

    {if isset($debug_log)}
    <div class="well">{$debug_log}</div>
    {/if}

{/if}