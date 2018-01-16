<script language="JavaScript" type="text/javascript" src="{$base_url}/js/fileinput.min.js"></script>
<link href="{$base_url}/themes/default/css/fileinput.css" rel="stylesheet">
<div class="col-md-12">
    <div class="page-header">
        <h1>
            Upload Photo
        </h1>
        <p class="lead text-muted">After uploading a new photo, refresh the page (Press F5), to see the new image.</p>
    </div>

    <form action="user_photo_upload.php" method="post" enctype="multipart/form-data" name="profile-photo-upload" id="profile-photo-upload" class="form-horizontal">
        <div class="form-group">
            <div class="col-md-2">
                <div class="profile-pic-container thumbnail" style="margin: 0;">
                    <img class="img-responsive" src="{$photo_url}?{$vshare_rand}" alt="">
                </div>
            </div>
            <div class="col-md-5">
            <label class="control-label">Select file to upload:</label>
                <input type="file" name="photo" class="file" accept="image/jpeg,image/png">
                <span class="help-block">Photo must be in JPG format. Recommended size {Config::get('user_photo_width')}x{Config::get('user_photo_height')}</span>
                <p class="small">By clicking “Upload”, you certify that you have the right to distribute the uploaded photo and that it does not violate the <a href="{$base_url}/pages/terms.html" target="_blank">terms of use</a> and <a href="{$base_url}/pages/privacy.html" target="_blank">privacy policy</a></p>
            </div>
        </div>
    </form>
</div>