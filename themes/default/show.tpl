{if $err eq "1"}
    <html>
	<body>
	<font size="3" color="#ff0000"><b>Video Not Found</b></font>
	</body>
    </html>
{else}
    {$VSHARE_PLAYER}
{/if}