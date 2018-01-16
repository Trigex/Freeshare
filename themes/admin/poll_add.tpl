<script language="JavaScript" src="{$base_url}/js/admin_poll.js" type="text/javascript"></script>

<div class="page-header">
    <h1>Add New Poll</h1>
</div>

<form method="post" action="poll_add.php" onsubmit="return validate_poll_form();" class="form-horizontal">

    <div class="form-group">
        <label class="col-sm-2 control-label">Starting date:</label>
        <div class="col-sm-5">
            <div class="form-inline">
                <select class="form-control" name="start_date_day">
                    {$days}
                    <option value="{$smarty.post.start_date_day}">{$smarty.post.start_date_day}</option>
                </select>
                <select class="form-control" name="start_date_month">
                    {$month}
                    <option value="{$smarty.post.start_date_month}">{$smarty.post.start_date_month}</option>
                </select>
                <select class="form-control" name="start_date_year">
                    {$year}
                    <option value="{$smarty.post.start_date_year}">{$smarty.post.start_date_year}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">End date:</label>
        <div class="col-sm-5">
            <div class="form-inline">
                <select class="form-control" name="end_date_day">
                    {$days}
                    <option value="{$smarty.post.end_date_day}">{$smarty.post.end_date_day}</option>
                </select>
                <select class="form-control" name="end_date_month">
                    {$month}
                    <option value="{$smarty.post.end_date_month}">{$smarty.post.end_date_month}</option>
                </select>
                <select class="form-control" name="end_date_year">
                    {$year}
                    <option value="{$smarty.post.end_date_year}">{$smarty.post.end_date_year}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Question:</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="poll_question" id="poll_question" rows="2" onblur="poll_answer_validate('poll_question','#EAEAEA','#FFB3B3')">{$smarty.post.poll_question}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Number of Answers:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="num_answers" id="num_answers" onblur="show_poll_answer_box()" onfocus="delete_poll_answer_box()" value="{$smarty.post.num_answers}">
        </div>
    </div>

    <div class="col-sm-offset-2 col-sm-5">
        <table id="poll_table_container" class="table table-hover"></table>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Create Poll</button>
        </div>
    </div>

</form>