<form action="" method="post" id="upload-remote-form" class="form-horizontal" role="form">    <div>
    <div class="form-group">
        <label class="control-label col-md-2">Enter URL of video:</label>
        <div class="col-md-4">
            <input type="text" name="url" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Upload</button>
        </div>
    </div>
</form>

<p><strong>Correspondence URL:</strong></p>
<pre>
http://www.youtube.com/watch?v=xxxxxx
{if Config::get('dailymotion_api_key') != '' && Config::get('dailymotion_api_secret') != ''}
http://www.dailymotion.com/video/xxxxx_yyyy
{/if}
http://www.metacafe.com/watch/xxxx/yyyy/
</pre>