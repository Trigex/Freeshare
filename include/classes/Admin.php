<?php

class Admin
{
    public static function auth()
    {
        global $config;
        $admin_loged_in = 0;
        if (isset($_SESSION['AUID']) && isset($_SESSION['APASSWORD'])) {
            if (($_SESSION['AUID'] == $config['admin_name']) && ($_SESSION['APASSWORD'] == $config['admin_pass'])) {
                $admin_loged_in = 1;
            }
        }

        if (! $admin_loged_in) {
            set_message('You are not logged in.', 'error');
            $redirect_url = $config['baseurl'] . '/admin/index.php';
            Http::redirect($redirect_url);
        }

        write_admin_log();
    }
}
