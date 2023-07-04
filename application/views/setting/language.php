<?php
ini_set('error_log', dirname(__file__) . '/error_log.txt');

$data['page_name']['name'] = "language";

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
                          <h3 class="page-title"><strong><?php echo lang('language'); ?></strong></h3>
                          <div class="d-inline-block align-items-center">
                            <nav>
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"> <?php echo lang('language'); ?></li>
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
                <p align="center" id="lang_save_result"><?php echo $lang_save_result; ?></p>
                <form action="<?php echo base_url();?>Setting/Savelanguage" method="post">
            <div class="form-group"><label><?php echo lang('language'); ?></label>
                <select class="form-control"  name="edit_language" >
                <option <?php if($_SESSION['language'] == "English"){ echo "selected";} ?> >English</option>
                <option <?php if($_SESSION['language'] == "العربية"){ echo "selected";} ?> >العربية</option>
                </select>
                </div>
                <div style="padding-top: 21px;">

                <!-- password input -->


                <button name="lang_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
                <?php echo lang('save_changes'); ?>
                </button>

                </div>
                </form>
                <!-- =======================================language select ==========================================-->
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

<!-- ./wrapper -->
    <?php $this->load->view('includes/endJScodes', $data); ?>
    <?php $this->load->view('includes/jslinks', $data); ?>

</body>
</html>
