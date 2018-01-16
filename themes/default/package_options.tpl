<div class="col-md-12">
    <div class="page-header">
        <h1>Package Options</h1>
    </div>

    <p class="lead text-muted">Provide necessary information to complete your payment:</p>

    <form action="payment.php" method="post" id="package-options" class="form-horizontal">
        <input type="hidden" name="package_id" value="{$smarty.get.package_id}">
        <input type="hidden" name="user_id" value="{$smarty.get.user_id}">

        <div class="form-group">
            <label class="control-label col-md-2">Your Package:</label>
            <div class="col-md-4">
                <p class="form-control-static">{$package.package_name}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Package Price:</label>
            <div class="col-md-4">
                <p class="form-control-static">${$package.package_price} per {$package.package_period}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Subscription Period:</label>
            <div class="col-md-2">
                <div class="input-group">
                    <select name="period" class="form-control">{$period_ops}</select>
                    <span class="input-group-addon">{$package.package_period}</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Payment Method:</label>
            <div class="col-md-2">
                <select name="method" class="form-control">{$payment_method_ops}</select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="next" class="btn btn-default btn-lg">Next &raquo;</button>
            </div>
        </div>
    <form>
</div>