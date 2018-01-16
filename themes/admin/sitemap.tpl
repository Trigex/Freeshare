<div class="page-header">
    <h1>Site Map</h1>
</div>

{if $sitemap|@count ne '0'}

<table cellspacing="1" cellpadding="3"  width="100%" border="0">
	<tr>
		<td><b>Sitemap Name</b></td>
		<td><b>Sitemap Generated On</b></td>
		<td><b>Sitemap URL Count</b></td>
		<td><b>Sitemap Size</b></td>
	</tr>
	{section name=i loop=$sitemap}
		<tr>
			<td><a href="{$base_url}/sitemap/{$sitemap[i].sitemap_name}" target="_blank">{$sitemap[i].sitemap_name}</a></td>
			<td>{$sitemap[i].sitemap_name|date_format:'%b %e, %Y %r'}</td>
			<td>{$sitemap[i].sitemap_url_count}</td>
			<td>{$sitemap[i].format_size}</td>
		</tr>
	{/section}
</table>

<br />

{/if}

<form method="POST" action="">
    <button class="btn btn-info btn-lg" type="submit" name="generate_sitemap">Generate Sitemap</button>
</form>

<h2>Sitemap URL</h2>

<textarea rows="2" cols="80">
{$base_url}/sitemap/sitemap_index.xml.gz
</textarea>

<h2>Sitemap Help</h2>

<p><a href="https://support.google.com/webmasters/answer/183669" target="_blank">https://support.google.com/webmasters/answer/183669</a></p>
