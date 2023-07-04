<?php
$page_name = $page_name['name'];
$pid=$_GET['pid'];
 ?>
<header class="main-header">
	<div class="d-flex align-items-center logo-box pl-20">

		<!-- Logo -->
		<a href="<?php echo base_url(); ?>" class="logo">
			<!-- logo-->
			<div class="logo-lg">
        <span class="light-logo"><b style="font-size:30px;"><?php if($pid==""){echo project_name();}else{echo $pid;} ?></b></span>
        <span class="dark-logo"><b style="font-size:30px;"><?php if($pid==""){echo project_name();}else{echo $pid;} ?></b></span>
			</div>
		</a>
	</div>
	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top pl-10">

		<!-- Sidebar toggle button-->
		<div class="app-menu">
			<ul class="header-megamenu nav">
				<li class="btn-group nav-item d-md-none">
					<a href="javascript:void(0)" class="waves-effect waves-light nav-link rounded push-btn"
					   data-toggle="push-menu" role="button">
						<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/collapse.svg"
							 class="img-fluid svg-icon" alt="">
					</a>
				</li>
				<li class="btn-group nav-item">
					<a href="javascript:void(0)" data-provide="fullscreen"
					   class="waves-effect waves-light nav-link rounded full-screen" title="Full Screen">
						<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/fullscreen.svg"
							 class="img-fluid svg-icon" alt="">
					</a>
				</li>

			</ul>
		</div>
		<!-- Button trigger modal -->

		<div class="navbar-custom-menu r-side">
			<ul class="nav navbar-nav">



				<!-- User Account-->
				<li class="dropdown user user-menu">

					<a href="javascript:void(0)" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown"
					   title="User">
						<img src="<?php echo base_url(); ?>Asset/imgs/main_icons/svg-icon/user.svg"
							 class="rounded svg-icon" alt=""/>
					</a>
					<ul class="dropdown-menu animated flipInX">
						<!-- User image -->
						<li class="user-header bg-img"
							style="background-image: url(<?php echo base_url(); ?>Asset/imgs/user-info.jpg)"
							data-overlay="3">
							<div class="flexbox align-self-center">
								<img loading="lazy" src="<?php echo base_url(); ?>Asset/imgs/Currency_img/2705.png"
									 class="float-left rounded-circle" alt="User">
								<h4 class="user-name align-self-center">
									<p><span><?php echo $_SESSION['username']; ?></span><br>
										<small><?php echo $_SESSION['email']; ?></small>
								</h4>
							</div>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<a class="dropdown-item" accesskey="m" href="javascript:void(0)" onclick="mode()"><i
										class="fa fa-adjust"></i> <?php echo lang('mode'); ?></a>
							<div class="dropdown-divider"></div>
							<?php if($pid!=""){?>
							<a class="dropdown-item" href="<?php echo base_url(); ?>project/labraries?pid=<?php echo $pid; ?>"><i class="fa fa-book"></i> PHP labraries</a>
								<a class="dropdown-item" href="http://localhost/projects/<?php echo $pid; ?>"><i class="fa fa-eye"></i> Preview live</a>
						<?php } ?>
						</li>
					</ul>
				</li>

			</ul>
		</div>
	</nav>
</header>

<!-- Left side column. contains the logo and sidebar -->

