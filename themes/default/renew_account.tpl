<div class="col-md-12">
    <div class="page-header">
        {if $smarty.request.action eq "upgrade"}
            <h1>
                Upgrade Account
                <br><small>Choose one of the following packages to upgrade your account:</small>
            </h1>
        {else}
            <h1>
                Your Account has Expired - Renew Now!
                <br><small>Choose one of the following packages to renew your account:</small>
            </h1>
        {/if}
    </div>

    <form action="renew_account.php?uid={$smarty.get.uid}" method="post" name="renew_account" id="renew_account" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-md-2">Available Packages:</label>
            <div class="col-md-6">
                {section name=i loop=$package}
                    <div class="radio">
                        <label>
                            <input type="radio" name="package_id" value="{$package[i].package_id}">
                            <b>{$package[i].package_name}</b>
                            <br>
                            <small>
                            {$package[i].package_description}<br />
                            - <font color="#0055CC">{insert name=format_size size=$package[i].package_space}</font> video upload space<br />
                            {if $package[i].package_videos gt "0"}
                                - Maximum <font color="#0055CC">{$package[i].package_videos}</font> videos upload<br />
                            {/if}
                            {if $package[i].package_price gt "0"}
                                - Registration cost only <font color="#0055CC">${$package[i].package_price}</font> per {$package[i].package_period|lower}
                            {elseif $package[i].package_trial eq "yes"}
                                - Free for <font color="#0055CC">{$package[i].package_trial_period} days</font>
                            {/if}
                            </small>
                        </label>
                    </div>
                {/section}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-default btn-lg">Next &raquo;</button>
            </div>
        </div>
    </form>
</div>