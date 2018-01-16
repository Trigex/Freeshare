<div class="page-header">
    <h1>Edit Subscription</h1>
</div>


{if $todo eq "get_username"}


<form method="post" action="" class="form-horizontal" role="form">

    <div class="form-group">
        <label for="user_name" class="col-sm-2 control-label">User Name</label>
        <div class="col-sm-6">
            <input type="text" name="username" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
            <button type="submit" name="edit" class="btn btn-default btn-lg">Edit</button>
        </div>
    </div>

</form>

{elseif $todo eq "show_edit_form"}

<form method="post" action="" class="form-horizontal" role="form">

    <input type="hidden" name="uid" value="{$uid}" />
    <input type="hidden" name="username" value="{$username}" />

    <div class="form-group">
        <label class="col-sm-2 control-label" for="package">Package:</label>
        <div class="col-sm-5">
            <select class="form-control" name="package" id="package">
                {foreach from=$packages item=package}
                    <option {if $pack_name eq $package.package_name}selected{/if}>{$package.package_name}</option>
                {/foreach}
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Expire Date:</label>
        <div class="col-sm-5">
            <div class="form-inline">
                <select class="form-control" name="expire_date">
                    {foreach from=$expire_date item=expiry_date}
                        <option {if $date eq $expiry_date} selected {/if}>{$expiry_date}</option>
                    {/foreach}
                </select>
                <select class="form-control" name="expire_month">
                    {foreach from=$expire_month item=expiry_month}
                        <option {if $month eq $expiry_month} selected {/if}>{$expiry_month}</option>
                    {/foreach}
                </select>
                <select class="form-control" name="expire_year">
                    {foreach from=$expire_year item=expiry_year}
                        <option {if $year eq $expiry_year} selected {/if}>{$expiry_year}</option>
                    {/foreach}
        		</select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="used_space">Space Used (MB):</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="used_space" id="used_space" value="{$used_space}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="total_video">Total Videos:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="total_video" id="total_video" value="{$total_video}" />
        </div>
    </div>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="save_subscription" class="btn btn-default btn-lg">Save</button>
        </div>
	</div>

</form>

{elseif $todo eq "saved"}

<b><font color="#009900">Subscription saved for user: {$username}</font></b><br />
<p><b>
	<font color="#009900">
			Package: {$package}<br />
			Expire Date: {$new_expired_time|date_format:"%e %B %Y"}
	</font>
</b></p>

{/if}