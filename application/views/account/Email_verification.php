<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__file__) . 'error_log.txt');
error_reporting(E_ALL ^ E_NOTICE);


$getLang = trim(filter_var(htmlentities($_GET['lang']),FILTER_SANITIZE_STRING));
if (!empty($getLang)) {
    $_SESSION['language'] = $getLang;
}

error_reporting(0);

$email_var = filter_var(htmlentities($_POST['edit_email']),FILTER_SANITIZE_STRING);
$phone_var = filter_var(htmlentities($_POST['edit_phone']),FILTER_SANITIZE_STRING);
if(isset($_POST['resend'])){
$id = $_SESSION['id'];
  if (empty($email_var) || empty($phone_var)) {
      $error = "<p id='error_msg'>".lang('please_fill_required_fields')."</p>";
      $stop = "1";
  }
  if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
      $error = "<p id='error_msg'>".lang('invalid_email_address')."</p>";
      $stop = "1";
  }
  $session_un = $_SESSION['Username'];
  $emExist = "SELECT Email FROM signup WHERE Email ='$email_var' AND id!='$id'";
  $FetchedData = $this->comman_model->get_all_data_by_query($emExist);

  $emExistCount = count($FetchedData); //$emExist->rowCount();
  if ($emExistCount > 0) {
  if ($email_var != $_SESSION['Email']) {
  $error = "<p id='error_msg'>".lang('email_already_exist')."</p>";
  $stop = "1";
  }
  }


  $phExist = "SELECT phone FROM signup WHERE phone ='$phone_var' AND id!='$id'";
  $FetchedData = $this->comman_model->get_all_data_by_query($phExist);

  $phExistCount = count($FetchedData); //$emExist->rowCount();
  if ($phExistCount > 0) {
  if ($phone_var != $_SESSION['phone']) {
  $error = "<p id='error_msg'>".lang('invalid_phone_number')."</p>";
  $stop = "1";
  }
  }
  if ($stop != "1") {
      $update_info_sql = "UPDATE signup SET Email= '$email_var' AND phone= '$phone_var' WHERE id= '$id'";
      $update_info = $this->comman_model->run_query($update_info_sql);

      if (isset($update_info)) {
        $_SESSION['Email'] = $email_var;
          $_SESSION['phone'] = $phone_var;
          $user_activation_code = $_SESSION['user_activation_code'];

          $phone_activation_code = $_SESSION['phone_activation_code'];

          //SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

          $terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
          $mail_body = email_body($signup_username,base_url().'Account/email_check?activation_code='.$user_activation_code,'شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);

        $result = SendEmail('Email Verification',$signup_email,$mail_body);

        $sended = "1";
  }

}}
$id = $_SESSION["id"];
$fetchUsers_sql = "SELECT user_email_status FROM signup WHERE id='$id'";
$result = $this->comman_model->get_all_data_by_query($fetchUsers_sql);
$array=array();
foreach($result as $item){
$user_email_status = $item["user_email_status"];
$_SESSION['user_email_status'] = $user_email_status;
}
if($_SESSION['user_email_status'] == "verified"){
header("location:".base_url()."Dashboard");
}
?>
<!DOCTYPE html>
<html lang="en" translate="no">
<head>
	<title><?php echo project_name()." - Email verification" ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

		<?php
 $this->load->view('includes/head_imports_main.php');
 ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="<?php echo base_url();?>asset/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css">
    <style type="text/css">
        /* FONTS */
        @import url('https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');

        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }

        /* RESET STYLES */
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px){
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] { margin: 0 !important; }
    </style>
</head>
<body class="hold-transition <?php echo lang('html_dir'); ?> <?php echo $layoutmode; //include "includes/mode.php"; ?> sidebar-mini theme-primary">
<!-- Site wrapper -->
<div class="wrapper">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td align="center">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 10px 10px;">
                            <a href="#" target="_blank" style="text-decoration: none;">
                                <span style="display: block; font-family: 'Poppins', sans-serif; color: #3e8ef7; font-size: 36px;" border="0"><b>المقر للصرافة</b></span>
                            </a>

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <!-- HERO -->
        <tr>
            <td align="center" style="padding: 0px 10px 0px 10px;">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <p align="center" id="general_save_result"><?php echo $error; ?><?php echo $general_save_result; ?></p>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Poppins', sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 2px; line-height: 48px;">
                            <h1 style="font-size: 36px; font-weight: 600; margin: 0;direction: rtl;">مرحبا بك <?php echo $_SESSION['Username']; ?></h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- COPY BLOCK -->
        <tr>
            <td align="center" style="padding: 0px 10px 0px 10px;">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <!-- COPY -->
                    <tr>

                        <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                            <h3 style="margin: 0;line-height: 36pt;">
                                    تم إرسال رسالة تأكيد لبريدك الإلكتروني
                                    (<span class="text-success"><?php echo $_SESSION['Email']; ?></span>)
و رقم هاتفك
                                    (<span class="text-success"><?php echo $_SESSION['phone']; ?></span>)
                                    الرجاء قم بتحقق من بريدك الاكتروني أو رسائل الSMS لتقوم بتأكيد حسابك
                            </h3>
                        </td>
                    </tr>
                    <!-- BULLETPROOF BUTTON -->
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 30px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td>
                                                  <div class="form-group">
                                                      <label for="code">أدخل رقم التاكيد. للتأكد من حسابك.</label>
                                                      <input type="text" name="code" onkeypress="verifi()" class="form-control" maxlength="6" style="width: 280px;text-align:center" id="code" aria-describedby="emailHelp" placeholder="أدخل رقم التأكيد هنا">
                                                  </div>
                                           </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="center" style="padding: 0px 30px 0px 30px; color: #666666; font-family: &apos;Lato&apos;, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                            <form action="" method="post" class="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">خطا في بريدك الاكتروني أو رقم الهاتف؟ يمكنك تغيره من هنا.</label>
                                <input type="text" name="edit_phone" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['phone']; ?>" aria-describedby="phoneHelp" placeholder="<?php echo lang('phone'); ?>">
                                <input type="email" name="edit_email" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['Email']; ?>" aria-describedby="emailHelp" placeholder="<?php echo lang('email'); ?>">
                            </div>
                            <div align="center" style="border-radius: 3px;" bgcolor="#17b3a3">
                                <button type="submit" name="resend" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #28a745; text-decoration: none; color: #28a745; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #17b3a3; display: inline-block;">اعادة ارسال الرسالة</button>
                                <a href="<?php echo base_url();?>Account/logout" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #eee; background-color: #dc3545; text-decoration: none; color: #eee; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #dc3545; display: inline-block;">رجوع</a>

                            </div>
                            <div align="center" style="border-radius: 3px;" bgcolor="#17b3a3">
                            </div>
                            </form>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
        <!-- FOOTER -->
        <tr>
            <td align="center" style="padding: 10px 10px 50px 10px;">

            </td>
        </tr>
    </table>

</div>
<!-- ./wrapper -->
<script>

function verifi(){
var cContent = $.trim($('#code').val());
if (cContent == '') {

}else{
$.ajax({
type: "POST",
url: "Account/phone_check",
data: {"cContent":cContent },
success: function(done){
if (done == 'yes') {
  setTimeout('window.location.href = "<?php echo base_url();?>Dashboard"; ',1000);
}
}
});
}

}
</script>

<!-- Vendor JS -->
<script src="<?php echo base_url();?>asset/js/vendors.min.js"></script>

<!-- Crypto Tokenizer Admin App -->
<script src="<?php echo base_url();?>asset/js/template.js"></script>
<script src="<?php echo base_url();?>asset/js/demo.js"></script>


</body>
</html>
