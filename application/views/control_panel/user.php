<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
error_reporting(0);
$data['page_name']['name'] = "user";
$ed = $_GET['ed'];

?>
  <!DOCTYPE html>
  <html class="<?php $this->load->view('includes/mode'); ?>" translate="no" lang="<?php echo lang('html_lang'); ?>">
  <head>
    <?php $this->load->view('includes/head_info', $data); ?>

  <style>
  .exchange-calculator  .select2-container {
  margin-top: 0px;
  }
  .input-group {

  width: 50%;
  }

  @media (min-width: 768px){
  .fixed-flex-report {
  flex: 0 0 100%;
  max-width: 100%;
  }
  }@media (min-width: 992px){
  .fixed-width-form {
  flex: 0 0 100%;
  max-width: 100%;
  }
  }
  </style>

  </head>
  <body class="hold-transition <?php echo lang('html_dir'); ?> <?php echo $layoutmode;//include "../includes/mode.php"; ?> sidebar-mini theme-primary">
  <!-- Site wrapper -->
  <div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  <?php
 //include "../includes/navbar_main.php";
  $this->load->view('includes/navbar_main');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="container-full">
  <!-- Content Header (Page header) -->
  <div class="content-header">
  <div class="d-flex align-items-center">
  <div class="mr-auto">
  <h3 class="page-title"><strong><?php echo lang('control_panel'); ?></strong></h3>
  <div class="d-inline-block align-items-center">
  <nav>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
  <li class="breadcrumb-item active" aria-current="page"><?php echo lang('control_panel'); ?></li>
  </ol>
  </nav>
  </div>
  </div>
  </div>
  </div>

  <!-- Main content -->
  <section class="content">

  <!--Add User-->
  <div class="row">

  <div class="col-md-6 col-12 fixed-flex-report">

  <?php
  $chAdmin = "SELECT * FROM signup WHERE id = '$ed'";
  $FetchedData=$this->comman_model->get_all_data_by_query($chAdmin);
$found_user = count($FetchedData);
  foreach($FetchedData as $uInfoRow ) {
    $uInfo_id = $uInfoRow['id'];
    $uInfo_type = $uInfoRow['account_type'];
    $uInfo_un = $uInfoRow['username'];
    $online = $uInfoRow['online'];
    $pack_ad = $uInfoRow['package'];
    $uInfo_em = $uInfoRow['email'];
    $uInfo_ph = $uInfoRow['phone'];
    $uInfo_pd = $uInfoRow['Password'];
    $status = $uInfoRow['sus'];
    $user_email_status = $uInfoRow['user_email_status'];
}
 if ($found_user > 0) {
  if ($uInfo_type != "admin")
  {
  ?>
  <div class="box">
  <div class="box-header with-border">
  <h4 class="box-title"> <strong><?php echo $uInfo_un ?></strong><?php if($online == 1){echo" <span class='userActive' style='background:green'></span>";} ?></h4>
  <ul class="box-controls pull-right">
  <li><a class="box-btn-close" href="#"></a></li>
  <li><a class="box-btn-slide" href="#"></a></li>
  <li><a class="box-btn-fullscreen" href="#"></a></li>
  </ul>
  </div>

  <div class="col-lg-6 col-12 fixed-width-form">
  <div class="box">
  <?php echo $update_result; ?>
  <!-- /.box-header -->
  <form class="form" action="" method="post">
  <div class="box-body">
  <h4 class="box-title text-info"><i class="ti-user mr-15"></i> <?php echo lang('edit_profile'); ?></h4>
  <hr class="my-15">
  <div class="row">
  <div class="col-md-6">
  <div class="form-group">
  <label><?php echo lang('username'); ?></label>
  <input type="text" class="form-control" dir="auto" name="username" value="<?php echo $uInfo_un ?>"   placeholder="<?php echo lang('username'); ?>" >
  </div>
  </div>
  <div class="col-md-6">
  <div class="form-group">
  <label><?php echo lang('email'); ?></label>
  <input type="text" dir="auto" class="form-control" name="email" value="<?php echo $uInfo_em ?>"   placeholder="<?php echo lang('email'); ?>">
  </div>
  </div>
  </div>
  <div class="row">
  <div class="col-md-6">
  <div class="form-group">
  <label ><?php echo lang('phone'); ?></label>
  <input type="text" dir="auto" class="form-control" name="phone" value="<?php echo $uInfo_ph ?>"   placeholder="<?php echo lang('phone'); ?>">
  </div>
  </div>

  <div class="col-md-6">
  <div class="form-group">
  <label ><?php echo lang('password'); ?></label>
  <input type="password" dir="auto" class="form-control" data-strength name="password" placeholder="<?php echo lang('password'); ?>">
  </div>
  </div>
  <div class="col-md-6">
  <div class="form-group">
  <label ><?php echo lang('admin'); ?></label>
  <select name="admin" class="form-control" >
  <option <?php if($uInfo_type == "admin"){echo "selected";} ?>><?php echo lang('yes'); ?></option>
  <option <?php if($uInfo_type == "user"){echo "selected";} ?>><?php echo lang('no'); ?></option>
  </select>
  </div>
  </div>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
  <button type="submit" value="<?php echo lang('save_changes'); ?>" name="submit_uInfo" class="btn btn-rounded btn-primary btn-outline" >
  <i class="ti-save-alt"></i> <?php echo lang('save'); ?>
  </button>
  </div>
  </div>
  </form>
  </div>
  <!-- /.box -->
  </div>
  </div>

  <div class="box">

  <div class="col-lg-6 col-12 fixed-width-form">
  <div class="box">

  <!-- /.box-header -->
  <form class="form" action="" method="post">
  <div class="box-body">
    <h4 class="box-title text-info"> <?php echo lang('activate'); ?></h4>
    <hr class="my-15">
  <!-- /.box-body -->
  <p style="margin: 8px 0px;"><button class="btn btn-rounded btn-primary btn-outline" name="active" type="submit"><?php if($user_email_status == "not verified"){echo"Activate";}else{echo"De-activate";} ?></button></p>

  </div>
  </form>
  </div>
  <!-- /.box -->
  </div>
  </div>
  <div class="box">

  <div class="col-lg-6 col-12 fixed-width-form">
  <div class="box">

  <!-- /.box-header -->
  <form class="form" action="" method="post">
  <div class="box-body">
    <h4 class="box-title text-danger"> <?php echo lang('sus'); ?></h4>
    <hr class="my-15">
  <!-- /.box-body -->
  <button type="submit" value="<?php echo lang('sus'); ?>" name="susbend" class="btn btn-rounded btn-danger btn-outline" >
  <i class="ti-danger"></i> <?php if($status == "0"){echo"Susbend";}else{echo"De-susbend";} ?>
  </button>
  </div>
  </form>
  </div>
  <!-- /.box -->
  </div>
  </div>

  <?php }else{
  if ($ed == $_SESSION['id']) {
  echo "<p class='alertYellow'>".lang('uCan_access_your_data_from_settings')."</p>";
  }else{
  echo "<p class='alertRed'>".lang('uCannot_access_admin_data')."</p>";
  }
  }

  }else{
  echo "<p class='alertRed'>".lang('username_not_exists')."</p>";
  } ?>
  </div>

  </div>
  <!-- /.Add User-->

  </section>
  <!-- /.content -->

  </div>
  </div>
  <!-- /.content-wrapper -->

  <?php //include "../includes/footer.php";
  $this->load->view('includes/footer');
  ?>
  <!-- Control Sidebar -->

  </div>
  <!-- ./wrapper -->
  <?php $this->load->view('includes/endJScodes', $data); ?>
<?php $this->load->view('includes/jslinks'); ?>
</body>
</html>
