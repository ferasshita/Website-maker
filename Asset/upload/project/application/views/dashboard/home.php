<!DOCTYPE html>
<html class="<?php $this->load->view('includes/mode'); ?>">
<head>
	<?php $this->load->view("includes/head_info", $data); ?>
</head>
<body class="<?php $this->load->view("includes/mode"); ?> theme-primary sidebar-collapse fixed">

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
<input type="hidden" id="fetchpost_db" value="home">
				<div id="FetchingPostsDiv"></div>
					<!-- post end -->
					<div class="post loading-info" id="LoadingPostsDiv" style="border-radius: 10px">
						<div class="animated-background">
							<div class="background-masker header-top"></div>
							<div class="background-masker header-left"></div>
							<div class="background-masker header-right"></div>
							<div class="background-masker header-bottom"></div>
							<div class="background-masker subheader-left"></div>
							<div class="background-masker subheader-right"></div>
							<div class="background-masker subheader-bottom"></div>
							<div class="background-masker content-top"></div>
							<div class="background-masker content-first-end"></div>
							<div class="background-masker content-second-line"></div>
							<div class="background-masker content-second-end"></div>
							<div class="background-masker content-third-line"></div>
							<div class="background-masker content-third-end"></div>
						</div>
					</div>
					<!-- post load -->
					<div class="post  loading-info" id="NoMorePostsDiv" style="display: none;min-width: 99%;">
						<p style="color: #b1b1b1;text-align: center;padding: 15px;margin: 0px;font-size: 18px;"><?php echo lang('noMoreStories'); ?></p>
					</div>
				<div class="post loading-info" id="ErrorPosts" style="display: none;min-width: 99%;">
					<p class="alertRed">Some thing went wrong, Please try again later.</p>
				</div>
					<div class="post  loading-info" id="LoadMorePostsBtn" style="display: none;min-width: 99%;">
						<button class="btn btn-primary waves-effect" style="width: 100%" onClick="fetchPosts_DB('home')"><?php echo lang('load_more'); ?></button>
					</div>
					<input type="hidden" id="GetLimitOfPosts" value="0">

				<canvas id="myChart"></canvas>
				<script>
					const labels = ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'];
					const data = [12, 19, 3, 5, 2, 3];

					displayChart('label','bar', labels, data);
				</script>
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
