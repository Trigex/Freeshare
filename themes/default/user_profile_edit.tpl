<div class="col-md-12" id="user-profile-edit">
    <div class="page-header">
		<h1>
            Edit Profile
            <small class="pull-right btn font-size-md">
                <a href="{$base_url}/{$user_info.user_name}">View Profile</a>
            </small>
        </h1>
    </div>

    <form method="post" action="" enctype="multipart/form-data" class="form-horizontal" role="form">
        <h2>Account Information: </h2>
        <div class="form-group">
            <label class="control-label col-md-2">Email:</label>
            <div class="col-md-4">
                <input maxlength="60" value="{$user_info.user_email}" name="user_email" class="form-control">
            </div>
        </div>
        <br>

        <h2>Personal Information:</h2>
        <div class="form-group">
            <label class="control-label col-md-2">First Name:</label>
            <div class="col-md-4">
                <input type="text" maxlength="30" name="user_first_name" value="{$user_info.user_first_name}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Last Name:</label>
            <div class="col-md-4">
                <input type="text" maxlength="30" name="user_last_name" value="{$user_info.user_last_name}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Birthday:</label>
            <div class="col-md-1">
                <select name="month" class="form-control"><option>mm</option>{$months}</select>
            </div>
            <div class="col-md-1">
                <select name="day" class="form-control"><option>dd</option>{$days}</select>
            </div>
            <div class="col-md-2">
                <select name="year" class="form-control"><option>yyyy</option>{$years}</select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Gender:</label>
            <div class="col-md-2">
                <select name="user_gender" class="form-control">
                    <option value="">- - -</option>
                    <option value="Female" {if $user_info.user_gender eq "Female"}selected{/if}>Female</option>
                    <option value="Male" {if $user_info.user_gender eq "Male"}selected{/if}>Male</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Relationship Status:</label>
            <div class="col-md-2">
                <select name="user_relation" class="form-control">
                    <option value="">- - -</option>
                    <option value="Single" {if $user_info.user_relation eq "Single"}selected{/if}>Single</option>
                    <option value="Taken" {if $user_info.user_relation eq "Taken"}selected{/if}>Taken</option>
                    <option value="Open" {if $user_info.user_relation eq "Open"}selected{/if}>Open</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">About Me:</label>
            <div class="col-md-5">
                <textarea name="user_about_me" rows="3" class="form-control">{$user_info.user_about_me}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Personal Website:</label>
            <div class="col-md-4">
                <input type="url" maxlength="255" name="user_website" value="{$user_info.user_website}" class="form-control">
            </div>
        </div>
        <br>

        <h2>Location Information:</h2>
        <div class="form-group">
            <label class="control-label col-md-2">Hometown:</label>
            <div class="col-md-4">
                <input type="text" maxlength="120" name="user_town" value="{$user_info.user_town}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">City:</label>
            <div class="col-md-4">
                <input type="text" maxlength="120" name="user_city" value="{$user_info.user_city}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Zip:</label>
            <div class="col-md-4">
                <input type="text" maxlength="10" name="user_zip" value="{$user_info.user_zip}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Country:</label>
            <div class="col-md-4">
                <select name="user_country" class="form-control">
                    <option value="">Select Country</option>{$country}
                </select>
            </div>
        </div>
        <br>

        <h2>
            Random Information:
            <br><small>Separate items with a comma.</small>
        </h2>
        <div class="form-group">
            <label class="control-label col-md-2">Occupations:</label>
            <div class="col-md-5">
                <input type="text" maxlength="500" name="user_occupation" value="{$user_info.user_occupation}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Companies:</label>
            <div class="col-md-5">
                <input type="text" maxlength="500" name="user_company" value="{$user_info.user_company}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Schools:</label>
            <div class="col-md-5">
                <input type="text" maxlength="500" name="user_school" value="{$user_info.user_school}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Interests &amp; Hobbies:</label>
            <div class="col-md-5">
                <textarea name="user_interest_hobby" rows="4" class="form-control">{$user_info.user_interest_hobby}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Favorite Movies &amp; Shows:</label>
            <div class="col-md-5">
                <textarea name="user_fav_movie_show" rows="4" class="form-control">{$user_info.user_fav_movie_show}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Favorite Music:</label>
            <div class="col-md-5">
                <textarea name="user_fav_music" rows="4" class="form-control">{$user_info.user_fav_music}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Favorite Books:</label>
            <div class="col-md-5">
                <textarea name="user_fav_book" rows="4" class="form-control">{$user_info.user_fav_book}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Friends:</label>
            <div class="col-md-5">
                <textarea name="user_friends_name" rows="4" class="form-control">{$user_info.user_friends_name}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-default btn-lg">Save Changes</button>
            </div>
        </div>

    </form>

</div>
