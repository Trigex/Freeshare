(function() {
    var bar = $(".bar");
    var percent = $(".percent");
    var status = $("#status");
    var upload_button = $("#profileCoverModal button[type='submit']");

    $("form").ajaxForm({
        dataType: 'json',
        beforeSubmit: function(arr, $form, options) {
            var filesize = $("input[name=cover_photo]").get(0).files[0].size;
            var upload_max_filesize = 1024 * 1024;
            if (filesize > upload_max_filesize) {
                status.html('<span class="alert alert-danger">You can only upload photos with file size upto 2MB.</span>');
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
        },
        success: function(msg) {
            var percentVal = "100%";

            if (msg.messageType == 'success') {
                var percentVal = "0%";
                var profile_cover_src = baseurl + '/photo/cover/' + user_id + '.jpg';
                $("img.profile-cover").attr("src", profile_cover_src + '?' + Math.random());
                $('#profileCoverModal').modal('hide');
            } else {
                status.html('<span class="alert alert-danger">' + msg.message + '</span>');
                upload_button.prop("disabled", false);
            }

            bar.width(percentVal);
            percent.html(percentVal);
            upload_button.prop("disabled", false);
        },
        resetForm: true
    });

})();