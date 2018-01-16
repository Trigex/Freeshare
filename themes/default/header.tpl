<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{if $html_title ne ""}{$html_title} - {$site_name}{else}{$site_name} - Share Your Videos{/if}</title>
<meta name="keywords" content="{if $html_keywords ne ""}{$html_keywords}, {/if}{$meta_keywords}" />
<meta name="description" content="{if $html_description ne ""}{$html_description} {/if}{$meta_description}" />
<link href="{$base_url}/css/bootstrap.min.css" rel="stylesheet">
<link href="{$base_url}/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="{$base_url}/themes/default/css/style.css" rel="stylesheet">
<link rel="alternate" type="application/rss+xml" title="20 Latest videos" href="{$base_url}/rss/new/" />
<link rel="alternate" type="application/rss+xml" title="20 Most Viewed Videos" href="{$base_url}/rss/views/" />
<link rel="alternate" type="application/rss+xml" title="20 Most Commented Videos" href="{$base_url}/rss/comments/" />
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery-1.11.0.min.js"></script>
{$html_head_extra}
</head>
<body>

<div class="container">
    <div class="row hidden-xs">
        <header class="col-md-12">

            <div class="col-md-3">
                <h1>
                    <a href="{$base_url}/" title="{$site_name}">
                        <img class="img-responsive" src="{$logo_url_md}" alt="{$site_name}">
                    </a>
                </h1>
            </div>

            <div class="col-md-5 col-sm-6">
                <form method="get" action="{$base_url}/search_videos.php" class="form-horizontal search">
                    <input type="hidden" name="type" value="video">
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" placeholder="Search" required value="{$smarty.request.search_string}" name="search_string" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4 col-sm-6 top-usernav text-right">
                <div class="btn-group">
                    {if $smarty.session.USERNAME ne ""}
                    <a href="{$base_url}/{$smarty.session.USERNAME}" class="text-nowrap btn btn-primary" data-toggle="dropdown" aria-expanded="false">
                    <span class="glyphicon glyphicon-user"></span> {$smarty.session.USERNAME} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}">My profile</a></li>
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}/account/">My Account</a></li>
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}/public/">Public Videos</a></li>
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}/private/">Private Videos</a></li>
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}/favorites/">Favorites</a></li>
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}/friends/">Friends</a></li>
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}/playlist/">Playlist</a></li>
                        <li><a href="{$base_url}/{$smarty.session.USERNAME}/groups/">Groups</a></li>
                        <li class="divider"></li>
                        <li><a href="{$base_url}/password/">Change Password</a></li>
                    </ul>

                    <a class="text-nowrap btn btn-primary" href="{$base_url}/mail.php?folder=inbox">
                        <span class="glyphicon glyphicon-envelope"></span>
                        ({insert name="msg_count" assign=total_msg}{$total_msg})
                    </a>

                    <a class="text-nowrap btn btn-primary" href="{$base_url}/logout/" class="bold">
                        <span class="glyphicon glyphicon-log-out"></span> Log Out
                    </a>

                    {else}
                    <a class="text-nowrap btn btn-primary" href="{$base_url}/signup/">Sign Up</a>
                    <a class="text-nowrap btn btn-primary" href="{$base_url}/login/">Log In</a>
                    {/if}
                </div>
            </div>

        </header>
    </div>


<div class="row">
    <div class="col-md-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand navbar-brand-vshare visible-xs" href="{$base_url}/" title="{$site_name}">
                                <img class="img-responsive" src="{$logo_url_sm}" alt="{$site_name}">
                            </a>
                            <div class="pull-right dropdown visible-xs">
                                <button class="btn btn-xs dropdown-toggle navbar-toggle navbar-btn-vshare" data-toggle="dropdown" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user"></span> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    {if $smarty.session.USERNAME ne ""}
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}">My profile</a></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/account/">My Account</a></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/public/">Public Videos</a></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/private/">Private Videos</a></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/favorites/">Favorites</a></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/friends/">Friends</a></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/playlist/">Playlist</a></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/groups/">Groups</a></li>
                                    <li><a href="{$base_url}/mail.php?folder=inbox">Inbox <span class="badge">{$total_msg}</span></a></li>
                                    <li class="divider"></li>
                                    <li><a href="{$base_url}/{$smarty.session.USERNAME}/change_password/">Change Password</a></li>
                                    <li><a href="{$base_url}/logout/">Log Out</a></li>
                                    {else}
                                    <li><a href="{$base_url}/signup/">Sign Up</a></li>
                                    <li><a href="{$base_url}/login/">Log In</a></li>
                                    {/if}
                                </ul>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <div class="row">
                                <ul class="nav nav-tabs navbar-nav nav-justified">
                                    <li><a class="no-bdr" href="{$base_url}/"><strong>HOME</strong></a></li>
                                    <li><a href="{$base_url}/upload/"><strong>UPLOAD</strong></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <strong>WATCH</strong> <span class="caret"></span>
                                        </a>
                                        {include file="menu_watch.tpl"}
                                    </li>
                                    <li><a href="{$base_url}/tags/"><strong>TAGS</strong></a></li>
                                    <li><a href="{$base_url}/channels/"><strong>CHANNELS</strong></a></li>
                                    <li><a href="{$base_url}/groups/featured/1"><strong>GROUPS</strong></a></li>
                                    <li><a href="{$base_url}/friends/"><strong>FRIENDS</strong></a></li>
                                    <li><a href="{$base_url}/members/"><strong>PEOPLE</strong></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="row search-box-xs visible-xs">
                <form method="get" action="{$base_url}/search_videos.php" class="form-horizontal">
                    <input type="hidden" name="type" value="video">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input class="form-control" placeholder="Search" required value="{$smarty.request.search_string}" name="search_string" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>

    {if $sub_menu ne ""}
        <div id="menu-sub">
            {include file=$sub_menu}
        </div>
    {/if}

    {insert name=advertise adv_name='banner_top'}

    {*{include file="search_box.tpl"}*}

    <div class="row row-offcanvas row-offcanvas-left">

        {include file="error.tpl"}
