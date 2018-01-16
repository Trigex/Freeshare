<div class="col-md-12">
    {if $err ne ""}
        <div class="alert alert-danger" role="alert">{$err}</div>
    {/if}

    {if $msg ne ""}
        <div class="alert alert-success" role="alert">{$msg}</div>
    {/if}
</div>