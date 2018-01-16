<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#vshare-admin-main-menu">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">
        <img class="brand" src="{$baseurl}/themes/admin/images/logo_admin.png">
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="vshare-admin-main-menu">

        <ul class="nav navbar-nav">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-wrench"></span> Configuration <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="settings.php">Site Settings</a></li>
                    <li><a href="settings_video.php">Video Settings</a></li>
                    <li><a href="settings_signup.php">Signup Settings</a></li>
                    <li><a href="settings_player.php">Player Settings</a></li>
                    <li><a href="settings_miscellaneous.php">Miscellaneous</a></li>
                    <li><a href="settings_home.php">Home Page</a></li>
                    <li class="divider"></li>
                    <li><a href="advertisements.php">Advertisements</a></li>
                    <li><a href="email_templates.php">Email Templates</a></li>
                    <li class="divider"></li>
                    <li><a href="server_manage.php">List Server</a></li>
                    <li><a href="server_add.php">Add Server</a></li>
               </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>  Users <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="users.php">All Users</a></li>
                    <li><a href="users.php?a=Active">Active Users</a></li>
                    <li><a href="users.php?a=Inactive">Inactive Users</a></li>
                    <li><a href="users.php?a=Suspended">Suspend Users</a></li>
                    <li><a href="user_search.php">Search Users</a></li>
                    <li><a href="mail_users.php?a=user">Email Users</a></li>
                    <li><a href="user_add.php">Add User</a></li>
               </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-facetime-video"></span>  Videos <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="videos.php">All Videos</a></li>
                    <li><a href="video_approve.php">Approve Videos</a></li>
                    <li><a href="videos.php?a=public">Public Videos</a></li>
                    <li><a href="videos.php?a=private">Private Videos</a></li>
                    {if $family_filter}
                    <li><a href="videos.php?a=adult">Adult Videos</a></li>
                    {/if}
                    <li><a href="video_inactive.php">Inactive Videos</a></li>
                    <li><a href="video_featured.php">Featured Videos</a></li>
                    <li><a href="video_feature_requests.php">Feature Requests</a></li>
                    <li><a href="videos_inappropriate.php">Flagged Videos</a></li>
                    <li><a href="comment.php">Manage Comments</a></li>
                    <li><a href="video_user_deleted.php">User Deleted Videos</a></li>
                    <li><a href="video_search.php">Search Videos</a></li>
                    <li><a href="tags.php">Tags</a></li>
                    <li><a href="video_local.php">Local Videos</a></li>
                    <li><a href="videos.php?a=embedded">Embedded Videos</a></li>
               </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-save"></span> Add Videos <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="import_youtube_video.php">Add Youtube Video</a></li>
                    <li><a href="import_embed_video.php">Add Embed Video</a></li>
                    <li><a href="import_remote_video.php">Add Remote Video (Hotlink)</a></li>
                    <li><a href="import_bulk.php">Bulk Import</a></li>
                    <li><a href="import_video.php">Import Video</a></li>
                    <li><a href="import_folder.php">Import Folder</a></li>
                </ul>
            </li>

            <li><a href="process_queue.php"><span class="glyphicon glyphicon-folder-open"></span> Process Queue</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Manage <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="channels.php">View Channels</a></li>
                    <li><a href="channel_add.php">Add Channels</a></li>
                    <li><a href="channel_search.php">Search Channels</a></li>
                    <li><a href="channel_sort.php">Sort Channels</a></li>
                    <li class="divider"></li>
                    <li><a href="groups.php">All Groups</a></li>
                    <li><a href="groups.php?a=public">Public Groups</a></li>
                    <li><a href="groups.php?a=private">Private Groups</a></li>
                    <li><a href="groups.php?a=protected">Protected Groups</a></li>
                    <li><a href="group_search.php">Search Groups</a></li>
                    <li class="divider"></li>
                    <li><a href="poll_list.php">View Polls</a></li>
                    <li><a href="poll_add.php">Add New Poll</a></li>
                    <li class="divider"></li>
                    <li><a href="page.php">List Pages</a></li>
                    <li><a href="page_add.php">Add Page</a></li>
                    <li class="divider"></li>
                    <li><a href="bad_words.php">Bad Words</a></li>
                    <li><a href="reserve_user_name.php">Reserve User Name</a></li>
                </ul>
            </li>


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span> More <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    {if $enable_package eq "yes"}
                    <li><a href="payments.php">Payments</a></li>
                    <li><a href="packages.php">Packages</a></li>
                    <li><a href="package_add.php">Add New Package</a></li>
                    <li><a href="subscription_extend.php">Extend Subscription</a></li>
                    <li><a href="subscription_edit.php">Edit Subscription</a></li>
                    <li class="divider"></li>
                    {/if}
                    <li><a href="sitemap.php">Site Map</a></li>
                    <li><a href="update_counters.php">Update Counters</a></li>
                    <li><a href="tags_regenerate.php">Regenerate Tags</a></li>
                    <li><a href="thumbs_regenerate.php">Regenerate Thumbs</a></li>
                    <li><a href="users_inactive_delete.php">Delete Inactive Users</a></li>
                    <li><a href="phpinfo.php">View PHP Info</a></li>
                    {if $episode_enable eq '1'}
                    <li class="divider"></li>
                    <li><a href="episodes.php">Episodes</a></li>
                    {/if}
                </ul>
            </li>

        </ul>

        <ul class="nav navbar-nav pull-right">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle">
                    <span class="glyphicon glyphicon-user"></span>
                    Admin <span class="caret"></span>
                </a>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="admin_log.php"><span class="glyphicon glyphicon-book"></span> Admin Log</a></li>
                    <li><a href="change_password.php"><span class="glyphicon glyphicon-wrench"></span> Admin Password</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </li>
        </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
