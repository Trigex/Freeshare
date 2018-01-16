<div class="col-md-12 myaccount">
	<div class="page-header">
		<h2>
			Welcome,
			{if $smarty.session.USERNAME ne ""}
			{$smarty.session.USERNAME} {/if}
		</h2>
		<p class="lead text-muted">
			Now manage everything about your account from here
		</p>
	</div>

	<div class="col-md-3">
		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}">
			<span class="glyphicon glyphicon-eye-open"></span> My Profile
			</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/edit/">
			<span class="glyphicon glyphicon-edit"></span> Edit Profile
			</a>
		</h4>

		{if $enable_package eq "yes"}

		<h4>
			<a href="{$base_url}/renew_account.php?uid={$smarty.session.UID}&action=upgrade" style="text-decoration: none;">
			<span class="glyphicon glyphicon-upload"></span> Upgrade Package</a>
		</h4>

		{/if}

		<h4>
			<a href="{$base_url}/user_delete.php">
			<span class="glyphicon glyphicon-remove delete"></span> Delete Account</a>
		</h4>
	</div>


	<div class="col-md-3">
	<h4>
		<a href="{$base_url}/upload/">
		<span class="glyphicon glyphicon-film"></span> Upload Video</a>
	</h4>

	<h4>
		<a href="{$base_url}/user_photo_upload.php">
		<span class="glyphicon glyphicon-picture"></span> Upload Profile Photo</a>
	</h4>

	<h4>
		<a href="{$base_url}/privacy/">
		<span class="glyphicon glyphicon-lock"></span> Privacy Settings</a>
	</h4>
	</div>


	<div class="col-md-3">
		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/playlist/">
			<span class="glyphicon glyphicon-list"></span> My Playlists</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/favorites/">
			<span class="glyphicon glyphicon-heart"></span> My Favorites</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/groups/">
			<span class="glyphicon glyphicon-user"></span> My Groups</a>
		</h4>
	</div>

	<div class="col-md-3">
		<h4>
			<a href="{$base_url}/{$user_info.user_name}/friends/">
			<span class="glyphicon glyphicon-user"></span> My Friends</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/public/">
			<span class="glyphicon glyphicon-film"></span> My Public videos</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$user_info.user_name}/private/">
			<span class="glyphicon glyphicon-film"></span> My Private Videos</a>
		</h4>
	</div>

</div>