<?php showMessage();?>
<h3><?php echo @$page_heading;?></h3>


<?php if($aData):?>
<table class="table table-condensed">

    <thead>
		<tr>
			<th>SI</th>
			<th>Title</th>
			<th>Details</th>
			<th>Actions</th>
		</tr>
    </thead>
	
    <tbody>
	<?php foreach($aData AS $iKey=>$oItem):?>
    <tr>

	    <td>
			<?php echo $iKey + $iOffset + 1;?>
		</td>
		<td>
			<?php echo $oItem->title;?>
		</td>
		<td>
			<div><span class="h6 b">Reciever Name : </span><?php echo $oItem->reciever_name;?></div>
			<div><span class="h6 b">Email : </span><?php echo $oItem->email;?></div>
			<div><span class="h6 b">Email Template : </span><?php echo $oItem->email_template_title;?></div>
			<div><span class="h6 b">Description : </span><?php echo $oItem->description;?></div>
			<div><span class="h6 b">Success Message : </span><?php echo $oItem->success_message;?></div>
		</td>
		<td>
			<div>
				<a href="<?php echo c('base_url');?>contact_us/edit_purpose/<?php echo $oItem->uid;?>">Edit</a>
			</div>
			<div>
				<a href="javascript:void(0);" class="perm_delete" id="<?php echo $oItem->uid;?>">Delete</a>
			</div>
		</td>
		
    </tr>
	<?php endforeach;?>
    </tbody>
</table>
<div class="row">
	<?php echo $sPagination;?>
</div>

<?php else:?>
<div class="col-md-10 pull-center">There are no puposes</div>
<?php endif;?>






