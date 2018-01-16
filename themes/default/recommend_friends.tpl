<div class="col-md-9">
    <div class="page-header">
        <h1>Recommend Video</h1>
    </div>

    {if $report ne ""}
        {foreach from=$report item=msg}
            {$msg}
        {/foreach}
    {else}
        <form method="post" action="" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">E-Mail Addresses:</label>
                <div class="col-md-8">
                    <div class="help-block">Separated by commas. Maximum 50 characters.</div>
                    <textarea id="recipients" name="emails" rows="2" class="form-control">{$emails}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Your name:</label>
                <div class="col-md-4">
                    <input type="text" name="fname" value="{if $user_name ne ''}{$user_name}{else}{$fname}{/if}" maxlength="100" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Your Email:</label>
                <div class="col-md-4">
                    <input type="email" name="guest_email" maxlength="100" value="{if $guest_email ne ''}{$guest_email}{else}{$user_email}{/if}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Message:</label>
                <div class="col-md-8">
                    <textarea wrap="virtual" name="message" rows="3" maxlength="200" class="form-control">{if $message ne ""}{$message}{else}This is awesome!{/if}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-default btn-lg">Send</button>
                </div>
            </div>
        </form>
    {/if}
</div>

<div class="col-md-3">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>