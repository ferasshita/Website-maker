<?php
ini_set('error_log', dirname(__file__) . '/error_log.txt');
LoadLang();
$user_id = $_SESSION['id'];
$pid = $_GET['pid'];
$data['page_name']['name'] = $pid;
?>
<!DOCTYPE html>
<html class="<?php $this->load->view('includes/mode'); ?>" translate="no" lang="en">
<head>
	<?php $this->load->view('includes/head_info', $data); ?>
</head>
<body class="<?php $this->load->view('includes/mode.php'); ?> theme-primary sidebar-collapse fixed">
<div class="wrapper animate-bottom" id="wrapper_id" >
	<div id="loader"></div>

	<!-- Left side column. contains the logo and sidebar -->
	<?php
	$this->load->view('includes/navbar_main.php');
	?>
	<script>

		function random_bg_color(){
			var x = Math.floor(Math.random() * 256);
			var y = Math.floor(Math.random() * 256);
			var z = Math.floor(Math.random() * 256);
			var bgColor = "rgb(" + x + "," + y + "," + z + ")";
			return bgColor;
		}

	</script>
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


				<div class="row">

					<div class="col-md-6 col-12 fixed-flex-report">
						<div class="box">
							<div class="box-header with-border">
								<h4 class="box-title"><strong>Pages</strong></h4>
								<ul class="box-controls pull-right">
									<li><a class="box-btn-close" href="#"></a></li>
									<li><a class="box-btn-slide" href="#"></a></li>
									<li><a class="box-btn-fullscreen" href="#"></a></li>
								</ul>
							</div>


									<div class="box-body">
										<div class="table-responsive">

											<table id="reports_1" class="table table-lg invoice-archive">
												<thead>
												<tr>
													<th>Serial number</th>
													<th>File name</th>
													<th class="text-center"><span class="fa fa-cog"></span></th>
												</tr>
												</thead>
												<tbody>

												<?php
												$pathh = "../projects/$pid/application/views";
												$folder = scandir($pathh);
												$folder = array_diff(scandir($pathh), array('.','..'));
												foreach ($folder as $folder) {
													$sn += 1;
													if($folder != ("index.php" || "404.php")){
														 ?>
														<tr>
															<td>
																<?php echo $sn; ?>
															</td>
															<td>
																<a href="<?php echo "../../projects/$pid/$folder"; ?>"><p><?php echo $folder; ?></p></a>
															</td>
															<td>
																<a href="<?php echo base_url(); ?>project/edit?pid=<?php echo $pid; ?>&page=<?php echo $folder; ?>"><button type="button" class="btn btn-primary">Edit</button> </a>
															</td>
														</tr>
													<?php }else{
													if($folder != "errors" && $folder != "includes" && !preg_match("/[.]/", $folder)){
													$path = "../projects/$pid/application/views/$folder";
													$files = array_diff(scandir($path), array('.','..'));
													foreach ($files as $files) {
													?>
														<tr>
															<td>
																<?php echo $sn; ?>
															</td>
															<td>
																<a href="<?php echo "../../projects/$pid/$folder/$files"; ?>"><p><?php echo $files; ?></p></a>
															</td>
															<td>
																<a href="<?php echo base_url(); ?>project/edit?pid=<?php echo $pid; ?>&folder=<?php echo $folder; ?>&page=<?php echo $files; ?>"><button type="button" class="btn btn-primary">Edit</button> </a>
															</td>
														</tr>

														<?php
													}}}}
												?>

												</tbody>
											</table>

										</div>
									</div>

						</div>
					</div>

				</div>


				<!-- Informations Buy  -->
				<div class="row">
					<a style="color: white" href="<?php echo base_url(); ?>project/new_page?pid=<?php echo $pid; ?>"><div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="z-index: 9998;position: relative;" id="chat-box-body">
						<div style="position: fixed;bottom: 50px;right: 50px;cursor: pointer;box-shadow: 0px 3px 16px 0px rgb(0 0 0 / 20%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);transform: scale(1);border-radius: 5px;" class="waves-effect waves-circle btn btn-circle btn-lg btn-warning">
							<span style="font-size: 2.1428571429rem!important;position:sticky;top: 15px" class="fa fa-plus"></span></a>
						</div>
					</div>

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
<?php $this->load->view('includes/endJScodes', $data); ?>
<?php $this->load->view('includes/jslinks', $data); ?>

<!-- Vendor JS -->
</body>
</html>
