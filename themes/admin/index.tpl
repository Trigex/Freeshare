<!DOCTYPE html>
<html lang="en">
<head>
<title>vShare Admin</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{$base_url}/css/bootstrap.min.css" rel="stylesheet">
<link href="{$base_url}/themes/admin/css/admin.css" rel="stylesheet" type="text/css" />
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 admin-login text-center">
            <form  action="" method="post" class="form-signin" role="form">
                <div class="box-icon">
                    <i class="glyphicon glyphicon-user"></i>
                </div>

                <h2>Admin Login</h2>

                {if $login_error ne ''}
                <div class="alert alert-danger">
                    <i class="glyphicon glyphicon-warning-sign"></i>{$login_error}
                </div>
                {/if}

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" name="user_name" class="form-control input-lg" placeholder="Username" required autofocus>
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" name="password" class="form-control input-lg" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <button class="btn btn-success btn-block input-lg" type="submit" name="submit"><b>Log In </b></button>
                </div>
                 <a href="./lost_password.php" class="btn">Lost Password?</a>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <p><br>Powered by: <a href="https://www.buyscripts.in/vshare-youtube-clone" target="_blank">vShare</a></p>
        </div>
    </div>
</div>

</body>
</html>
