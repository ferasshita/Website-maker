<!DOCTYPE html>
<html class="<?php $this->load->view('includes/mode'); ?>" translate="no" lang="<?php echo lang('html_lang'); ?>" dir="">
<head>
	<?php
	$this->load->view('includes/head_info');
	$data['sid'] = $_SESSION['id'];
	?>
</head>
<body class="<?php $this->load->view("includes/mode"); ?> <?php echo lang('html_dir'); ?>  no-sidebar theme-primary sidebar-collapse fixed">

<!-- Site wrapper -->
<div class="wrapper animate-bottom" id="wrapper_id">
	<div id="loader">

	</div>
	<?php
	$this->load->view('includes/navbar_main'); ?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Content Header (Page header) -->

			<div class="content-header">
				<div class="d-flex align-items-center">
					<div class="mr-auto">
						<h3 class="page-title"><strong><?php
								if($pid == NULL){echo lang("settings");}else{echo lang($pid);}
								?></strong></h3>
						<div class="d-inline-block align-items-center">
							<nav>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page"> <?php
										if($pid == NULL){echo lang("settings");}else{echo lang($pid);}
										?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>

			<!-- Main content -->
			<section id="up_section" class="content">

				<?php if($pid != NULL){ $this->load->view('setting/'.$pid, $data); }else{ ?>
					<div class="box">
						<div class=" fixed-width-form">

								<!-- /.box-header -->
									<div class="box-body">
										<h4 class="box-title text-primary"> <?php echo lang('account'); ?></h4>
										<hr class="my-15">
										<!-- /.box-body -->
	<ul class="sidebar-menu tree" data-widget="tree">
		<li>
			<a href="<?php echo base_url(); ?>setting?pid=general" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
				<i class="fa fa-user"></i>
				<span><?php echo lang('general'); ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>setting?pid=password" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
				<i class="fa fa-lock"></i>
				<span><?php echo lang('password'); ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>setting?pid=download_data" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
				<i class="fa fa-download"></i>
				<span><?php echo lang('download_data'); ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>setting?pid=language" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
				<i class="fa fa-language"></i>
				<span><?php echo lang('language'); ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>setting?pid=mode" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
				<i class="fa fa-adjust"></i>
				<span><?php echo lang('mode'); ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>setting?pid=remove_account" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
				<i class="fa fa-warning"></i>
				<span><?php echo lang('remove_account'); ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>setting?pid=delete_database" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
				<i class="fa fa-trash"></i>
				<span> <?php echo lang('delete_database'); ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
			</a>
		</li>
	</ul>
									</div>

						</div>
					</div>

					<div class="box">
						<div class=" fixed-width-form">

							<!-- /.box-header -->
							<div class="box-body">
								<h4 class="box-title text-primary"> <?php echo lang('security'); ?></h4>
								<hr class="my-15">
								<!-- /.box-body -->
								<ul class="sidebar-menu tree" data-widget="tree">
									<li>
										<a href="<?php echo base_url(); ?>setting?pid=manage_devices" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
											<i class="fa fa-connectdevelop"></i>
											<span><?php echo lang('manage_devices'); ?></span>
											<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
										</a>
									</li>
								</ul>
							</div>

						</div>
					</div>

					<div class="box">
						<div class=" fixed-width-form">

							<!-- /.box-header -->
							<div class="box-body">
								<h4 class="box-title text-primary"> <?php echo lang('help'); ?></h4>
								<hr class="my-15">
								<!-- /.box-body -->
								<ul class="sidebar-menu tree" data-widget="tree">
									<li>
										<a href="<?php echo base_url(); ?>setting?pid=Report_A_Problem" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
											<i class="fa fa-bug"></i>
											<span><?php echo lang('Report_A_Problem'); ?></span>
											<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url(); ?>home/support" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
											<i class="fa fa-support"></i>
											<span><?php echo lang('support'); ?></span>
											<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url(); ?>Account/terms" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
											<i class="fa fa-archive"></i>
											<span> <?php echo lang('terms'); ?></span>
											<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url(); ?>home/about" class="hover-effect waves-effect waves-light nav-link rounded push-btn">
											<i class="fa fa-globe"></i>
											<span><?php echo lang('about'); ?></span>
											<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
										</a>
									</li>
								</ul>
							</div>

						</div>
					</div>

					<div class="box">
						<div class=" fixed-width-form">

							<!-- /.box-header -->
							<div class="box-body">
								<h4 class="box-title text-primary"> <?php echo lang('Logout'); ?></h4>
								<hr class="my-15">
								<!-- /.box-body -->
								<ul class="sidebar-menu tree" data-widget="tree">
									<li>
										<a href="<?php echo base_url(); ?>Account/logout" onclick="return confirm('<?php echo lang('confirm_logout'); ?>')" class="text-danger hover-effect waves-effect waves-light nav-link rounded push-btn">
											<i class="ion-log-out"></i>
											<span><?php echo lang('Logout'); ?></span>
											<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
										</a>
									</li>
								</ul>
							</div>

						</div>
					</div>


<?php } ?>
				<div style="margin: 10px" class="text-center"><span class="text-bold font-size-16"><?php echo displayVersion(); ?></span></div>

			</section>
			<!--Slided up box!-->


		</div>
		<!--Slided up box!-->

	</div>
	<!-- /.content-wrapper -->

	<?php //include "includes/footer.php";
	$this->load->view('includes/footer');
	?>
	<!-- /.control-sidebar -->

	<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
</div>
<!-- ./wrapper -->
<?php
$this->load->view('includes/endJScodes');?>

</body>
</html>
