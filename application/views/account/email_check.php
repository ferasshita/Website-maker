<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__file__) . 'error_log.txt');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$getLang = trim(filter_var(htmlentities($_GET['lang']),FILTER_SANITIZE_STRING));
if (!empty($getLang)) {
    $_SESSION['language'] = $getLang;
}
 // ========================= config the languages ================================
error_reporting(E_NOTICE ^ E_ALL);
?>
<!DOCTYPE html>
<html lang="en" translate="no">
<head>
	<title>Almaqar</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this->load->view('includes/head_imports_main'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="<?php echo base_url();?>Asset/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="<?php echo base_url();?>Asset/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>Asset/css/skin_color.css">

</head>
<body class="hold-transition rtl light-skin sidebar-mini theme-primary">
<!-- Site wrapper -->
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title"><?php echo lang('verifi_email'); ?></h4>
                    </div>
                    <div class="box-body">
                        <?php echo lang('verifi_email_describtion'); ?> <a style="color:dodgerblue;" href="https://mail.google.com/mail/ca/u/0/#inbox"><?php echo lang('link'); ?></a>.
                    </div>
										<div class="box-footer">
												<h3><?php echo $message; ?></h3>
										</div>
                    <!-- /.box-body -->

                    <!-- /.box-footer-->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->

        </div>
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->


<!-- Vendor JS -->
<script src="<?php echo base_url();?>Asset/js/vendors.min.js"></script>

<!-- Crypto Tokenizer Admin App -->
<script src="<?php echo base_url();?>Asset/js/template.js"></script>
<script src="<?php echo base_url();?>Asset/js/demo.js"></script>


</body>
</html>
