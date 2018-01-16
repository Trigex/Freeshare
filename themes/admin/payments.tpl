<h1>Payments</h1>

<table class="table table-striped">

   <tr>
       <td width="7%">
           <b>ID</b>
           <a href="payments.php?sort=id_asc&page={$smarty.get.page}">
               <span class="glyphicon glyphicon-arrow-up"></span>
           </a>
           <a href="payments.php?sort=id_desc&page={$smarty.get.page}">
               <span class="glyphicon glyphicon-arrow-down"></span>
           </a>
       </td>

       <td width="20%">
           <b>User</b>
           <a href="payments.php?sort=user_asc&page={$smarty.get.page}">
               <span class="glyphicon glyphicon-arrow-up"></span>
           </a>
           <a href="payments.php?sort=user_desc&page={$smarty.get.page}">
               <span class="glyphicon glyphicon-arrow-down"></span>
           </a>
       </td>

       <td width="10%">
           <b >Package</b>
       </td>

       <td  width="10%">
           <b >Period</b>
       </td>

       <td  width="10%">
           <b>Amount</b>
       </td>

       <td width="20%">
           <b>Payment completed</b>
       </td>

       <td>
           <b>Action</b>
       </td>

   </tr>

   {section name=i loop=$payment_info}

   <tr>

       <td>
           {$payment_info[i].payment_id}
       </td>

       <td>
           <a href="user_view.php?user_id={$payment_info[i].payment_user_id}&page={$smarty.request.page}">
               {$payment_info[i].user_name}
           </a>
       </td>

       <td>
           <a href="package_view.php?package_id={$payment_info[i].payment_package_id}">
               {$payment_info[i].package_name}
           </a>
       </td>

       <td>
           {$payment_info[i].total_period}&nbsp;{$payment_info[i].package_period}(s)
       </td>

       <td>
           ${$payment_info[i].payment_amount}
       </td>

       <td>
           {if $payment_info[i].payment_completed eq 0}
           No
           {else}
           Yes
           {/if}
       </td>

       <td>
           <div style="display:block;">
               <form action="subscription_edit.php" method="POST" style="display: inline;">
                   <input type="hidden" value="edit" name="edit">
                   <input type="hidden" value="{$payment_info[i].user_name}" name="username" data-toggle="tooltip" data-placement="bottom" title="Edit Subscription">
                   <input type=image src="{$img_css_url}/images/edit.gif" border="0">
               </form>
               <a href="payments.php?action=delete&id={$payment_info[i].payment_id}" onclick="return confirm('Are you sure you want to remove?');" data-toggle="tooltip" data-placement="bottom" title="Remove">
                   <span class="glyphicon glyphicon-remove-circle"></span>
               </a>
           </div>
       </td>

   </tr>

   {/section}

</table>

<div>
   {$page_links}
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
{/literal}
