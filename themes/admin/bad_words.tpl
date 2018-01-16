<div class="page-header">
    <h1>Bad Words</h1>
</div>

{if !empty($badwords)}
<table class="table table-striped table-hover">

	<tr>
		<td><b>ID</b></td>
		<td><b>BAD WORDS</b></td>
		<td align="center"><b>ACTION</b></td>
	</tr>

	{section name=i loop=$badwords}
	<tr>
		<td>{$badwords[i].word_id}</td>
		<td>{$badwords[i].word}</td>
		<td align="center">
			<a href="bad_words.php?action=del&id={$badwords[i].word_id}" onClick='Javascript:return confirm("Are you sure you want to delete?");' data-toggle="tooltip" data-placement="bottom" title="Remove">
                <span class="glyphicon glyphicon-remove-circle"></span>
            </a>
		</td>
	</tr>
	{/section}

</table>

{else}
<div class="alert alert-info">
    No bad words found.
</div>
{/if}

<hr>

<form method="post" action="" class="form-inline" role="form">

    <input type="hidden" name="action" value="add" />

    <div class="form-group">
        <label class="sr-only" for="word">Add a Bad Word:</label>
        <input class="form-control" type="text" name="word" id="word" placeholder="Enter bad word" />
    </div>

    <button type="submit" name="submit" class="btn btn-default">Add</button>

</form>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
