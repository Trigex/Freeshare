<?php

if (function_exists('set_time_limit')) {
    @set_time_limit(0);
}

function upgrade_next_step($version_new = '', $next_step = '') {
    global $config;

    if ($version_new != '') {
        echo '<p class="upgrade-finished">vShare upgraded from version ' . $config['version'] . " to $version_new</p>";
    }

    if ($next_step == '') {
        $redirect_url = VSHARE_URL . '/install/upgrade_start.php';
    } else {
        $redirect_url = $next_step;
    }

    echo <<<EOT
    <br>
    <form action="$redirect_url" method="post">
    <input type="submit" name="submit" class="btn btn-default btn-lg" value="Continue with upgrade &raquo;">
    </form>
    <br>
EOT;

    require './tpl/footer.php';
    exit();
}
