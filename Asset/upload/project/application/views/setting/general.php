
	<div class="row">
	<div class="col-12">
	<div class="box">
	<div class="box-body">
	<form id="postingToDB" class="form" action="<?php echo base_url();?>Setting/Savegeneral/" method="post">

	<!-- username input -->
	<div class="form-group"><label><?php echo lang('username'); ?></label>
	<input type="text"  name="edit_username" placeholder="<?php echo lang('username'); ?>*" value="<?php echo $_SESSION['username']; ?>" class="form-control" >

	</div>
	<!-- phone input -->
	<div class="form-group"><label><?php echo lang('phone'); ?></label>
	<input type="text"  name="edit_fullname" placeholder="<?php echo lang('phone'); ?>*" value="<?php echo $_SESSION['phone']; ?>" class="form-control" >

	</div>


	<!-- email input -->
	<div class="form-group"><label><?php echo lang('email'); ?></label>
	<input type="text"  name="edit_email" placeholder="<?php echo lang('email'); ?>*" value="<?php echo $_SESSION['email']; ?>" class="form-control" >

	</div>

	<div style="padding-top: 21px;">

	<!-- password input -->
	<div class="form-group"><label><?php echo lang('current_password'); ?></label>
	<input type="password"  name="general_current_pass" placeholder="<?php echo lang('current_password'); ?>" class="form-control">

	</div>

	<button name="general_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
	<?php echo lang('save_changes'); ?>
	</button>

	</div>
		<div class="loadingPosting"></div>
	</form>
	</div>
	</div>
	</div>

	</div>

