<h4>Current Poll Result</h4>

{section name=i loop=$poll_info}
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="{$poll_info[i].percentage}" aria-valuemin="0" aria-valuemax="100" style="width: {$poll_info[i].percentage}%;">
            <span class="text-nowrap text-shadow">
                &nbsp;&nbsp;<strong>{$poll_info[i].answer} {$poll_info[i].percentage}%</strong>
            </span>
        </div>
    </div>
{/section}
