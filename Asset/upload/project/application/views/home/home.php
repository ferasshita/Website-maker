<!DOCTYPE html>
<html class="<?php $this->load->view('includes/mode'); ?>">
<head>
	<?php $this->load->view("includes/head_info", $data); ?>
</head>
<body class="<?php $this->load->view("includes/mode"); ?> theme-primary sidebar-collapse fixed" style="height: auto; min-height: 100%;">

<div class="wrapper animate-bottom">
	<div id="loader"></div>

	<!-- navbar -->
	<?php $this->load->view("includes/navbar_main.php", $data); ?>
	<!-- /navbar -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="container-full">
			<!-- Main content -->
			<section class="content">


			</section>

		</div>
	</div>
	<!-- /.content-wrapper -->

	<!-- footer -->
	<?php $this->load->view("includes/footer", $data); ?>
	<!-- /footer -->
</div>

<!-- endJS -->
<?php $this->load->view("includes/endJScodes", $data); ?>
<!-- /endJS -->


</body>
</html>
