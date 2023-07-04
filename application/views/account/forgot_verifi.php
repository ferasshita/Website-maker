<?php
ini_set('error_log', dirname(__file__) . 'error_log.txt');
// ========================= config the languages ================================
error_reporting(E_NOTICE ^ E_ALL);
$data['page_name']['name'] = "verify";

$passco = filter_var(htmlentities($_POST['passco']),FILTER_SANITIZE_STRING);
$pd = filter_var(htmlentities($_POST['pd']),FILTER_SANITIZE_STRING);
$cpd = filter_var(htmlentities($_POST['cpd']),FILTER_SANITIZE_STRING);
?>
<html translate="no" dir="<? echo lang('html_dir'); ?>">
<head>
  <?php $this->load->view('includes/head_info', $data); ?>
  <meta http-equiv="refresh" content="10000">

    </head>
    <body style="background:#d3d3d3" class="hold-transition <?php echo lang('html_dir'); ?> theme-primary bg-gradient-primary">

      <?php

if($countSaved < 1){
  ?>
  <style type="text/css">
   body{
   background: #fff;
   }
       .error_page_btn{
   background: whitesmoke;
   padding: 8px;
   border-radius: 3px;
   color: #6b6b6b;
   text-decoration: none;
   box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.05);
   transition: background 0.1s , color 0.1s;
       }
       .error_page_btn:hover, .error_page_btn:focus{
   background: #4a708e;
   color: #fff;
   text-decoration: none;
       }
       .error_div{
   padding: 15px;
   max-width: 800px;
   color: #383838;
   box-shadow: none;
   border: 1px solid rgba(217, 217, 217, 0.36);
   }
   </style>
   <div align="center" style="margin-top: 150px;margin-bottom: 150px;">
   <div class="post error_div" style="border-radius:10px;" align="center">
   <h1 style="font-weight: bold;"><img src="imgs/main_icons/1f915.png" style="width: 80px;height: 80px;" /> <?php echo lang('profilePageNotFound_str1'); ?></h1>
   <h3><?php echo lang('profilePageNotFound_str2'); ?></h3><br>
   <a href="javascript:history.back()" style="border-radius:4px;" class="error_page_btn"><?php echo lang('profilePageNotFound_str3'); ?></a>
   </div></div>
<?php }else{?>
  <div class="container h-p100">
      <div class="row align-items-center justify-content-md-center h-p100">

          <div class="col-12">
              <div class="row justify-content-center no-gutters">
                  <div class="col-lg-4 col-md-5 col-12">
                      <div style="background:#FFFFFF" class="bg-white-10 rounded5">
                          <div class="content-top-agile p-10 pb-0">
                              <h2 class="text-black"><?php echo lang('forgot_password'); ?> </h2>
                          </div>
                          <div class="p-30">
                                  <div class="form-group">
                                      <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                              <span class="input-group-text bg-transparent text-black"><i class="ti-lock"></i></span>
                                          </div>
                                      <input type="password" name="pd" id="pd" class="login_signup_textfield form-control pl-15 bg-transparent text-black plc-white" placeholder="<?php echo lang('password'); ?>"/>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                              <span class="input-group-text bg-transparent text-black"><i class="ti-lock"></i></span>
                                          </div>
                                          <input type="password" name="cpd" id="cpd" class="login_signup_textfield form-control pl-15 bg-transparent text-black plc-white" placeholder="<?php echo lang('confirm_password'); ?>"/>
                                        </div>
                                        <input type="hidden" name="passco" id="passco" value="<?php echo"$story_id"; ?>">

                                  </div>

                                  <div class="row">

                                      <!-- /.col -->
                                      <div class="col-12 text-center">
                                          <button type="button" id="loginFunCode" class="fix-login-button btn mdc-button btn-info btn-rounded mt-10" name="send_email" id="loginFunCode"><?php echo lang('send'); ?></button>

</div>
                                      <!-- /.col -->
                                  </div>
                                  <p id="login_wait" style="margin: 0px;"></p>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
  </div>
  <script type="text/javascript">
    function loginUser(){
      var pd = document.getElementById("pd").value;
      var cpd = document.getElementById("cpd").value;
      var passco = document.getElementById("passco").value;
        $.ajax({
            type:'POST',
            url:'<?php echo base_url()."account/doforgot_verifi";?>',
            data:{'pd':pd,'cpd':cpd,'passco':passco},
            beforeSend:function(){
                $('.fix-login-button').hide();
                $('#login_wait').html("<?php echo lang('loading'); ?>...");
            },
            success:function(data){
                $('#login_wait').html(data);
                if (data == 1) {
                    $('#login_wait').html("<p class='alertGreen'><?php echo lang('welcome'); ?>..</p>");
                    setTimeout(' window.location.href = "<?php echo base_url()."Dashboard";?>"; ',2000);
                }else{
                    $('#login_wait').html(data);
                    $('.fix-login-button').show();
                }
            },
            error:function(err){
                alert(err);
            }
        });
    }
    $('#loginFunCode').click(function(){
        loginUser();
    });
    $(".form-control").keypress( function (e) {
        if (e.keyCode == 13) {
            loginUser();
        }
    });
  </script>

<!--====================================[ enter password ]====================================-->
	<script src="<?php echo base_url();?>Asset/js/vendors.min.js"></script>
<?php } ?>
    </body>
    </html>
