<div class="page-header">
    <h1>Player Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">
    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_autostart">Auto Play Video:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="player_autostart" id="player_autostart">
                <option value="1" {if $player_autostart =='1'}selected="selected"{/if}>Yes</option>
                <option value="0" {if $player_autostart =='0'}selected="selected"{/if}>No</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#player_autostart" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_bufferlength">Video buffer time in seconds:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="player_bufferlength" id="player_bufferlength" value="{$player_bufferlength}" size="5" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#player_bufferlength" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_width">Player Width:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="player_width" id="player_width" value="{$player_width}" size="5" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#player_width" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_height">Player Height:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="player_height" id="player_height" value="{$player_height}" size="5" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#player_height" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="vshare_player">Video player:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="vshare_player" id="vshare_player">
                <option value="videojs" {if $vshare_player == 'videojs'}selected="selected"{/if}>VideoJS Player</option>
                <option value="JW Player" {if $vshare_player == 'JW Player'}selected="selected"{/if}>JW Player</option>
                <option value="StrobeMediaPlayback" {if $vshare_player == 'StrobeMediaPlayback'}selected="selected"{/if}>StrobeMediaPlayback</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#vshare_player" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="youtube_player">Youtube video player:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="youtube_player" id="youtube_player">
                <option value="youtube" {if $youtube_player =='youtube'}selected="selected"{/if}>Youtube Player</option>
                <option value="vshare" {if $youtube_player =='vshare'}selected="selected"{/if}>vShare Player</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#youtube_player" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="watermark_url">Watermark URL:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="watermark_url" id="watermark_url" value="{$watermark_url}">
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#watermark_url" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="watermark_image_url" class="col-sm-3 control-label">Watermark Image URL:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="watermark_image_url" id="watermark_image_url" value="{$watermark_image_url}">
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/3.0/player_settings#watermark_image_url" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

    </fieldset>

</form>
