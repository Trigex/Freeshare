<h1>User: {$user.user_name}</h1>

<table class="table table-striped table-hover">

<tr>
<td>User ID </td>
<td>{$user.user_id}</td>
</tr>

<tr>
<td>User Name </td>
<td>{$user.user_name}</td>
</tr>

<tr>
<td> Email Address </td>
<td>{$user.user_email}</td>
</tr>

{if $user.user_first_name ne ""}
<tr>
<td>Full Name</td>
<td>{$user.user_first_name} {$user.user_last_name}</td>
</tr>
{/if}

{if $user.user_city ne ""}
<tr>
<td>City</td>
<td>{$user.user_city}</td>
</tr>
{/if}

{if $user.user_country ne ""}
<tr>
<td>Country</td>
<td>{$user.user_country}</td>
</tr>
{/if}

{insert name=subscriber_info assign=pack uid=$user.user_id}

{if $pack.pack_name ne ""}
<tr>
<td>Subscribed Package</td>
<td><a href="{$base_url}/admin/packages.php?a=Search&pack_id={$pack.pack_id}&page=">{$pack.pack_name}</a></td>
</tr>
{/if}

{if $pack.used_space ne ""}
<tr>
<td>Used Space</td>
<td>{insert name=format_size size=$pack.used_space}</td>
</tr>
{/if}

{if $pack.used_bw ne ""}
<tr>
<td>Used Bandwidth</td>
<td>{insert name=format_size size=$pack.used_bw}</td>
</tr>
{/if}

{if $pack.total_video ne ""}
<tr>
<td>Total Uploaded Video</td>
<td>{$pack.total_video}</td>
</tr>
{/if}

{if $pack.expired_time|date_format ne ""}
<tr>
<td> Expired Date</td>
<td>{$pack.expired_time|date_format}</td>
</tr>
{/if}

<hr />

{if $user.user_website ne ""}
<tr>
<td>Website</td>
<td>{$user.user_website}</td>
</tr>
{/if}

{if $user.user_occupation ne ""}
<tr>
<td>Occupation</td>
<td>{$user.user_occupation}</td>
</tr>
{/if}

{if $user.user_company ne ""}
<tr>
<td>Company Name</td>
<td>{$user.user_company}</td>
</tr>
{/if}

{if $user.user_school ne ""}
<tr>
<td>School</td>
<td>{$user.user_school}</td>
</tr>
{/if}

{if $user.user_interest_hobby ne ""}
<tr>
<td>Interest/Hobby</td>
<td>{$user.user_interest_hobby}</td>
</tr>
{/if}

{if $user_info.user_fav_movie_show ne ""}
<tr>
<td>Favorite Movie</td>
<td>{$user.user_fav_movie_show}</td>
</tr>
{/if}

{if $user.user_fav_book ne ""}
<tr>
<td>Favorite Book</td>
<td>{$user.user_fav_book}</td>
</tr>
{/if}

{if $user.user_fav_music ne ""}
<tr>
<td> Favorite Music</td>
<td>{$user.user_fav_music}</td>
</tr>
{/if}

{if $user.user_about_me ne ""}
<tr>
<td> About Me</td>
<td>{$user.user_about_me}</td>
</tr>
<hr />
{/if}

<tr>
<td>Video Viewed</td>
<td>{$user.user_video_viewed}</td>
</tr>

<tr>
<td>Profile Viewed</td>
<td>{$user.user_profile_viewed}</td>
</tr>

<tr>
<td>Watched Video</td>
<td>{$user.user_watched_video}</td>
</tr>

<tr>
<td>Join Date</td>
<td>{$user.user_join_time|date_format}</td>
</tr>

<div >
<td>Last Login</td>
<td>{$user.user_last_login_time|date_format}</td>
</tr>

<tr>
<td>Email Verified</td>
<td>{$user.user_email_verified}</td>
</tr>

<tr>
<td>Account Status</td>
<td>{$user.user_account_status}</td>
</tr>

</table>

<hr />

<div class="btn-group">
    <a href="user_edit.php?action=edit&uid={$user.user_id}&page={$smarty.request.page}" class="btn btn-default btn-lg">Edit</a>
    <a href="user_videos.php?uid={$user.user_id}" class="btn btn-default btn-lg">Videos</a>
    <a href="user_delete.php?uid={$user.user_id}" class="btn btn-danger btn-lg" onclick='Javascript:return confirm("Are you sure you want to delete?");'>Delete</a>
    <a href="mail_users.php?email={$user.user_email}&uname={$user.user_name}" class="btn btn-default btn-lg">Send Mail</a>
    <a href="user_login.php?username={$user.user_name}"  class="btn btn-default btn-lg" target="_blank">Login</a>
</div>
