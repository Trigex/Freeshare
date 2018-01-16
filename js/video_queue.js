video_queue_display();

$('div [rel=video_queue]').each(function(){
    $(this).click(function(){
        var video_id = $(this).attr("data-id");
        $("#queue_"+video_id).addClass('disabled');
        $("#queue_"+video_id).html('<span class="glyphicon glyphicon-ok"></span>');

        if (video_id.match('_')) {
            var tmp = video_id.split('_');
            video_id = tmp[0];
        }

        var sUrl = baseurl + "/ajax/video_queue.php";
        sUrl = sUrl + "?video_id=" + video_id;

        $.ajax({
            type: "GET",
            url: sUrl,
            dataType: 'html',
            success: function(html){
                video_queue_display();
            },
            error: function(){
            }
        });
    });
});

function video_queue_display(){
    var sUrl = baseurl + "/ajax/video_queue_display.php";
    $.ajax({
        type: "GET",
        url: sUrl,
        dataType: 'html',
        success: function(html){
           jQuery("#quicklist_box").html(html);
           show = jQuery.COOKIE('show');
           if (show == '') {
               jQuery('#collapseQueue').collapse('hide');
           } else {
                jQuery('#collapseQueue').collapse('show');
           }

        },
        error: function(){
        }
    });
}

var cookieName = '';
var cookieValue = '';

jQuery.COOKIE = function(cookieName,cookieValue){
	var expiredays = 1;

	if (cookieValue != undefined)
	{
		var exdate=new Date();
		expiredays = exdate.setDate(exdate.getDate()+expiredays);
		document.cookie =''+ cookieName +'= ' + cookieValue + '; expires='+exdate.toUTCString()+'; path=/';
	}
	else
	{
		var cookieValue = '';

        if (document.cookie && document.cookie != '') {
        	var cookies = document.cookie.split(';');

        	for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);

                if (cookie.match(cookieName + '='))
                {
                	cookieValue = cookie.substring(cookieName.length + 1);
                }
            }
        }
        return cookieValue;
	}
}