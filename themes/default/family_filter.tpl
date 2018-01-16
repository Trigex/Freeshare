<div class="col-md-12">
    {if $smarty.session.UID ne ''}
    	<div class="page-header">
            <h1>Family Filter is <strong>ON</strong>.</h1>
    	</div>
		<ul>
			<li><strong>{$site_name}</strong> understands that some content may not be appropriate for all users.</li>
			<li>We provide a Family Filter so that you can choose the content best suited to your personal interest.</li>
			<li>Turning OFF the Family Filter may display content that is only suitable for viewers over {$age_minimum} years of age.</li>
			<li>Click the button below if you are over {$age_minimum} and would like to turn OFF the Family Filter.</li>
		</ul>
        <br>
        <form method="POST" action="">
            <button type="submit" name="submit" class="btn btn-default btn-lg">I am over {$age_minimum} - set Family Filter <strong>OFF</strong></button>
        </form>
    {else}
        <h4>Please verify you are {$age_minimum} or older by <a href="{$base_url}/login/">signing in</a> or <a href="{$base_url}/signup/">signing up</a>.</h4>
        <p class="text-muted">If you would instead prefer to avoid potentially inappropriate content, consider activating {$site_name}'s Family Filter.</p>
    {/if}
    <br>
</div>