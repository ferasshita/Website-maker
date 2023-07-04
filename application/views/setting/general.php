<?php

ini_set('error_log', dirname(__file__) . '/error_log.txt');

$data['page_name']['name'] = "general";

$tcf = filter_var(htmlentities($_GET['tcf']),FILTER_SANITIZE_STRING);
?>
<!DOCTYPE html>
<html class="<?php $this->load->view('includes/mode'); ?>" translate="no" lang="<?php echo lang('html_lang'); ?>" dir="">
<head>
  <?php $this->load->view('includes/head_info', $data); ?>

    <style>
      .exchange-calculator  .select2-container {
        margin-top: 0px;
      }
      @media (min-width: 992px) {
          .col-lg-6 {
              flex: 0 0 100%;
              max-width: 100%;
          }
      }@media (min-width: 768px){
          .col-md-6 {
              flex: 0 0 100%;
              max-width: 100%;
          }
      }

    </style>
</head>
<body class="hold-transition <?php echo lang('html_dir'); ?> <?php echo $layoutmode; ?> sidebar-mini theme-primary">

<!-- Site wrapper -->
<div class="wrapper animate-bottom" id="wrapper_id">
    <div class="loader">

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
                          <h3 class="page-title"><strong><?php echo lang('general'); ?></strong></h3>
                          <div class="d-inline-block align-items-center">
                            <nav>
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo lang('general'); ?></li>
                              </ol>
                            </nav>
                          </div>
                        </div>
                      </div>
                    </div>

		<!-- Main content -->
		<section id="up_section" class="content">
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="box">
            <div class="box-body">
                <div class="row">
            <div class="col-lg-6 col-12">
                <div class="box">
                <div class="box-body">
                <p align="center" id="general_save_result"><?php echo $general_save_result; ?></p>
                <form class="form" action="<?php echo base_url();?>Setting/Savegeneral/" method="post">

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

                <!-- new password input -->
                <div class="form-group"><label><?php echo lang('new_password'); ?></label>
                <input type="password" data-strength name="new_pass" placeholder="<?php echo lang('new_password'); ?>*" class="form-control" >

                </div>

                <!-- confirm new password input -->
                <div class="form-group"><label><?php echo lang('confirm_new_password'); ?></label>
                <input type="password"  name="rewrite_new_pass" placeholder="<?php echo lang('confirm_new_password'); ?>*" class="form-control" >

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

                </form>
            </div>
            </div>
            </div>

            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="box box-slided-up">
                    <div class="box-header with-border">
                        <h4 class="box-title text-danger"><i class="fa fa-trash"></i> <?php echo lang('danger_zone'); ?></h4>
                        <ul class="box-controls pull-right">
                            <li><a class="box-btn-close" href="#"></a></li>
                            <li><a class="box-btn-slide" href="#"></a></li>
                        </ul>
                    </div>

                    <div class="box-body">
                        <div class="callout callout-danger mb-0" role="alert">
                            <p>
                              <?php echo lang('danger_zone_wering'); ?>
                            </p>
                        </div>
                        <div class="box-body">
<?php if(project_settings('delete_account') != "delete_account"){ ?>
                        <a href="<?php echo base_url();?>Setting/DeleteAccount?tc=remove_account"><button type="button" class="waves-effect waves-light btn btn-rounded btn-danger mb-5"><?php echo lang('remove_account'); ?></button></a>
<?php } ?>
<?php if(project_settings('delete_database') != "delete_database"){ ?>
                        <a href="<?php echo base_url();?>Setting/Deletedatabase"><button type="button" class="waves-effect waves-light btn btn-rounded btn-danger mb-5"><?php echo lang('delete_database'); ?></button></a>
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>

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
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
    <?php $this->load->view('includes/endJScodes', $data); ?>
    <?php $this->load->view('includes/jslinks', $data); ?>

</body>
</html>
