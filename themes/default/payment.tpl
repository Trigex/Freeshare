<div class="col-md-12">
    <div class="page-header">
        <h1>Confirm Payment</h1>
    </div>

    <p class="lead text-muted">Provide necessary information to complete your payment:</p>

    <form action="payment.php" method="post" name="payment" id="payment" class="form-horizontal">
        <input type="hidden" name="package_id" value="{$smarty.post.package_id}">
        <input type="hidden" name="user_id" value="{$smarty.post.user_id}">
        <input type="hidden" name="period" value="{$smarty.post.period}">
        <input type="hidden" name="method" value="{$smarty.post.method}">

        <div class="form-group">
            <label class="control-label col-md-2">Your Package:</label>
            <div class="col-md-4">
                <p class="form-control-static">{$package.package_name}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Total Price:</label>
            <div class="col-md-4">
                <p class="form-control-static">${$totalprice} for {$smarty.request.period} {$package.package_period}(s)</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Payment Method:</label>
            <div class="col-md-4">
                <p class="form-control-static">{$smarty.post.method}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2" for="user_first_name">First Name:</label>
            <div class="col-md-4">
                <input type="text" name="user_first_name" id="user_first_name" maxlenth="40" value="{$user_info.user_first_name}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2" for="user_last_name">Last Name:</label>
            <div class="col-md-4">
                <input type="text" name="user_last_name" id="user_last_name" maxlenth="40" value="{$user_info.user_last_name}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2" for="user_city">City:</label>
            <div class="col-md-4">
                <input type="text" name="user_city" id="user_city" maxlenth="80" value="{$user_info.user_city}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2" for="user_country">Country:</label>
            <div class="col-md-4">
                <select name="user_country" id="user_country" class="form-control">{$country}</select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-default btn-lg">Next &raquo;</button>
            </div>
        </div>
    </form>
</div>