<div id="search">
    <form method="get" action="{$base_url}/search.php">
        <p>
            <input class="text" value="{$smarty.request.search}" name="search" />
            <select name="type">
                {if $smarty.request.type eq "video"}
                    <option value="video">Search Videos</option>
                {else}
                    <option value="video">Search Videos</option>
                {/if}
                {if $smarty.request.type eq "user"}
                    <option value="user">Search Users</option>
                {else}
                    <option value="user">Search Users</option>
                {/if}
                {if $smarty.request.type eq "group"}
                    <option value="group">Search Groups</option>
                {else}
                    <option value="group">Search Groups</option>
                {/if}
            </select>
            <input type="submit" class="search-btn" value="Search" />
        </p>
    </form>
</div>
