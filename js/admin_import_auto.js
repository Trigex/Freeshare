function validate_import_auto_form()
{
    $('#auto-import').validate({
        rules: {
            video_keywords:"required",
            video_user_name: "required",
            video_channel: "required",
            import_auto_download: "required"
        },
        messages: {
            video_keywords: "Please enter keyword",
            video_user_name: "Please enter a username",
            video_channel: "Please select a channel",
            import_auto_download: "Please select import method"
        }
    }); 

}