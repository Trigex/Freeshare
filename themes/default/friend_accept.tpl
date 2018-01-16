{if $AID ne ""}
    <div class="col-md-12">
        <div class="page-header">
            <h1>Friend Invitation from <strong>{$user_name}</strong></h1>
        </div>
        <p class="lead text-muted">Accept this invitation if you know this user and wish to share videos with each other.</p>
		<p>User: <strong><a href="{$base_url}/{$user_name}">{$user_name}</a></strong></p>

        <div class="col-md-2">
            <form action="{$base_url}/friend_accept.php" method="post">
                <input type="hidden" value="{$id}" name="id">
                <input type="hidden" value="{$AID}" name="AID">
                <button type="submit" name="friend_accept" class="btn btn-default btn-lg">Accept Invitation</button>
            </form>
        </div>
        <div class="col-md-2">
            <form onsubmit="return confirm('Are you sure you want to deny this friend request?');" action="{$base_url}/friend_accept.php" method="post">
                <input type="hidden" value="{$id}" name="id">
                <input type="hidden" value="{$AID}" name="AID">
                <button type="submit" name="friend_deny" class="btn btn-default btn-lg">No thanks</button>
            </form>
        </div>
    </div>
{/if}