function Mail() {
	this.showbox = function(box, page){
		var sUrl = baseurl + "/ajax/mail.php";
		var postData = "folder=" + box + "&page=" + page;
		
		this.loading();
		
		$.ajax({
			type: "GET",
			url: sUrl,
			data: postData,
			dataType: 'html',
			success: function(msg){
				$("#folder-links-result").html(msg).show();
			},
			error: function(){
				alert('Connection Failed.');
			}
		});
		
		this.rowcolor();
		this.detail();
	};
	
	this.compose = function(mail_to,mail_subject){
		var sUrl = baseurl + "/ajax/mail_compose.php";
		var postData = "receiver=" + mail_to + "&subject=" + mail_subject;
		
		this.loading();
		
		$.ajax({
			type: "GET",
			url: sUrl,
			data: postData,
			dataType: 'html',
			success: function(msg){
				$("#folder-links-result").html(msg).show();
			},
			error: function(){
				alert('Connection Failed.');
			}
		});
	};
	
	this.send = function(){
		var mail_to = $("form#frm #mail_to").val();
		var mail_subject = $("form#frm #mail_subject").val();
		var mail_body = $("form#frm #mail_body").val();
		var sUrl = baseurl + "/ajax/mail_compose.php";
		var postData = "action=send&receiver=" + mail_to + "&subject=" + mail_subject + "&mail_body=" + mail_body;
		
		this.loading();
		
		$.ajax({
			type: "GET",
			url: sUrl,
			data: postData,
			dataType: 'html',
			success: function(msg){
				if (msg == 'sent'){
					var mail = new Mail();
					mail.showbox("outbox", 1);
				}else{
					$("#folder-links-result").html(msg).show();
				}
			},
			error: function(){
				alert('Connection Failed.');
			}
		});
	};
	
	this.loading = function(){
		$("#folder-links-result").html("<center><img src='" + baseurl + "/themes/default/images/loading.gif'></center>");
	};
	
	this.rowcolor = function(){
		$('tbody tr[rel=mail-list]:odd').removeClass('boxrow2').addClass('boxrow1');
        $('tbody tr[rel=mail-list]:even').removeClass('boxrow1').addClass('boxrow2');
	};
	
	this.detail = function(mail_id, mail_box, mail_read){
		$("[rel=mail-detail]").each(function(){
			if ($(this).attr("id") == "mail-body-" + mail_id || $(this).attr("id") == "mail-photo-" + mail_id || $(this).attr("id") == "mail-reply-" + mail_id){
				$(this).toggle();
				
				var mail = new Mail();
				mail.read(mail_id, mail_box, mail_read);
			}else{
				$(this).hide();
			}
		});
	};
	
	this.read = function(mail_id, mail_box, mail_read){
		if (mail_box == "inbox" && mail_read == "0"){
			
			var sUrl = baseurl + "/ajax/mail_compose.php";
			var postData = "action=read&mail_id=" + mail_id;
			
			$.ajax({
				type: "GET",
				url: sUrl,
				data: postData,
				dataType: 'html',
				success: function(msg){
					
				},
				error: function(){
					alert('Connection Failed.');
				}
			});
		}
	};
	
	this.del = function(mail_folder){
		var mail_ids = '';
		
		if ($("[rel=mail-list] input[type=checkbox]:checked").length > 0)
		{
			$("[rel=mail-list] input[type=checkbox]:checked").each(function(){
				mail_ids += $(this).val() + ",";
			});
			
			var sUrl = baseurl + "/ajax/mail_compose.php";
			var postData = "action=delete&mail_ids=" + mail_ids + "&mail_folder=" + mail_folder;
			
			this.loading();
			
			$.ajax({
				type: "GET",
				url: sUrl,
				data: postData,
				dataType: 'html',
				success: function(msg){
					var mail = new Mail();
					mail.showbox(mail_folder);
				},
				error: function(){
					alert('Connection Failed.');
				}
			});
		}
	}
}

var mail = new Mail();

$("#folder-links #inbox").click(function(){
	mail.showbox("inbox", 1);
});
$("#folder-links #outbox").click(function(){
	mail.showbox("outbox", 1);
});
$("#folder-links #compose").click(function(){
	mail.compose("", "");
});
