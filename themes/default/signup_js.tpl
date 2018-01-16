<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>

{literal}

<script type="text/javascript">
    $('#signup-form').validate({
                rules: {
                    user_name: {
                        required: true,
                        minlength: 4,
                        remote: {
	                    url: baseurl + "/ajax/username_check.php",
	                    type: "get",
	                    data: {
	                        user_name: function() {
	                            return $("#signup-form #user_name").val();
	                        }
	                    }
                        }
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 4
                    },
                    password_confirm: {
                        required: true,
                        minlength: 4,
                        equalTo: "#password"
                    },
                    security_code: "required"
                },
                messages: {
                    user_name: {
                        required: "Please enter a username",
                        minlength: "Username is too short",
                        remote: "Username is not available"
                    },
                    email: "Email is required",
                    password: "Please enter a password",
                    password_confirm: "Passwords don't match.",
                    security_code: "Please Enter Security Code"
                }
        });
  </script>

{/literal}
