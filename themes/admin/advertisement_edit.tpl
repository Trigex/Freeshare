<div class="page-header">
    <h1>Edit Advertisement: {$advertisement_info.adv_name}</h1>
</div>

<form action="" method="post" class="form-horizontal">

    <input type="hidden" name="advertisement_id" value="{$smarty.get.adv_id}" />

    <div class="form-group">
        <div class="col-md-5">
            <textarea class="form-control" name="advertisement_text" rows="15">{$advertisement_info.adv_text}</textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

</form>

{insert name=advertise adv_name=$advertisement_info.adv_name}