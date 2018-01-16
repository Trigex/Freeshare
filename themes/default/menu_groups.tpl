<ul class="list-inline text-center">
    <li><a href="{$base_url}/groups/featured/1">Browse Groups</a></li>
    {if $smarty.session.USERNAME ne ""}
        <li><a href="{$base_url}/{$smarty.session.USERNAME}/groups/">My Groups</a></li>
    {else}
        <li><a href="{$base_url}/login/">My Groups</a></li>
    {/if}
    <li><a href="{$base_url}/group/new/">Create Group</a></li>
</ul>