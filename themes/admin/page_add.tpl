{if $editor_wysiwyg_admin eq 1}
<script language="javascript" type="text/javascript" src="{$base_url}/js/tinymce/tinymce.min.js"></script>
{literal}

<script language="javascript" type="text/javascript">
    tinyMCE.init({
        mode : "textareas",
        plugins : "code,autolink,lists,pagebreak,layer,table,save,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template,wordcount,advlist,autosave",
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,hr,|,sub,sup",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_align : "left",
        theme_advanced_toolbar_location : "top",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_buttons_location: "top",
        theme_advanced_resizing : true,
        paste_auto_cleanup_on_paste : true,
        paste_convert_headers_to_strong : false,
        paste_strip_class_attributes : "all",
        paste_remove_spans : false,
        paste_remove_styles : false,
        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ]
    });
</script>

{/literal}
{/if}

<div class="page-header">
    <a href="switch_editor.php?editor=editor_wysiwyg_admin" class="btn btn-info pull-right">Switch Editor</a>
    <h1>Add New Page</h1>
</div>

<form method="post" action="" class="form-horizontal">

    <div class="form-group">
        <label class="col-sm-2 control-label">File Name:</label>
        <div class="col-sm-5">
            <div class="form-inline">
            <input class="form-control" type="text" name="page_name" maxlength="64" value="{$smarty.request.page_name}">.html
            </div>
            <p class="help-block">File Name should be in lowercase. No special characters are allowed other than hyphen (-).</p>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10">
          <textarea class="form-control" name="content" rows="15">{$smarty.request.content}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="title">Title:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="title" id="title" maxlength="200" value="{$smarty.request.title}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="description">Description:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="description" id="description" maxlength="200" value="{$smarty.request.description}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="keywords">Keywords:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="keywords" id="keywords" maxlength="200" value="{$smarty.request.keywords}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="members_only">Members Only:</label>
        <div class="col-sm-5">
            <select class="form-control" name="members_only" id="members_only">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Save Page</button>
        </div>
    </div>

</form>