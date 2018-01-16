function validate_multi_import_form () 
{
    $('#multi-import').validate({
                rules: {    		    
                    video_user: "required",
                    video_title: "required",
                    video_description: "required",
                    video_keywords: "required",
                    chlist: "required"
                },
                messages: {
                	video_user: "Please enter a username",
                    video_title: "Please enter video title",
                    video_description: "Please enter description",
                    video_keywords: "Please enter keywords",
                    chlist: "Please select a channel"
                }
        });
}