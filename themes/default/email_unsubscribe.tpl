<div class="text-center">
    {if $unsubscribed_success eq '0'}
        <h1>CONFIRM UNSUBSCRIPTION</h1>
        <p class="lead text-muted">Are you sure you want to remove from the Mailing list ?</p>

        <form method="POST" action="">
            <button type="submit" name="unsubscribe" class="btn btn-default btn-lg">Unsubscribe</button>
            <button type="submit" name="cancel" class="btn btn-default btn-lg">Cancel</button>
        </form>
    {else}
        <h4>{$unsubscribe_txt}</h4>
    {/if}
</div>