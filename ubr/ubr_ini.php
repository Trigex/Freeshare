<?php
//******************************************************************************************************
//	Name: ubr_ini_progress.php
//	Revision: 2.5
//	Date: 10:26 PM Tuesday, January 13, 2009
//	Link: http://uber-uploader.sourceforge.net
//	Developer: Peter Schmandra
//	Description: Initializes Uber-Uploader
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

$TEMP_DIR                    =  VSHARE_DIR . '/templates_c/';             // *ATTENTION : The $TEMP_DIR value MUST be duplicated in the "ubr_upload.pl" file
$DATA_DELIMITER              = '<=>';                        // *ATTENTION : The $DATA_DELIMITER value MUST be duplicated in the "ubr_upload.pl" file

$UBER_VERSION                = '6.6';                        // Version of Uber-Uploader
$PATH_TO_UPLOAD_SCRIPT       = VSHARE_URL . '/cgi-bin/ubr_upload.pl';     // Path info
$PATH_TO_LINK_SCRIPT         = VSHARE_URL . '/ubr/ubr_link_upload.php';        // Path info
$PATH_TO_SET_PROGRESS_SCRIPT = VSHARE_URL . '/ubr/ubr_set_progress.php';       // Path info
$PATH_TO_GET_PROGRESS_SCRIPT = VSHARE_URL . '/ubr/ubr_get_progress.php';       // Path info
$PATH_TO_JS_SCRIPT           = VSHARE_URL . '/ubr/ubr_file_upload.js';         // Path info
$PATH_TO_JQUERY              = VSHARE_URL . '/ubr/jquery-1.3.1.min.js';        // Path Info
$PATH_TO_CSS_FILE            = VSHARE_URL . '/ubr/ubr.css';                    // Path info
$DEFAULT_CONFIG              = VSHARE_DIR . '/ubr/ubr_default_config.php';     // Path info
$MULTI_CONFIGS_ENABLED       = 0;                            // Enable/Disable multi config files
$CGI_UPLOAD_HOOK             = 0;                            // Use the CGI hook file to get upload status
$GET_PROGRESS_SPEED          = 5000;                         // CAUTION ! How frequent the web server is poled for upload status. 5000=5 seconds, 1000=1 second, 500=0.5 seconds, 250=0.25 seconds. etc.
$DELETE_LINK_FILE            = 1;                            // Enable/Disable delete link file
$DELETE_REDIRECT_FILE        = 1;                            // Enable/Disable delete redirect file
$PURGE_LINK_FILES            = 1;                            // Enable/Disable delete old upload_id.link files
$PURGE_LINK_LIMIT            = 300;                          // Delete old upload_id.link files older than X seconds
$PURGE_REDIRECT_FILES        = 1;                            // Enable/Disable delete old upload_id.redirect files
$PURGE_REDIRECT_LIMIT        = 300;                          // Delete old redirect files older than X seconds
$PURGE_TEMP_DIRS             = 1;                            // Enable/Disable delete old upload_id.dir directories
$PURGE_TEMP_DIRS_LIMIT       = 43200;                        // Delete old upload_id.dir directories older than X seconds (43200=12 hrs)
$TIMEOUT_LIMIT               = 6;                            // Max number of seconds to find the flength file
$DEBUG_AJAX                  = 0;                            // Enable/Disable AJAX debug mode. Add your own debug messages by calling the "showDebugMessage() " function. UPLOADS POSSIBLE.
$DEBUG_PHP                   = 0;                            // Enable/Disable PHP debug mode. Dumps your PHP settings to screen and exits. UPLOADS IMPOSSIBLE.
$DEBUG_CONFIG                = 0;                            // Enable/Disable config debug mode. Dumps the loaded config file to screen and exits. UPLOADS IMPOSSIBLE.
$DEBUG_UPLOAD                = 0;                            // Enable/Disable debug mode in uploader. Dumps your CGI and loaded config settings to screen and exits. UPLOADS IMPOSSIBLE.
$DEBUG_FINISHED              = 0;                            // Enable/Disable debug mode in the upload finished page. Dumps all values to screen and exits. UPLOADS POSSIBLE.
$PHP_ERROR_REPORTING         = 1;                            // Enable/Disable PHP error_reporting(E_ALL). UPLOADS POSSIBLE.

?>