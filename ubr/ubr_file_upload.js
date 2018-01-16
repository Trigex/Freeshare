//******************************************************************************************************
//	Name: ubr_file_upload.js
//	Revision: 2.5
//	Date: 10:28 PM Tuesday, January 13, 2009
//	Link: http://uber-uploader.sourceforge.net
//	Developer Peter Schmandra
//
//	BEGIN LICENSE BLOCK
//	The contents of this file are subject to the Mozilla Public License
//	Version 1.1 (the "License"); you may not use this file except in
//	compliance with the License. You may obtain a copy of the License
//	at http://www.mozilla.org/MPL/
//
//	Software distributed under the License is distributed on an "AS IS"
//	basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See
//	the License for the specific language governing rights and
//	limitations under the License.
//
//	Alternatively, the contents of this file may be used under the
//	terms of either the GNU General Public License Version 2 or later
//	(the "GPL"), or the GNU Lesser General Public License Version 2.1
//	or later (the "LGPL"), in which case the provisions of the GPL or
//	the LGPL are applicable instead of those above. If you wish to
//	allow use of your version of this file only under the terms of
//	either the GPL or the LGPL, and not to allow others to use your
//	version of this file under the terms of the MPL, indicate your
//	decision by deleting the provisions above and replace them with the
//	notice and other provisions required by the GPL or the LGPL. If you
//	do not delete the provisions above, a recipient may use your
//	version of this file under the terms of any one of the MPL, the GPL
//	or the LGPL.
//	END LICENSE BLOCK
//***************************************************************************************************************

var seconds = 0;
var minutes = 0;
var hours = 0;
var get_status_url;
var total_upload_size = 0;
var total_kbytes = 0;
var CPB_loop = false;
var CPB_width = 0;
var CPB_bytes = 0;
var CPB_time_width = 500;
var CPB_time_bytes = 15;
var CPB_hold = true;
var CPB_byte_timer;
var CPB_status_timer;
var BPB_width_inc = 0;
var BPB_width_new = 0;
var BPB_width_old = 0;
var BPB_timer;
var UP_timer;

// Check the file format before uploading
function checkFileNameFormat(){
	if(!check_file_name_format){ return false; }

	var found_error = false;

	JQ(":file").each(function(){
		if(JQ(this).val() != ""){
			var file_name_path = JQ(this).val().split("\\");
			var file_name = file_name_path[file_name_path.length-1];

			if(file_name.length > max_file_name_chars){
				alert("Error, file name cannot be more than " + max_file_name_chars + " characters.");
				found_error = true;
			}

			if(file_name.length < min_file_name_chars){
				alert("Error, file name cannot be less than " + min_file_name_chars + " characters.");
				found_error = true;
			}

			if(!check_file_name_regex.test(file_name)){
				alert(check_file_name_error_message);
				found_error = true;
			}
		}
	});

	return found_error;
}

// Check for legal file extentions
function checkAllowFileExtensions(){
	if(!check_allow_extensions_on_client){ return false; }

	var found_error = false;

	JQ(":file").each(function(){
		if(JQ(this).val() != ""){
			var file_name_path = JQ(this).val().split("\\");
			var file_name = file_name_path[file_name_path.length-1];
			var file_extension = file_name.slice(file_name.indexOf(".")).toLowerCase();

			if(!file_extension.match(allow_extensions)){
				alert('Sorry, uploading a file with the extension "' + file_extension + '" is not allowed.');
				found_error = true;
			}
		}
	});

	return found_error;
}

// Check for illegal file extentions
function checkDisallowFileExtensions(){
	if(!check_disallow_extensions_on_client){ return false; }

	var found_error = false;

	JQ(":file").each(function(){
		if(JQ(this).val() != ""){
			var file_name_path = JQ(this).val().split("\\");
			var file_name = file_name_path[file_name_path.length-1];
			var file_extension = file_name.slice(file_name.indexOf(".")).toLowerCase();

			if(file_extension.match(disallow_extensions)){
				alert('Sorry, uploading a file with the extension "' + file_extension + '" is not allowed.');
				found_error = true;
			}
		}
	});

	return found_error;
}

// Make sure the user selected at least one file
function checkNullFileCount(){
	if(!check_null_file_count){ return false; }

	var found_file = false;

	JQ(":file").each(function(){
		if(JQ(this).val() != ""){ found_file = true; }
	});

	if(!found_file){
		alert("Please Choose A File To Upload.");
		return true;
	}
	else{ return false; }
}

// Make sure the user is not uploading duplicate files
function checkDuplicateFileCount(){
	if(!check_duplicate_file_count){ return false; }

	var found_duplicate = false;
	var duplicate_count = 0;
	var file_count = 0;
	var duplicate_msg = "Duplicate Upload Files Detected.\n\n";
	var file_name_array = new Array();

	JQ(":file").each(function(){
		if(JQ(this).val() != ""){
			var file_name_path = JQ(this).val().split("\\");
			var file_name = file_name_path[file_name_path.length-1];

			file_name_array[file_count] = file_name;
			file_count++;
		}
	});

	for(var i = 0; i < file_count; i++){
		duplicate_count = 0;

		for(var j = 0; j < file_count; j++){
			if(file_name_array[i] === file_name_array[j]){ duplicate_count++; }
		}

		if(duplicate_count > 1){
			duplicate_msg += 'Duplicate file "' + file_name_array[i] + '" detected in slot ' + (i + 1) + ".\n";
			found_duplicate = true;
		}
	}

	if(found_duplicate){
		alert(duplicate_msg);
		return true;
	}
	else{ return false; }
}

function resetForm(){ location.href = self.location; }
function showDebugMessage(message){ JQ("#ubr_debug").append(message + "<br>"); }
function clearDebugMessage(){ JQ("#ubr_debug").html(""); }
function showAlertMessage(message){ JQ("#ubr_alert").html(message); }
function clearAlertMessage(){ JQ("#ubr_alert").html(""); }

function stopDataLoop(){
	clearInterval(UP_timer);
	clearInterval(BPB_timer);
	CPB_loop = false;
}

// Initialize the file upload page
function iniFilePage(){
	resetProgressBar();
	clearAlertMessage();

	JQ(":file").each(function(){
		JQ(this).attr("disabled", false);
		JQ(this).val("");
	});

	JQ("#upload_button").attr("disabled", false);
	JQ("#progress_bar").hide();
	document.uu_upload.reset();
}

// Reset the progress bar
function resetProgressBar(){
	CPB_loop = false;
	clearInterval(BPB_timer);
	clearInterval(UP_timer);
	seconds = 0;
	minutes = 0;
	hours = 0;
	CPB_width = 0;
	CPB_bytes = 0;
	CPB_hold = true;
	total_upload_size = 0;
	total_kbytes = 0;

	JQ("#upload_status").css("width", "0px");

	if(show_percent_complete){ JQ("#percent_complete").html("0%"); }
	if(show_files_uploaded){ JQ("#files_uploaded").html("0"); }
	if(show_files_uploaded){ JQ("#total_uploads").html(""); }
	if(show_current_position){ JQ("#current_position").html("0"); }
	if(show_current_position){ JQ("#total_kbytes").html(""); }
	if(show_elapsed_time){ JQ("#elapsed_time").html("00:00:00"); }
	if(show_est_time_left){ JQ("#est_time_left").html("00:00:00"); }
	if(show_est_speed){ JQ("#est_speed").html("0"); }
}

// Link the upload
function linkUpload(){
	if(checkFileNameFormat()){ return false; }
	if(checkAllowFileExtensions()){ return false; }
	if(checkDisallowFileExtensions()){ return false; }
	if(checkNullFileCount()){ return false; }
	if(checkDuplicateFileCount()){ return false; }

	JQ("#upload_button").attr("disabled", true);

	if(show_files_uploaded){
		var total_uploads = 0;

		JQ(":file").each(function(){ if(JQ(this).val() != ""){ total_uploads++; } });
		JQ("#total_uploads").html(total_uploads);
	}

	JQ.getScript(path_to_link_script, function(){});
}

//Submit the upload form
function startUpload(upload_id, debug_upload){
	JQ("#uu_upload").attr("action", path_to_upload_script + "?upload_id=" + upload_id);
	JQ("#uu_upload").submit();
	JQ(":file").each(function(){ JQ(this).attr("disabled", true); });
	JQ("#upload_div").hide();

	if(!debug_upload){ initializeProgressBar(upload_id); }
}

// Stop the upload
function stopUpload(){
	try{ window.stop(); }
	catch(e){
		try{ document.execCommand("Stop"); }
		catch(e){}
	}

	JQ(":file").each(function(i){ JQ(this).attr("disabled", false); });
}

// Initialize progress bar
function initializeProgressBar(upload_id){
	JQ.getScript(path_to_set_progress_script + '?upload_id=' + upload_id, function(){});
}

// Get the progress of the upload
function getProgressStatus(){
	JQ.getScript(get_status_url, function(){});
}

//Start the progress bar
function startProgressBar(upload_id, upload_size, start_time){
	total_upload_size = upload_size;
	total_kbytes = Math.round(total_upload_size / 1024);
	CPB_loop = true;

	JQ("#progress_bar").show();
	showAlertMessage("Upload In Progress");

	if(show_current_position){ JQ("#total_kbytes").html(total_kbytes + " "); }
	if(show_elapsed_time){ UP_timer = setInterval("getElapsedTime()", 1000); }

	get_status_url = path_to_get_progress_script + "?upload_id=" + upload_id + "&start_time=" + start_time + "&total_upload_size=" + total_upload_size;
	getProgressStatus();

	if(cedric_progress_bar == 1){
		if(show_current_position){ smoothCedricBytes(); }
		smoothCedricStatus();
	}
}

// Calculate and display upload information
function setProgressStatus(total_bytes_read, files_uploaded, current_file, bytes_read, lapsed_time){
	var byte_speed = 0;
	var time_remaining = 0;

	if(lapsed_time > 0){ byte_speed = total_bytes_read / lapsed_time; }
	if(byte_speed > 0){ time_remaining = Math.round((total_upload_size - total_bytes_read) / byte_speed); }

	if(cedric_progress_bar == 1){
		if(byte_speed != 0){
			var temp_CPB_time_width = Math.round(total_upload_size * 1000 / (byte_speed * progress_bar_width));
			var temp_CPB_time_bytes = Math.round(1024000 / byte_speed);

			if(temp_CPB_time_width < 5001){ CPB_time_width = temp_CPB_time_width; }
			if(temp_CPB_time_bytes < 5001){ CPB_time_bytes = temp_CPB_time_bytes; }
		}
		else{
			CPB_time_width = 500;
			CPB_time_bytes = 15;
		}
	}

	// Calculate percent_complete finished
	var percent_complete = Math.floor(100 * parseInt(total_bytes_read) / parseInt(total_upload_size));
	var progress_bar_status = Math.floor(progress_bar_width * (parseInt(total_bytes_read) / parseInt(total_upload_size)));

	// Calculate time remaining
	var remaining_sec = (time_remaining % 60);
	var remaining_min = (((time_remaining - remaining_sec) % 3600) / 60);
	var remaining_hours = ((((time_remaining - remaining_sec) - (remaining_min * 60)) % 86400) / 3600);

	if(remaining_sec < 10){ remaining_sec = "0" + remaining_sec; }
	if(remaining_min < 10){ remaining_min = "0" + remaining_min; }
	if(remaining_hours < 10){ remaining_hours = "0" + remaining_hours; }

	var est_time_left = remaining_hours + ":" + remaining_min + ":" + remaining_sec;
	var est_speed = Math.round(byte_speed / 1024);
	var current_position = Math.round(total_bytes_read / 1024);

	if(cedric_progress_bar == 1){
		if(cedric_hold_to_sync){
			if(progress_bar_status < CPB_width){ CPB_hold = true; }
			else{
				CPB_hold = false;
				CPB_width = progress_bar_status;
				CPB_bytes = current_position;
			}
		}
		else{
			CPB_hold = false;
			CPB_width = progress_bar_status;
			CPB_bytes = current_position;
		}

		JQ("#upload_status").css("width", progress_bar_status + "px");
	}
	else if(bucket_progress_bar == 1){
		BPB_width_old = BPB_width_new;
		BPB_width_new = progress_bar_status;

		if((BPB_width_inc < BPB_width_old) && (BPB_width_new > BPB_width_old)){ BPB_width_inc = BPB_width_old; }

		clearInterval(BPB_timer);
		BPB_timer = setInterval("incrementProgressBar()", 10);
	}
	else{ JQ("#upload_status").css("width", progress_bar_status + "px"); }

	if(show_current_position){ JQ("#current_position").html(current_position); }
	if(show_current_file){ JQ("#current_file").html(current_file); }
	if(show_percent_complete){ JQ("#percent_complete").html(percent_complete + "%"); }
	if(show_files_uploaded){ if(files_uploaded > 0){ JQ("#files_uploaded").html(files_uploaded); } }
	if(show_est_time_left){ JQ("#est_time_left").html(est_time_left); }
	if(show_est_speed){ JQ("#est_speed").html(est_speed); }
}

function incrementProgressBar(){
	if(BPB_width_inc < BPB_width_new){
		BPB_width_inc++;
		JQ("#upload_status").css("width", BPB_width_inc + "px");
	}
}

// Make the progress bar smooth
function smoothCedricStatus(){
	if(CPB_width < progress_bar_width && !CPB_hold){
		CPB_width++;
		JQ("#upload_status").css("width", CPB_width + "px");
	}

	if(CPB_loop){
		clearTimeout(CPB_status_timer);
		CPB_status_timer = setTimeout("smoothCedricStatus()", CPB_time_width);
	}
}

// Make the bytes uploaded smooth
function smoothCedricBytes(){
	if(CPB_bytes < total_kbytes && !CPB_hold){
		CPB_bytes++;
		JQ("#current_position").html(CPB_bytes);
	}

	if(CPB_loop){
		clearTimeout(CPB_byte_timer);
		CPB_byte_timer = setTimeout("smoothCedricBytes()", CPB_time_bytes);
	}
}

// Calculate the time spent uploading
function getElapsedTime(){
	seconds++;

	if(seconds == 60){
		seconds = 0;
		minutes++;
	}

	if(minutes == 60){
		minutes = 0;
		hours++;
	}

	var hr = "" + ((hours < 10) ? "0" : "") + hours;
	var min = "" + ((minutes < 10) ? "0" : "") + minutes;
	var sec = "" + ((seconds < 10) ? "0" : "") + seconds;

	JQ("#elapsed_time").html(hr + ":" + min + ":" + sec);
}

// Add one upload slot
function addUploadSlot(num){
	if(upload_range < max_upload_slots){
		if(num == upload_range){
			JQ("#upload_slots").append('<div><input type="file" class="ubrUploadSlot" id="upfile_' + upload_range + '" name="upfile_' + upload_range + '" size="90" value=""></div>');
			JQ("#upfile_" + upload_range).bind("keypress", function(e){ if(e == 13){ return false; } });
			JQ("#upfile_" + upload_range).bind("change", function(e){ addUploadSlot(upload_range); });
			upload_range++;
		}
	}
}
