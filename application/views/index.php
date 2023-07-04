<?php
ini_set('error_log', dirname(__file__) . '/error_log.txt');

$data['page_name']['name'] = "Projects";
LoadLang();
$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html class="<?php $this->load->view('includes/mode'); ?>" translate="no" lang="en">
<head>
	<?php $this->load->view('includes/head_info', $data); ?>
</head>

<body class="<?php $this->load->view('includes/mode.php'); ?> theme-primary sidebar-collapse fixed">
<div style="margin-top: -20px" class="wrapper animate-bottom" id="wrapper_id" >
	<div id="loader"></div>

	<!-- Left side column. contains the logo and sidebar -->
	<?php
	$this->load->view('includes/navbar_main.php');
	?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="d-flex align-items-center">
					<div class="mr-auto">
						<h3 class="page-title"><strong><?php echo $data['page_name']['name']; ?></strong></h3>
						<div class="d-inline-block align-items-center">
							<nav>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $data['page_name']['name']; ?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>

			<!-- Main content -->
			<section class="content">

				<!-- Informations Buy  -->
				<div class="row">
					<?php
					$path = "../projects";
					$files = scandir($path);
					$files = array_diff(scandir($path), array('.','..'));
					foreach ($files as $files) {
						if(!preg_match("/[.]/", $files)){
							?>
							<div class="col-xl-4 col-12">
								<a href="<?php echo base_url(); ?>project/pages?pid=<?php echo $files; ?>"><div class="box box-solid ">
										<div align="center" class="box-header with-border">
											<h4  class="box-title"><?php echo $files; ?></h4>
										</div>
										<div style="height: 240px" style="padding: 0" class="box-body">
											<img src="../projects/<?php echo $files; ?>/Asset/imgs/logo.ico" alt="">
										</div>
									</div></a>
							</div>
							<?php
						}}
					?>
					<a style="color: white" href="<?php echo base_url(); ?>project/new_project"><div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="z-index: 9998;position: relative;" id="chat-box-body">
							<div style="position: fixed;bottom: 50px;right: 50px;cursor: pointer;box-shadow: 0px 3px 16px 0px rgb(0 0 0 / 20%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);transform: scale(1);border-radius: 5px;" class="waves-effect waves-circle btn btn-circle btn-lg btn-warning">
								<span style="font-size: 2.1428571429rem!important;position:sticky;top: 15px" class="fa fa-plus"></span>
							</div>
						</div></a>

				</div>
			</section>
			<!-- /.content -->


			<!-- /.content -->

		</div>
	</div>
	<!-- /.content-wrapper -->
	<?php
	$this->load->view('includes/footer');
	?>

	<!-- Control Sidebar -->
	<!-- /.control-sidebar -->


</div>

<!-- ./wrapper -->
<?php $this->load->view("includes/endJScodes", $data); ?>
<?php $this->load->view('includes/jslinks', $data); ?>

<!-- Vendor JS -->
</body>
</html>
