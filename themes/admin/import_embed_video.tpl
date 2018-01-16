<div class="page-header">
    <h1>Add Embed Videos</h1>
</div>

<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

    {include file="admin/import_form.tpl"}

    <div class="form-group">
        <label class="control-label col-md-2">Embed Code:</label>
        <div class="col-md-6">
            <textarea name="embed_code" rows="3" class="form-control" placeholder="Embed code"required>{if isset($smarty.post.embed_code)}{$smarty.post.embed_code}{/if}</textarea>
        </div>
    </div>

    <div class="form-group">
        <div role="tabpanel" class="col-md-10 col-md-offset-2">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#remote_image" aria-controls="remote_image" role="tab" data-toggle="tab">Image URL</a>
                </li>
                <li role="presentation">
                    <a href="#local_image" aria-controls="local_image" role="tab" data-toggle="tab">Image from your Computer</a>
                </li>
            </ul>
            <div class="tab-content">
                <br>
                <div role="tabpanel" class="tab-pane fade in active" id="remote_image">
                    <div class="form-group">
                        <div class="col-md-6">
                            <input type="text" name="embedded_code_image[]" class="form-control" placeholder="http://site.com/image1.jpg"><br>
                            <input type="text" name="embedded_code_image[]" class="form-control" placeholder="http://site.com/image2.jpg"><br>
                            <input type="text" name="embedded_code_image[]" class="form-control" placeholder="http://site.com/image3.jpg">
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="local_image">
                    <div class="form-group">
                        <div class="col-md-6">
                            <input type="file" name="embedded_code_image_local[]"><br>
                            <input type="file" name="embedded_code_image_local[]"><br>
                            <input type="file" name="embedded_code_image_local[]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Add Video</button>
        </div>
    </div>

</form>
