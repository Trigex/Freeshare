<div class="page-header">
    <h1>Edit Poll</h1>
</div>

<script src="{$base_url}/js/admin_poll.js"></script>

<form method="post" action="poll_edit.php" onSubmit="return validate_poll_edit_form();" class="form-horizontal" role="form">

    <fieldset>

    <input type="hidden" name="poll_id" value="{$poll_id}">

    <div class="form-group">
        <label class="col-sm-2 control-label">Starting date :</label>
        <div class="col-sm-5">
            <div class="form-inline">
                <select class="form-control" name="start_date_day">
                    {$days_start}
                    <option value="{$smarty.post.start_date_day}">{$smarty.post.start_date_day}</option>
                </select>
                <select class="form-control" name="start_date_month">
                    {$month_start}
                    <option value="{$smarty.post.start_date_month}">{$smarty.post.start_date_month}</option>
                </select>
                <select class="form-control" name="start_date_year">
                    {$year_start}
                    <option value="{$smarty.post.start_date_year}">{$smarty.post.start_date_year}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">End date :</label>
        <div class="col-sm-5">
            <div class="form-inline">
                <select class="form-control" name="end_date_day">
                    {$days_end}
                    <option value="{$smarty.post.end_date_day}">{$smarty.post.end_date_day}</option>
                </select>
                <select class="form-control" name="end_date_month">
                    {$month_end}
                    <option value="{$smarty.post.end_date_month}">{$smarty.post.end_date_month}</option>
                </select>
                <select class="form-control" name="end_date_year">
                    {$year_end}
                    <option value="{$smarty.post.end_date_year}">{$smarty.post.end_date_year}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Question :</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="poll_question" id="poll_question" rows="2">{$poll_qty}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Answers :</label>
        <div class="col-sm-5">
            {assign var='j' value=0}
            {assign var='k' value=0}
            Add <input type="text" id='ans' value="1" style="width:30px;" maxlength="3"> answer(s)
            <input type="radio" name="edit_poll" id="poll_end" value="end">At End
            <input type="radio" name="edit_poll" id="poll_begining" value="beginning">At Beginning
            <input type="radio" checked="checked" name="edit_poll" id="poll_after" value="after">After
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <div class="form-inline">
                <select class="form-control" id="poll_select">
                    {section name=i loop=$list}
                        <option value={$j++}>{$list[i]}</option>
                    {/section}
                </select>
                <button class="form-control" type="button" onclick="add_poll_ans();">Go</button>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <div id="begining_text"></div>
            {section name=i loop=$list}
                <input type="text" name="edit_poll_answers[]" class="form-control" id="txtPollAnsQty" value="{$list[i]}">
                <div id="{$k++}"></div>
            {/section}
            <div id="ending_text"></div>
            <p class="help-block">If you change poll answer, current vote for the answer will be lost.</p>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

    </fieldset>

</form>
