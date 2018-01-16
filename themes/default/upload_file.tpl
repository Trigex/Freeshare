{if $upload_progress_bar eq "uber"}

<script language="javascript" type="text/javascript" src="{$base_url}/ubr/ubr_file_upload.js"></script>

<script language="javascript" type="text/javascript">
        var upload_range = 1;
        var path_to_link_script = '{$path_to_link_script}';
        var path_to_set_progress_script = '{$path_to_set_progress_script}';
        var path_to_get_progress_script = '{$path_to_get_progress_script}';
        var path_to_upload_script = '{$path_to_upload_script}';
        var multi_configs_enabled = {$multi_configs_enabled};
        var check_allow_extensions_on_client = {$check_allow_extensions_on_client};
        var check_disallow_extensions_on_client = {$check_disallow_extensions_on_client};
        {if $check_allow_extensions_on_client eq 1}
        var allow_extensions = {$allow_extensions};
        {/if}
        {if $check_disallow_extensions_on_client eq 1}
        var disallow_extensions = {$disallow_extensions};
        {/if}
        var check_file_name_format = {$check_file_name_format};
        var check_file_name_regex = {$check_file_name_regex};
        var check_file_name_error_message = "Error, legal file name characters are 1-9, a-z, A-Z, _, -";
        var max_file_name_chars = 48;
        var min_file_name_chars = 5;
        var check_null_file_count = {$check_null_file_count};
        var check_duplicate_file_count = {$check_duplicate_file_count};
        var max_upload_slots = {$max_upload_slots};
        var cedric_progress_bar = {$cedric_progress_bar};
        var cedric_hold_to_sync = {$cedric_hold_to_sync};
        var bucket_progress_bar = {$bucket_progress_bar};
        var progress_bar_width = {$progress_bar_width};
        var show_percent_complete = {$show_percent_complete};
        var show_files_uploaded = {$show_files_uploaded};
        var show_current_position = {$show_current_position};
        var show_current_file = {$show_current_file};
        var show_elapsed_time = {$show_elapsed_time};
        var show_est_time_left = {$show_est_time_left};
        var show_est_speed = {$show_est_speed};
</script>

{/if}

<div class="page-header">
    <h1>Video Upload (Step 2 of 2)</h1>
</div>

{if $upload_progress_bar eq "uber"}
    {if $upload_iframe ne ""}
        <div id="upload_div" style="display: none;">
            <iframe name="upload_iframe" frameborder="0" width="800" height="200" scrolling="auto"></iframe>
        </div>
    {/if}
{/if}

<!-- Start Upload Form -->

{if $upload_progress_bar eq "uber"}

    <form name="uu_upload" id="uu_upload" {$upload_iframe} method="post" enctype="multipart/form-data" action="#" class="form-horizontal" role="form">
        <noscript>
            <span class="ubrError">ERROR</span>: Javascript must be enabled to use this Uber-Uploader.
            <br><br>
        </noscript>

        <input type="hidden" name="upload_id" value="{$upload_id}">

        <div class="form-group">
            <label class="control-label col-md-2">File:</label>
            <div class="col-md-8">
                <div style="width:550px;">
                    <div class="formHighlight">
                        <div id="upload_slots">
                            <input class="ubrUploadSlot" type="file" name="upfile_0" size="70" onkeypress="return handleKey(event)" value="">
                        </div>
                         <div class="help-block">
                            <strong>Max. video file size: {ini_get('upload_max_filesize')}. No copyrighted {if $smarty.session.$upload_id.adult eq "0"}or obscene {/if}material.</strong><br>
                            After uploading, you can edit or remove this video at any time under the "My Videos" link
                            on the top of the page.
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning">
                    PLEASE BE PATIENT, THIS MAY TAKE SEVERAL MINUTES. <br>ONCE COMPLETED, YOU WILL SEE A CONFIRMATION MESSAGE.
                    <input type="hidden" name="upload_range" value="1">
                    <noscript><input type="hidden" name="no_script" value="1"></noscript>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Progress:</label>
            <div class="col-md-8">
                <!-- Start Progress Bar -->
                <div id="ubr_alert" class="ubrAlert"></div>
                <div align="left" id="progress_bar" style="display:none;">
                    <div id="upload_status_wrap" class="ubrBar1" style="width: {$progress_bar_width}px;">
                        <div id="upload_status" class="ubrBar2"></div>
                    </div>
                    <br />
                    <table class="ubrUploadData">
                        <tr>
                            <td class='ubrUploadDataLabel'>Percent Complete:</td>
                            <td class='ubrUploadDataInfo'><span id="percent_complete">0%</span></td>
                        </tr>
                        <tr>
                            <td class='ubrUploadDataLabel'>Current Position:</td>
                            <td class='ubrUploadDataInfo'><span id="current_position">0</span> / <span id="total_kbytes"></span> KBytes</td>
                        </tr>
                        <tr>
                            <td class='ubrUploadDataLabel'>Elapsed Time:</td>
                            <td class='ubrUploadDataInfo'><span id="elapsed_time">0</span></td>
                        </tr>
                        <tr>
                            <td class='ubrUploadDataLabel'>Est Time Left:</td>
                            <td class='ubrUploadDataInfo'><span id="est_time_left">0</span></td>
                        </tr>
                        <tr>
                            <td class='ubrUploadDataLabel'>Est Speed:</td>
                            <td class='ubrUploadDataInfo'><span id="est_speed">0</span> KB/s.</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Progress Bar -->
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="button" id="upload_button" name="upload_button" class="btn btn-default btn-lg">Upload</button>
            </div>
        </div>
    </form>
    <div id="ajax_div"><!-- Used to store AJAX --></div>

{elseif $upload_progress_bar eq "html5"}

    <form action="{$base_url}/upload_file.php?upload_id={$upload_id}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <noscript>
            <span class="ubrError">ERROR</span>: Javascript must be enabled to use this HTML5-Uploader.
            <br><br>
        </noscript>
        <input type="hidden" name="upload_id" id="upload_id" value="{$upload_id}">

        <div class="form-group">
            <label class="control-label col-md-2">File:</label>
            <div class="col-md-6">
                <div style="width:550px;">
                    <div class="formHighlight">
                        <div id="upload_slots">
                            <input type="file" name="upfile_0" accept="video/*" required>
                        </div>
                         <div class="help-block">
                            <strong>Max. video file size: {ini_get('upload_max_filesize')}. No copyrighted {if $smarty.session.$upload_id.adult eq "0"}or obscene {/if}material.</strong><br />
                            After uploading, you can edit or remove this video at any time under the "My Videos" link
                            on the top of the page.
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning">
                    PLEASE BE PATIENT, THIS MAY TAKE SEVERAL MINUTES. <br>ONCE COMPLETED, YOU WILL SEE A CONFIRMATION MESSAGE.
                    <input type="hidden" name="upload_range" value="1">
                    <noscript><input type="hidden" name="no_script" value="1"></noscript>
                </div>
                <div>
                    <div class="progress">
                        <div class="progress-bar bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            <span class="sr-only percent">0%</span>
                        </div>
                    </div>
                    <div id="processing" style="display: none;">
                        <img src="{$img_css_url}/images/loading.gif"> <strong>Processing...</strong>
                    </div>
                    <p id="status"></p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" class="btn btn-default btn-lg">Upload</button>
            </div>
        </div>
    </form>

{else}

    <form id="theForm" name="theForm" action="{$base_url}/upload_file.php" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <input type="hidden" name="upload_id" value="{$upload_id}">
        <div class="form-group">
            <label class="control-label col-md-2">File:</label>
            <div class="col-md-8">
                <input type="file" name="field_uploadfile" size="70">
                <div class="help-block">
                    <strong>Max. video file size: {ini_get('upload_max_filesize')}. No copyrighted {if $smarty.session.$upload_id.adult eq "0"}or obscene {/if}material.</strong><br />
                    After uploading, you can edit or remove this video at any time under the "My Videos" link
                    on the top of the page.
                </div>
                <div class="alert alert-warning">
                    PLEASE BE PATIENT, THIS MAY TAKE SEVERAL MINUTES. <br />ONCE COMPLETED, YOU WILL SEE A CONFIRMATION MESSAGE.
                    <input type="hidden" name="upload_range" value="1">
                    <noscript><input type="hidden" name="no_script" value="1"></noscript>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button name="upload_final" type="submit" class="btn btn-default btn-lg">Upload Video</button>
            </div>
        </div>
    </form>
{/if}