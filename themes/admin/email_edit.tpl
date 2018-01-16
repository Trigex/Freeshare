<div class="page-header">
    <a href="switch_editor.php?editor=editor_wysiwyg_email" class="btn btn-info pull-right">Switch Editor</a>
    <h1>Edit Email Template - ({$email.email_id})</h1>
</div>

<form action="?email_id={$smarty.request.email_id}" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="col-sm-1 control-label" for="email_subject">Subject: </label>
        <div class="col-sm-6">
            <input class="form-control" name="email_subject" id="email_subject" value="{$email.email_subject}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-7">
            <textarea class="form-control"name="email_body" id="email_body" rows="20">{$email.email_body}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-1 control-label" for="comment">Comments: <br /><i>(for admin)</i></label>
        <div class="col-sm-6">
            <input class="form-control"name="comment" id="comment" value="{$email.comment}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-6">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

</form>

{if $editor_wysiwyg_email eq 1}
<script language="javascript" type="text/javascript" src="{$base_url}/js/tinymce/tinymce.min.js"></script>
{literal}
<script language="javascript" type="text/javascript">
    tinyMCE.init({
        mode : "textareas",
        plugins : "code, table,save,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
        theme_advanced_buttons1_add : "fontselect,fontsizeselect",
        theme_advanced_buttons2_add : "separator,preview,forecolor,backcolor,hr",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_align : "left",
        theme_advanced_toolbar_location : "top",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        paste_auto_cleanup_on_paste : true,
        paste_convert_headers_to_strong : false,
        paste_strip_class_attributes : "all",
        paste_remove_spans : false,
        paste_remove_styles : false
    });

</script>
{/literal}
{/if}
