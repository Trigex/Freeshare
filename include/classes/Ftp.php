<?php

class Ftp
{
    public $log_file_name = '';
    private $debug = 0;
    private $video_id = 0;
    private $conn_id;
    private $must_upload = 0;
    private $user_id;
    private $server_id = 0;

    private $video_info = array();
    private $server_info = array();

    function Ftp()
    {
        $this->log('<p>Initialize Ftp class</p>');
    }

    function select_video_server()
    {
        if ($this->video_info['video_server_id'] != 0) {
            $sql = "SELECT * FROM `servers` WHERE
                   `id`='" . (int) $this->video_info['video_server_id'] . "' AND
                   `status`='1'";
        } else if ($this->server_id != 0) {
            $sql = "SELECT * FROM `servers` WHERE
        		   `id`='" . (int) $this->server_id . "' AND
        		   `status`=1";
        } else {
            $sql = "SELECT * FROM `servers` WHERE
                   `server_type`!='1' AND
                   `status`='1'
                    ORDER BY `space_used` ASC
                    LIMIT 1";
        }

        $this->server_info = DB::fetch1($sql);

        if (! $this->server_info) {
            return 0;
        } else {
            return 1;
        }
    }

    function select_thumb_server($server_id=0)
    {
        if ($server_id != 0) {
            $sql = "SELECT * FROM `servers` WHERE
                   `id`='". (int) $server_id ."' AND
                   `status`='1'";
        } else if($this->video_info['video_thumb_server_id'] == 0) {
            $sql = "SELECT * FROM `servers` WHERE
                   `server_type`='1' AND
                   `status`='1' ORDER BY `space_used` ASC
                    LIMIT 1";
        } else {
            $sql = "SELECT * FROM `servers` WHERE
                   `id`='". (int) $this->video_info['video_thumb_server_id'] ."' AND
                   `status`='1'";
        }

        $this->server_info = DB::fetch1($sql);

        if (! $this->server_info) {
            return 0;
        } else {
            return 1;
        }
    }

    function connect()
    {
        $this->log('<p><b>Connecting to FTP server</b></p>');
        $this->log('<p>server_id = ' . $this->server_info['id'] . '<br>');
        $this->log('Server IP = ' . $this->server_info['ip'] . '<br>');
        $this->log('Server URL = ' . $this->server_info['url'] . '<br>');
        $this->log('Server folder = ' . $this->server_info['folder'] . '</p>');

        if (! $this->conn_id = ftp_connect($this->server_info['ip'])) {
            $this->log('<p class="error">ERROR: ftp connection failed.</p>');
            return 0;
        } else {
            $this->log('<p><b>FTP: connected</b></p>');
        }

        if (! ftp_login($this->conn_id, $this->server_info['user_name'], $this->server_info['password'])) {
            $this->log('<p class="error"><b>ERROR:</b> FTP authentication failed. Check FTP user name and password.</p>');
            return 0;
        } else {
            $this->log('<p>FTP: logged in.</p>');
        }

        if (! $this->ftp_cd($this->server_info['folder'])) {
            $this->log('<p>ERROR: ftp_chdir(' . $this->server_info['folder'] . ')</p>');
            return 0;
        }

        return 1;
    }

    function ftp_cd($folder)
    {
        $sub_folders = explode('/', $folder);

        for ($i = 0; $i < count($sub_folders); $i ++) {
            $folder = trim($sub_folders[$i]);
            if ($folder != '') {
                if (! $this->chdir($folder)) {
                    return 0;
                }
            }
        }
        return 1;
    }

    function chdir($folder)
    {
        $this->log('<p>ftp_chdir(' . $folder . ')</p>');

        if (! ftp_chdir($this->conn_id, $folder)) {
            if (! @ftp_mkdir($this->conn_id, $folder)) {
                $this->log('FTP ERROR: There was a problem while creating ' . $folder . '</p>');
                return 0;
            } else {
                if (! ftp_chdir($this->conn_id, $folder)) {
                    $this->log('<p>Failed changing folder: ' . $folder . '</p>');
                    $this->log('<p>Current Folder is : ' . ftp_pwd($this->conn_id) . '</p>');
                    return 0;
                }
            }
        }

        $this->log('<p>ftp_pwd = ' . ftp_pwd($this->conn_id) . '</p>');
        return 1;
    }

    function initialize($config = array())
    {
        $this->video_id = $config['video_id'];
        $this->log_file_name = $config['log_file_name'];
        $this->must_upload = isset($config['must_upload']) ? $config['must_upload'] : '';
        $this->debug = isset($config['debug']) ? $config['debug'] : 0;
        $this->user_id = isset($config['user_id']) ? $config['user_id'] : 0;
        $this->server_id = isset($config['server_id']) ? $config['server_id'] : 0;
    }

    function upload_video($config)
    {
        $this->initialize($config);
        $this->video_info = Video::getById($this->video_id);

        if (! $this->select_video_server($this->video_info['video_thumb_server_id'])) {
            $this->log('<p>Unable to select FTP server.</p>');
            return 0;
        }

        if (! $this->connect()) {
            if ($this->must_upload) {
                $flv_path = VSHARE_DIR . '/flvideo/' . $this->video_info['video_folder'] . $this->server_info['video_flv_name'];
                unlink($flv_path);
                $this->log('<p>Video conversion could not continue as FTP server login failed.</p>');
                $this->log('<p>Local file deleted: ' . $flv_path . '</p>');
            }
            $this->log('<p>Failed FTP login, exiting.</p>');
            return 0;
        }

        $this->ftp_cd($this->video_info['video_folder']);

        $source_flv_path = VSHARE_DIR . '/flvideo/' . $this->video_info['video_folder'] . $this->video_info['video_flv_name'];

        if (! file_exists($source_flv_path)) {
            $this->log('<p class="error">File not found: ' . $source_flv_path . '</p>');
            return 0;
        }

        if (! $this->put($this->video_info['video_flv_name'], $source_flv_path)) {
            $this->log('<p>ERROR: put(' . $this->video_info['video_flv_name'] . ',' . $source_flv_path . ')</p>');
            return 0;
        }

        $this->log('<p>FLV file uploaded : ' . $source_flv_path . '</p>');

        if ($this->video_info['video_server_id'] != $this->server_info['id']) {
            $sql = "UPDATE `videos` SET
                   `video_server_id`='" . (int) $this->server_info['id'] . "' WHERE
                   `video_id`='" . (int) $this->video_info['video_id'] . "'";
            DB::query($sql);
        }

        if (Config::get('video_flv_delete') == 1) {
            unlink($source_flv_path);
            $this->log('<p>unlink(' . $source_flv_path . ')</p>');
        } else {
            $this->log('<p><u>FLV NOT DELETED FROM LOCAL SERVER</u></p>');
        }

        $this->close();
        return 1;
    }

    function upload_thumb($config)
    {
        $this->initialize($config);
        $this->video_info = Video::getById($this->video_id);

        if (! $this->select_thumb_server()) {
            $this->log('<p>Unable to select FTP server.</p>');
            return 0;
        }

        if (! $this->connect()) {
            $this->log('<p>Failed FTP login, exiting.</p>');
            return 0;
        }

        if (! $this->ftp_cd('thumb')) {
            $this->log('<p>FTP ERROR: chdir("thumb").</p>');
            return 0;
        }

        $source_thumb_path = VSHARE_DIR . '/thumb/' . $this->video_info['video_folder'] . $this->video_id . '.jpg';
        $source_thumb_path_real = 1;
        if (! file_exists($source_thumb_path)) {
            $this->log('<p>Thumbnail image missing :' . $source_thumb_path . '</p>');
            $source_thumb_path = VSHARE_DIR . '/themes/default/images/no_thumbnail.gif';
            $source_thumb_path_real = 0;
        }

        if (! $this->ftp_cd($this->video_info['video_folder'])) {
            $this->log('<p>FTP ERROR: failed ftp_cd : <b>' . $this->video_info['video_folder'] . '</b></p>');
            return 0;
        }

        $thumb_name = $this->video_id . '.jpg';

        if (! $this->put($thumb_name, $source_thumb_path)) {
            $this->log('<p>FTP ERROR: put(' . $thumb_name . ',' . $source_thumb_path . ')</p>');
            return 0;
        }

        if ($source_thumb_path_real == 1) {
            if (unlink($source_thumb_path)) {
                $this->log('<p>Deleting local thumb = ' . $source_thumb_path . '</p>');
            } else {
                $this->log('<p>ERROR: deleting file : ' . $source_thumb_path . '</p>');
            }
        }

        for ($i = 1; $i <= 3; $i ++) {
            $thumb_name = $i . '_' . $this->video_id . '.jpg';
            $source_thumb_path = VSHARE_DIR . '/thumb/' . $this->video_info['video_folder'] . $thumb_name;
            $source_thumb_path_real = 1;

            if (! file_exists($source_thumb_path)) {
                $this->log('<p>Thumbnail image missing :' . $source_thumb_path . '</p>');
                $source_thumb_path = VSHARE_DIR . '/themes/default/images/no_thumbnail.gif';
                $source_thumb_path_real = 0;
            }

            if (! $this->put($thumb_name, $source_thumb_path)) {
                $this->log('<p>FTP ERROR: put(' . $thumb_name . ',' . $source_thumb_path . ')</p>');
            }

            if ($source_thumb_path_real == 1) {
                if (unlink($source_thumb_path)) {
                    $this->log('<p>Deleted local thumb = ' . $source_thumb_path . '</p>');
                } else {
                    $this->log('<p>ERROR: deleting file : ' . $source_thumb_path . '</p>');
                }
            }
        }

        $sql = "UPDATE `videos` SET
        	   `video_thumb_server_id`='" . (int) $this->server_info['id'] . "' WHERE
        	   `video_id`='" . (int) $this->video_id . "'";
        DB::query($sql);

        $sql = "UPDATE `servers` SET
               `space_used`=`space_used`+4 WHERE
               `id`='" . (int) $this->server_info['id'] . "'";
        DB::query($sql);

        $this->close();
        return 1;
    }

    function put($file_name, $source)
    {
        if (! @ftp_put($this->conn_id, $file_name, $source, FTP_BINARY)) {
            return 0;
        }
        return 1;
    }

    function delete_video($config)
    {
        $this->initialize($config);
        $this->video_info = Video::getById($this->video_id);

        if (! $this->select_video_server()) {
            $this->log('<p>Unable to select FTP server.</p>');
            return 0;
        }

        if (! $this->connect()) {
            $this->log('<p>Failed FTP login, exiting.</p>');
            return 0;
        }

        if (! $this->ftp_cd($this->video_info['video_folder'])) {
            $this->log('<p>FTP ERROR: chdir("$this->video_info[video_folder]").</p>');
            return 0;
        }

        $file = $this->video_info['video_flv_name'];
        return $this->delete($file);
    }

    function delete_thumb($config)
    {
        $this->initialize($config);
        $this->video_info = Video::getById($this->video_id);

        if (! $this->select_thumb_server()) {
            $this->log('<p>Unable to select FTP server.</p>');
            return 0;
        }

        if (! $this->connect()) {
            $this->log('<p>Failed FTP login, exiting.</p>');
            return 0;
        }

        if (! $this->ftp_cd('thumb')) {
            $this->log('<p>FTP ERROR: chdir("thumb").</p>');
            return 0;
        }

        if (! $this->ftp_cd($this->video_info['video_folder'])) {
            $this->log('<p>FTP ERROR: chdir("$this->video_info[video_folder]").</p>');
            return 0;
        }

        $thumb_path = $this->video_id . '.jpg';
        $this->delete($thumb_path);

        for ($i = 1; $i <= 3; $i ++) {
            $thumb_path =  $i . '_' . $this->video_id . '.jpg';
            $this->delete($thumb_path);
        }

        $sql = "UPDATE `servers` SET
               `space_used`=`space_used`-4 WHERE
               `id`='" . (int) $this->server_info['id'] . "'";
        DB::query($sql);
    }

    function delete($file)
    {
        if (ftp_delete($this->conn_id, $file)) {
            $this->log('Successfully delete file: ' . $file . '<br />');
            return 1;
        } else {
            $this->log('File delete failed :' . $file . '<br />');
            return 0;
        }
    }

    function video_rename($ftp_config)
    {
        $this->initialize($ftp_config);
        $flv_name_source = $ftp_config['flv_name_source'];
        $flv_name_new = $ftp_config['flv_name_new'];

        if (! $this->select_video_server()) {
            $this->log('<p>Unable to select FTP server.</p>');
            return 0;
        }

        if (! $this->connect()) {
            $this->log('<p>Failed FTP login, exiting.</p>');
            return 0;
        }

        if (! $this->ftp_cd($ftp_config['video_folder'])) {
            $this->log('<p>Failed to change folder.</p>');
            return 0;
        }

        if ($this->rename("$flv_name_source", "$flv_name_new")) {
            return 1;
        } else {
            $this->log('<p>Failed to rename file.</p>');
            return 0;
        }
    }

    function rename($old_filename, $new_filename)
    {
        if (ftp_rename($this->conn_id, $old_filename, $new_filename)) {
            $this->log('Successfully renamed file: ' . $old_filename . ' to ' . $new_filename);
            return 1;
        } else {
            $this->log('There was a problem while renaming ' . $old_filename . ' to ' . $new_filename);
            return 0;
        }
    }

    function log($msg)
    {
        write_log($msg, $this->log_file_name, $this->debug, 'html');
    }

    function close()
    {
        ftp_close($this->conn_id);
        $this->log('<p>Ftp connection closed</p>');
    }
}
