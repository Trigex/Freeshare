(function() {
    var bar = $(".bar");
    var percent = $(".percent");
    var status = $("#status");
    var upload_id = $("input#upload_id").val();
    var upload_button = $("button[type='submit']");

    $("form").ajaxForm({
        beforeSubmit: function(arr, $form, options) {
            var filesize = $("input[name=upfile_0]").get(0).files[0].size;
            var upload_max_filesize_mb = upload_max_filesize / (1024 * 1024);
            if (filesize > upload_max_filesize) {
                status.html('<span class="alert alert-danger">You can only upload videos with file size upto ' + upload_max_filesize_mb + 'MB.</span>');
                return false;
            }
        },
        beforeSend: function() {
            status.empty();
            var percentVal = "0%";
            bar.width(percentVal)
            percent.html(percentVal);
            upload_button.prop("disabled", true);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + "%";
            bar.width(percentVal)
            percent.html(percentVal);
            //console.log(percentVal, position, total);
            if (percentComplete > 98) {
                $("div#processing").show();
            }
        },
        success: function() {
            var percentVal = "100%";
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function(xhr) {
            if (isNaN(xhr.responseText)) {
                status.html('<span class="alert alert-danger">' + xhr.responseText + '</span>');
                $("#processing").hide();
                bar.width('0%')
                percent.html('0%');
                upload_button.prop("disabled", false);
            } else {
                document.location = baseurl +"/upload/success/" + xhr.responseText + "/" + upload_id + "/";
            }
        }
    });

})();