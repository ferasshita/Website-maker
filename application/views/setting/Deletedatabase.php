<?php

ini_set('error_log', dirname(__file__) . '/error_log.txt');

$data['page_name']['name'] = "delete account";
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
<!--        <div class="dot"></div>-->
<!--        <div class="dot"></div>-->
<!--        <div class="dot"></div>-->
<!--        <div class="dot"></div>-->
<!--        <div class="dot"></div>-->
    </div>
<?php
$this->load->view('includes/navbar_main');
//include "includes/navbar_main.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->

                    <div class="content-header">
                      <div class="d-flex align-items-center">
                        <div class="mr-auto">
                          <h3 class="page-title"><strong><?php
  echo lang('delete_database');

?></strong></h3>
                          <div class="d-inline-block align-items-center">
                            <nav>
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"> <?php
                                  echo lang('delete_database');
                                ?></li>
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
                    <form action="" onsubmit="return fgfgdsg()" method="post">
                    <div >
                    <div style="background: rgba(247, 81, 81, 0.14); color: #f75151;margin:4px; padding: 15px; border: 1px solid #f75151; border-radius: 3px;"><?php echo lang('delete_db_note'); ?></div>
                    <p><input class="form-control" type="password" name="removexj_current_pass" placeholder="<?php echo lang('current_password'); ?>" required /></p>
                    <button type="button" class="btn btn-danger" onclick="adviced()"><?php echo lang('adviced'); ?></button>
                </div>
                        <div class="box-body">
                            <p style="margin: 0;">
                                <button class="btn btn-rounded btn-danger btn-outline" id="remove_accountas" name="removexj_save_changes" type="submit"><?php echo lang('delete_database'); ?></button>
                            </p>
                        </div>


                    <p align="center" id="removeA_save_result"><?php echo $removexj_save_result; ?></p>
                    </form>
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
<?php $this->load->view('includes/jslinks'); ?>
    <?php
    $this->load->view('includes/endJScodes'); ?>

</body>
</html>
