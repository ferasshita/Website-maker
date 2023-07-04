<?php

ini_set('error_log', dirname(__file__) . '/error_log.txt');


$data['page_name']['name'] = "mode";

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
                          <h3 class="page-title"><strong><?php echo lang('mode'); ?></strong></h3>
                          <div class="d-inline-block align-items-center">
                            <nav>
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"> <?php echo lang('mode'); ?></li>
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
                                <p align="center" id="about_save_result"><?php echo $lang_save_resultsfs; ?></p>
                                <form action="" method="post">
                                <div>


                                <div class="controls">
                                    <fieldset>
                                    <input name="mode"
                                            value="auto"
                                            id="checkbox_1"

                                            type="radio"
                                            <?php  if($_SESSION['mode'] == "auto"){echo"checked";} ?>>
                                    <label for="checkbox_1"><?php echo lang('auto'); ?></label>
                                    </fieldset>
                                </div>
                                <div class="controls">
                                    <fieldset>
                                    <input name="mode"
                                            value="night"
                                            id="checkbox_2"

                                            type="radio"
                                            <?php  if($_SESSION['mode'] == "night"){echo"checked";} ?>>
                                    <label for="checkbox_2"><?php echo lang('night'); ?></label>
                                    </fieldset>
                                </div>
                                <div class="controls">
                                    <fieldset>
                                    <input name="mode"
                                            value="light"
                                            id="checkbox_3"

                                            type="radio"
                                            <?php  if($_SESSION['mode'] == "light"){echo"checked";} ?>>
                                    <label for="checkbox_3"><?php echo lang('light'); ?></label>
                                    </fieldset>
                                </div>



                                </div>
                                <div style="padding-top: 21px;">

                                <!-- password input -->


                                <button name="mode_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
                                    <?php echo lang('save_changes'); ?>
                                </button>

                                </div>
                                </form>
                            </div>
                            </div>
                            </div>
                            </div>







                         <!-- </div>

                    </div>
            </div>
            </div> -->
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
    <?php $this->load->view('includes/endJScodes'); ?>

</body>
</html>
