<div class="page-header">
    <a href="switch_editor.php?editor=editor_wysiwyg_email" class="btn btn-info pull-right">Switch Editor</a>
    <h1>Send Email to {if $smarty.request.a eq "user"}User{elseif $smarty.request.a eq "group"}Group{else}{$smarty.request.uname}{/if}</h1>
</div>

{if $smarty.request.a eq "user"}
<form method="post" action="mail_users.php?a=user" class="form-horizontal">
{elseif $smarty.request.a eq "group"}
<form method="post" action="mail_users.php?a=group" class="form-horizontal">
{else}
<form method="post" action="mail_users.php?email={$smarty.request.email}&uname={$smarty.request.uname}" class="form-horizontal">
{/if}

    <div class="form-group">
        <label class="col-sm-2 control-label">Email To:</label>
        <div class="col-sm-5">
            {if $smarty.request.a eq "user"}
                <p class="form-control-static">ALL USERS</p>
                <input type="hidden" name="UID" value="All">
            {elseif $smarty.request.a eq "group"}
                <select class="form-control" name="GID">{$group_ops}</select>
            {else}
                <input class="form-control" type="email" name="email" value="{$smarty.request.email}" required="">
            {/if}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="subj">Subject:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="subj" id="subj" size="60" value="{$smarty.request.subj}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-7">
            <textarea class="form-control" name="htmlCode" cols="100" rows="22">{$smarty.request.htmlCode}</textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Send Email</button>
        </div>
    </div>

</form>

{if $editor_wysiwyg_email eq "1"}
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
        convert_urls: true,
        relative_urls: false,
        remove_script_host: false,
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
