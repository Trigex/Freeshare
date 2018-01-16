<div class="page-header">
    <h1>Edit User</h1>
</div>

<form action="user_edit.php?a={$smarty.request.a}action=edit&uid={$user.user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" method="post" class="form-horizontal" role="form">

<fieldset>

<div class="form-group">
    <label class="col-sm-3 control-label">User ID:</label>
    <div class="col-sm-5">
        <p class="form-control-static">{$user.user_id}</p>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">User Name:</label>
    <div class="col-sm-5">
        <p class="form-control-static">{$user.user_name}</p>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Email Address:</label>
    <div class="col-sm-5">
        <input class="form-control" name="email" value="{$user.user_email}" size="43" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">First Name:</label>
    <div class="col-sm-5">
        <input class="form-control" name="fname" value="{$user.user_first_name}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Last Name:</label>
    <div class="col-sm-5">
        <input class="form-control" name="lname" value="{$user.user_last_name}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">City:</label>
    <div class="col-sm-5">
        <input class="form-control" name="city" value="{$user.user_city}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Country:</label>
    <div class="col-sm-5">
        <select class="form-control" name="country"><option value="">Select Country</option>{$country_box}</select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Website:</label>
    <div class="col-sm-5">
        <input class="form-control" name="website" value="{$user.user_website}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Occupation:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="occupation" rows="3">{$user.user_occupation}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Company Name:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="company" rows="3">{$user.user_company}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">School:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="school" rows="3">{$user.user_school}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Interest/Hobby:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="interest_hobby" rows="3">{$user.user_interest_hobby}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Favorite Movie:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="fav_movie_show" rows="3">{$user.user_fav_movie_show}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Favorite Book:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="fav_book" rows="3">{$user.user_fav_book}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Favorite Music:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="fav_music" rows="3">{$user.user_fav_music}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">About Me:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="aboutme" rows="3">{$user.user_about_me}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Email Verified:</label>
    <div class="col-sm-5">
        <select class="form-control" name="emailverified">{$email_ver_box}</select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Account Status:</label>
    <div class="col-sm-5">
        <select class="form-control" name="account_status">{$account_status_box}</select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-5">
        <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
    </div>
</div>

</fieldset>

</form>
