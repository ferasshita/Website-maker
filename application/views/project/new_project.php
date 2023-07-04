<?php
ini_set('error_log', dirname(__file__) . '/error_log.txt');

$data['page_name']['name'] = "project";
LoadLang();
$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html class="<?php $this->load->view('includes/mode'); ?>" translate="no" lang="en">
<head>
	<?php $this->load->view('includes/head_info', $data); ?>
</head>

<body class="<?php $this->load->view('includes/mode.php'); ?> theme-primary sidebar-collapse fixed">
<div  class="wrapper animate-bottom" id="wrapper_id" >
	<div id="loader">
	</div>

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
			<section id="up_section" class="content">

				<!-- Informations Buy  -->
				<div class="row">

					<div class=" col-12">
						<div class="box">
							<div class="box-header with-border">
								<h4 class="box-title"><?php echo $data['page_name']['name']; ?></h4>
							</div>
							<!-- /.box-header -->
							<form class="form" id="postingToDB" action="<?php echo base_url();?>project/wproject" method="post" enctype="multipart/form-data" >
								<div class="box-body">
									<h4 class="box-title text-info"><i class="ti-write mr-15"></i> Information</h4>
									<hr class="my-15">
									<div class="row">

										<div class="col-md-6">
											<div class="form-group">
												<label>project name</label>
												<input type="text" name="project" id="project" autocomplete="off" placeholder="project name" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>author</label>
												<input type="text" name="author" id="author" autocomplete="off" placeholder="author" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>description</label>
												<input type="text" name="description" id="description" autocomplete="off" placeholder="description" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>logo</label>
												<input type="file" name="logo" id="logo" autocomplete="off" accept="image/ico" class="form-control">
											</div>
										</div>
									</div>
									<hr class="my-15">
									<h4 class="box-title text-info">Connection</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>host</label>
												<input type="text" name="name" id="name" autocomplete="off" placeholder="host" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>username</label>
												<input type="text" name="username" id="username" autocomplete="off" placeholder="username" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>password</label>
												<input type="text" name="password" id="password" autocomplete="off" placeholder="password" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>database</label>
												<input type="text" name="database" id="database" autocomplete="off" placeholder="database" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
								<!--=====================================================================-->
								<div id="mocsds" style="display:none">
									<!--=====================================================================-->
									<div id="mocsd">
										<?php
										if($_SESSION['myerrorb'] == ""){ ?>
											<p class="success_msg" style="text-align:<?php echo lang('sponsored_align'); ?>;">
												<?php echo lang('success_msg'); ?>
											</p>
										<?php  }
										?>
									</div>

								</div>

								<div class="box-footer">
									<button type="submit" class="btn btn-rounded btn-primary btn-outline" name="post_now" value="<?php echo lang('Insert'); ?>">
										<i class="ti-save-alt"></i> <?php echo lang('create'); ?>
									</button>
								</div>

							</form>
							<!--=====================================================================-->
						</div>
						<!-- /.box -->
					</div>

				</div>
				<!-- ./Informations Buy  -->
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

<script>
	$(document).ready(function(){
		$('.loadingPosting').hide();
		var i = 1;
		$("#postingToDB").on('submit',function(e){
			if ($.trim($('#project').val()) == "") {
				$('#project').css("border-color", "red");
				alert("<?php echo lang('please_fill_required_fields'); ?>");
				return false;
			}else{
				if ($.trim($('#author').val()) == "") {
					$('#author').css("border-color", "red");
					alert("<?php echo lang('please_fill_required_fields'); ?>");
					return false;
				}else{
				var plus = i++;
				$("#getingNP").prepend("<div id='FetchingNewPostsDiv" + plus + "' style='display:none;'></div>");
				e.preventDefault();
				$(this).ajaxSubmit({
					beforeSend: function () {
						$('.loadingPosting').show();
						$(".loadingPostingP").css({'width': '0%'});
						$(".loadingPostingP").html('0');
						$("#mocsds").show();
					},
					uploadProgress: function (event, position, total, percentCompelete) {
						$(".loadingPostingP").css({'width': percentCompelete + '%'});
						$(".loadingPostingP").html(percentCompelete);
					},
					success: function (data) {
						$('#value').val('');
						$("#reports_1").load(location.href + " #reports_1");
						$("#mocsds").fadeOut(800);
					}
				});
			}}
		});
	});
</script>

<!-- ./wrapper -->
<?php $this->load->view('includes/endJScodes', $data); ?>
<?php $this->load->view('includes/jslinks', $data); ?>

<!-- Vendor JS -->
</body>
</html>
