<ul class="dropdown-menu">
	<li><a href="{$base_url}/{if $smarty.request.viewtype eq "detailed"}detailed/{/if}recent/">Most Recent</a></li>
	<li><a href="{$base_url}/{if $smarty.request.viewtype eq "detailed"}detailed/{/if}viewed/">Most Viewed</a></li>
	<li><a href="{$base_url}/{if $smarty.request.viewtype eq "detailed"}detailed/{/if}discussed/">Most Discussed</a></li>
	<li><a href="{$base_url}/{if $smarty.request.viewtype eq "detailed"}detailed/{/if}favorites/">Top Favorites</a></li>
	<li><a href="{$base_url}/{if $smarty.request.viewtype eq "detailed"}detailed/{/if}rated/">Top Rated</a></li>
	<li><a href="{$base_url}/{if $smarty.request.viewtype eq "detailed"}detailed/{/if}featured/">Featured</a></li>
</ul>