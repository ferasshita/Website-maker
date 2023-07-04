<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();

		$this->load->helper(
			array('langs', 'IsLogedin', 'Phonecodes','Sendmail','Sendsms','emailBody','functions_zone','app_info')
		);
		$this->load->model('account_model');
		$this->load->model('comman_model');
		$getLang = trim(filter_var(htmlentities($_GET['lang']),FILTER_SANITIZE_STRING));
		if (!empty($getLang)) {
			$_SESSION['language'] = $getLang;
		}else{
			$_SESSION['language'] = "العربية";

		}
		LoadLang();

//==========================[Captcha]===========================
		global $public_key, $security_key, $google_client_id, $google_secret_id;
//captcha
		$public_key = "";
		$security_key = "";
//google signup
		$google_client_id = "";
		$google_secret_id = "";

		function getIPAddress() {
			// If the user is accessing the site through a proxy, use the proxy's IP address
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip_address = $_SERVER['HTTP_CLIENT_IP'];
			}
			// If the user is accessing the site through a load balancer, use the load balancer's IP address
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			// Otherwise, use the user's actual IP address
			else {
				$ip_address = $_SERVER['REMOTE_ADDR'];
			}
			return $ip_address;
		}
	}

//==================================[terms]=====================================
	public function terms(){

		$data['page_name']['name'] = "terms";


		$url=base_url()."Dashboard";
		$this->load->view('account/terms', $data);
	}
//==================================[login_page]=====================================
	public function login(){
		global $public_key, $google_client_id;
		$data['google_client_id'] = $google_client_id;
		$data['public_key'] = $public_key;

		$data['page_name']['name'] = "login";

		$data['token'] = bin2hex(random_bytes(32));
		$_SESSION['csrf_token'] = $data['token'];

		$url=base_url()."Dashboard";
		loginRedirect($url);
		$this->load->view('account/login', $data);
	}
//========================[unsubscribe]==================================
	public function unsubscribe(){

	}
//==================================[Forgot_password]=========================
	public function Forgot_password(){
		ini_set('error_log', dirname(__file__) . 'error_log.txt');
		$data['page_name']['name'] = "forget password";

		$url=base_url()."Dashboard";
		loginRedirect($url);
		$message="";

		$this->load->view('account/Forgot_password',$data);
	}
//==================================[Forgot_password_function]=========================
	public function doforgotpass(){
		$email = htmlentities($_POST['email'], ENT_QUOTES);

		if($email == NULL){
			echo "<p class='alertRed'>".lang('email_cant_null')."</p>";
			return false;
		}

		$emExist = "SELECT email FROM signup WHERE email = '$email'";
		$FetchData=$this->comman_model->get_all_data_by_query($emExist);
		$emExistCount = count($FetchData);
		foreach ($FetchData as $postsfetch ) {
			$emxv = $postsfetch['email'];
		}

		if ($emExistCount > 0) {
			if ($email != $emxv) {
				echo "<p class='alertRed'>".lang('invalid_email_address')."</p>";
				return false;
			}

			$emExist = "SELECT username FROM signup WHERE email ='$email'";
			$FetchData=$this->comman_model->get_all_data_by_query($emExist);
			foreach ($FetchData as $postsfetch) {
				$username = $postsfetch['username'];
			}

			$forg_id = rand(0,9999999)+time();
			$time = time();
			$data = array(
				'email'   => $email,
				'numi'      => $forg_id,
				'time'	=>	$time
			);
			$this->account_model->insert_entry("forg_pass",$data);

			$terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
			$mail_body = email_body($username,base_url().'Account/forgot_verifi?veri='.$forg_id,'لتغير كلمه المرور قم بفتح الرابط التالي. وان لم يعمل الرابط فحاول نسخ الرابط ولصقه في المتصفح.',$terms_mail);

			$result = SendEmail('Change your Alsaraf password',$email,$mail_body);

			if($result)
			{
				echo 1;
			}else{
				echo "<p class='alertRed'>unexpected error email had not been sent</p>";
			}
		}else{
			echo "<p class='alertRed'>".lang('email_not_exist')."</p>";
		}
	}
//==================================[logout]=====================================
	public function logout(){
		//update signup online
		$myid = $_SESSION['id'];
		$online_status = "0";

		$data = array(
			'online'   => $online_status,
		);

		$where=array('id' => $myid);
		$this->comman_model->update_entry("signup",$data,$where);

		setcookie("id", "", time() - (10 * 365 * 24 * 60 * 60), "/", false, true);
		session_destroy();
		session_unset();
		$baseurl=base_url()."Account/login";
		header("location:  $baseurl");
	}
//==================================[login_function]=====================================
	public function dologin(){
		error_reporting(0);

		if(filter_var(htmlentities($_POST['csrf_token']),FILTER_SANITIZE_STRING) !== $_SESSION['csrf_token']){
			echo"<p class='alertRed'>Invalid token</p>";
			return false;
		}

		$username = htmlentities($_POST['un'], ENT_QUOTES);
		$password = htmlentities($_POST['pd'], ENT_QUOTES);

		if($username == null && $password == null){
			echo "<p class='alertRed'>".lang('enter_username_to_login')."</p>";
		}elseif ($username == null){
			echo "<p class='alertRed'>".lang('enter_username_to_login')."</p>";
		}elseif($password == null){
			echo "<p class='alertRed'>".lang('enter_password_to_login')."</p>";
		}else{

			$data=$this->account_model->get_account_by_username($username);
			foreach ($data as $row) {
				$rUsername = $row['username'];
				$rEmail = $row['email'];
				$rPassword = $row['Password'];
				$sus = $row['sus'];
			}

			if (isset($_COOKIE['linAtt']) AND $_COOKIE['linAtt'] == $username) {
				echo "<p class='alertRed'>".lang('cannot_login_attempts').".</p>";
			}else{
				// check if user try to login in his username or email
				$email_pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
				if (preg_match($email_pattern, $username)) {
					$un_or_em = $rEmail;
				}else{
					$un_or_em = $rUsername;
				}

				$isverfied=password_verify($password,$rPassword);

				if ($un_or_em != $username) {
					echo "<p class='alertRed'>".lang('un_email_not_exist')."!</p>";

				}elseif (!$isverfied) {
					$checkAttempts = "SELECT login_attempts FROM signup WHERE username = '$username'";
					$FetchData=$this->comman_model->get_all_data_by_query($checkAttempts);
					foreach($FetchData as $attR)
					{
						$login_attempts = $attR['login_attempts'];
					}

					if ($login_attempts < 3) {
						$attempts = $login_attempts + 1;
						$addAttempts = "UPDATE signup SET login_attempts ='$attempts' WHERE username='$username'";
						$addAttempts=$this->comman_model->run_query($addAttempts);
					}elseif ($login_attempts >= 3) {
						$attempts = 0;

						$addAttempts = "UPDATE signup SET login_attempts ='$attempts' WHERE username='$username'";
						$addAttempts=$this->comman_model->run_query($addAttempts);
						setcookie("linAtt", "$username", time() + (60 * 5), '/');
					}
					$LoginTry = 3 - $login_attempts;
					echo "<p class='alertRed'>".lang('password_incorrect_you_have')." $LoginTry ".lang('attempts_to_login')."</p>";
				}elseif($sus == "1"){
					echo "<p class='alertRed'>".lang('sus_msg')."!</p>";
				}else{
					$query=$this->account_model->check_login($username,$rPassword);

					$num = $query->num_rows();
					if($num == 0){

						echo "<p class='alertRed'>".lang('un_and_pwd_incorrect')."!</p>";
					}else{
						$attempts = "0";
						$addAttempts = "UPDATE signup SET login_attempts ='$attempts' WHERE username='$username'";
						$addAttempts=$this->comman_model->run_query($addAttempts);

						$_SESSION['attempts'] = 0;
					}

					$this->GetLoginWhileFetch($query,$req);
					echo 1;
				}}}
	}


	function GetLoginWhileFetch($query,$req){
		$row_fetch = $query->row_array();

		$fields = $this->db->field_data('signup');
		foreach ($fields as $postsfetchi)
		{
			${"var".$postsfetchi->name} = $row_fetch[$postsfetchi->name];
		}

//======================[add to attendence]==================================
		$online_status = "1";
		$data = array(
			'online'   => $online_status,
		);
		$where=array('id' => $row_id);
		$this->comman_model->update_entry("signup",$data,$where);

		$fetchUsers_sql = "SELECT status FROM devices WHERE user_id='$varid' AND ip='".getIPAddress()."'";
		$result = $this->comman_model->get_all_data_by_query($fetchUsers_sql);
		$count_ip = count($result);
		foreach($result as $item){
			$ip_status = $item["status"];
		}
		if($ip_status == 1){
			echo"<p class='alertRed'>".lang('sus_msg')."</p>";
			return false;
		}
		if($count_ip < 1){
			$data = array(
				'user_id'      => $varid,
				'ip'      => getIPAddress(),
			);
			$this->account_model->insert_entry("devices",$data);
		}
//=======================[cookie]===================================
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options   = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = getIPAddress();
		$encryption = openssl_encrypt($varid, $ciphering, $encryption_key, $options, $encryption_iv);

		setcookie('id', $encryption, time() + (10 * 365 * 24 * 60 * 60), "/", false, true);

//=============================[from settings table]============================
		$uisql = "SELECT * FROM settings WHERE user_id= '$row_id' AND access='user'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		foreach($udata as $rowx){
			$value_n = $rowx['value'];
			$type_n = $rowx['type'];
			$_SESSION[$type_n] = $value_n;
		}
		$uisql = "SELECT * FROM settings WHERE user_id= '$shop_id' AND access='shop'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		foreach($udata as $rowx){
			$value_n = $rowx['value'];
			$type_n = $rowx['type'];
			$_SESSION[$type_n] = $value_n;
		}
		$uisql = "SELECT * FROM settings WHERE user_id= '$boss_id' AND access='boss'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		foreach($udata as $rowx){
			$value_n = $rowx['value'];
			$type_n = $rowx['type'];
			$_SESSION[$type_n] = $value_n;
		}
//===========================[create sessions]==================================
		$fields = $this->db->field_data('signup');
		foreach ($fields as $postsfetchi)
		{
			$_SESSION[$postsfetchi->name] = ${"var".$postsfetchi->name};
		}
	}

//==================================[regester_page]=========================
	public function register(){
		if(project_settings('signup') == "signup"){
			$this->load->view('errors/404');
		}else{
			global $public_key;
			$data['captcha']["public_key"]=$public_key;


			$data['page_name']['name'] = "register";



			$data['token'] = bin2hex(random_bytes(32));
			$_SESSION['csrf_token'] = $data['token'];

			$url=base_url()."Dashboard";
			loginRedirect($url);
			$phones=LoadPhoneCodes();
			$data["phones"]=$phones;
			$this->load->view('account/register',$data);
		}
	}
	public function dogoogle(){
		// Exchange the Google ID token for an access token and a refresh token
		$google_token = $_POST['google_token'];
		global $google_client_id, $google_secret_id;

		$client = new Google_Client();
		$client->setClientId($google_client_id);
		$client->setClientSecret($google_secret_id);
		$client->setScopes(['email', 'profile']);

		$payload = $client->verifyIdToken($google_token);
		$google_id = $payload['sub'];
		$google_name = $payload['name'];
		$google_email = $payload['email'];

		$accessToken = $client->fetchAccessTokenWithAuthCode($google_token);
		$refreshToken = $accessToken['refresh_token'];
		$accessToken = $accessToken['access_token'];

		// Check if the user's Google ID is already in the database
		$sql = 'SELECT * FROM signup WHERE google_id = "' . $mysqli->real_escape_string($google_id) . '"';
		$result = $mysqli->query($sql);

		if ($result->num_rows == 0) {
			// Create a new user account in the database
			$data = array(
				'id'      => $mysqli->real_escape_string($google_id),
				'username'      => $mysqli->real_escape_string($google_name),
				'email'      => $mysqli->real_escape_string($google_email) ,
				'access_token' => $mysqli->real_escape_string($accessToken),
				'refresh_token'      => $mysqli->real_escape_string($refreshToken),
				'language'      => 'العربية',
				'account_type'      => 'google',
				'mode'      => 'auto',
				'account_setup'      => date('d/m/Y'),
				'user_email_status'      => 'verified',
			);
			$this->account_model->insert_entry("signup",$data);
		} else {
			// Update the user's access token and refresh token in the database
			$sql = 'UPDATE signup SET access_token = "' . $mysqli->real_escape_string($accessToken) . '", refresh_token = "' . $mysqli->real_escape_string($refreshToken) . '" WHERE google_id = "' . $mysqli->real_escape_string($google_id) . '"';
			$mysqli->query($sql);
		}
		$query=$this->account_model->check_google($mysqli->real_escape_string($google_id));

		$num = $query->num_rows();
		// Set the session variables and redirect to the home page
		$this->GetLoginWhileFetch($query,'google_sign');
		echo 1;
		exit;

	}
// ============================= [ Signup code ] =============================
	public function doregister(){
		session_start();
		global $public_key, $security_key;

//===================================[signup enteries]==========================
		if(filter_var(htmlentities($_POST['csrf_token']),FILTER_SANITIZE_STRING) !== $_SESSION['csrf_token']){
			echo"<p class='alertRed'>Invalid token</p>";
			return false;
		}
		$user_activation_code = md5(rand());
		$signup_id = (rand(0,99999).time()) + time();
		$phone_activation_code = rand(0,999999);
		$account_type = filter_var(htmlentities($_POST['account_type']),FILTER_SANITIZE_STRING);
		if($account_type == NULL){
			$account_type = "user";
		}
		$req=htmlentities($_POST['req'], ENT_QUOTES);
		$uncode = filter_var(htmlentities($_POST['phone_code']),FILTER_SANITIZE_NUMBER_INT);
		if(empty($uncode)){
			$uncode = "218";
		}
		$phone_val = filter_var(htmlentities($_POST['fn']),FILTER_SANITIZE_STRING);
		$phone_format = ltrim($phone_val, '0');
		$signup_fullname = "+".$uncode."".$phone_format;

		$signup_username = filter_var(htmlentities($_POST['un']),FILTER_SANITIZE_STRING);
		$signup_email = filter_var(htmlentities($_POST['em']),FILTER_SANITIZE_STRING);
// =========================== password hashinng ==================================
		$signup_password_var = filter_var(htmlentities($_POST['pd']),FILTER_SANITIZE_STRING);
		$options = array(
			'cost' => 12,
		);

		$signup_password = password_hash($signup_password_var, PASSWORD_BCRYPT, $options);

		$signup_cpassword = filter_var(htmlentities($_POST['cpd']),FILTER_SANITIZE_STRING);

		$signup_language = "العربية";
		if ($req == "sign" && !isset($_SESSION['id'])) {
			//===================================[start of the reCAPTCHA]===========================
			function getData($url,$dataArray){
				$ch = curl_init();
				$data = http_build_query($dataArray);
				$getUrl = $url."?".$data;
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_URL, $getUrl);
				curl_setopt($ch, CURLOPT_TIMEOUT, 80);
				$response = curl_exec($ch);
				if(curl_error($ch)){
					return 'Request Error:' . curl_error($ch);
				}else{
					return json_decode($response,true);
				}
				curl_close($ch);
			}

			if(project_settings('captcha') != "captcha"){
				$urlGoogleCaptcha = 'https://www.google.com/recaptcha/api/siteverify';
				$checkkey = $security_key;
				$recaptchaSecretKey = $checkkey;
				$verficationResponse = $_POST['recaptchaResponses'];
				$dataArray = [
					'secret'=>$recaptchaSecretKey,
					'response'=>$verficationResponse
				];
				$recaptchaResonse = getData($urlGoogleCaptcha,$dataArray);
				if(is_array($recaptchaResonse))
				{
					if($recaptchaResonse['success'] == 1)
					{}else{
						//google returns false;
						echo "<p class='alertRed'>".json_encode(['msg'=>'Google reCaptcha Error'])."</p>";
						return false;
					}
				}else{
					//issue in curl request
					echo "<p class='alertRed'>".json_encode(['msg'=>'Error with google'])."</p>";
					return false;
				}
			}

		}
		//===================================[end of the reCAPTCHA]=============================
		//===============================check username==================================
		$exist_username=$this->comman_model->get_dataCount_where("signup","username",$signup_username);

		$exist_email=$this->comman_model->get_dataCount_where("signup","email",$signup_email);
		$num_un_ex = $exist_username;
		$num_em_ex = $exist_email;

		if(($signup_fullname == null || $signup_username == null || $signup_email == null || $signup_password == null || $signup_cpassword == null) || ($signup_username == null) && $typ == "shop"){
			echo "<p class='alertRed'>".lang('please_fill_required_fields')."</p>";
			return false;
		}elseif($num_un_ex >= 1){
			echo "<p class='alertRed'>".lang('user_already_exist')."</p>";
			return false;
		}elseif($num_em_ex >= 1){
			echo "<p class='alertRed'>".lang('email_already_exist')."</p>";
			return false;
		}elseif((strlen($signup_password_var) < 6 || $signup_password_var == "qwe123()" || $signup_password_var == "Qwe123()")){
			echo "
		<ul class='alertRed' style='list-style:none;'>
		<li><b>".lang('password_not_allowed')." :</b></li>
		<li><span class='fa fa-times'></span> ".lang('signup_password_should_be_1').".</li>
		<li><span class='fa fa-times'></span> ".lang('signup_password_should_be_2').".</li>
		<li><span class='fa fa-times'></span> ".lang('signup_password_should_be_3').".</li>
		<li><span class='fa fa-times'></span> ".lang('signup_password_should_be_4').".</li>
		</ul>";
			return false;
		}elseif($signup_password_var != $signup_cpassword){
			echo "<p class='alertRed'>".lang('password_not_match_with_cpassword')."</p>";
			return false;
		}elseif((strpos($signup_username, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $signup_username) || !preg_match('/[A-Za-z0-9]+/', $signup_username))) {
			echo "
		<ul class='alertRed' style='list-style:none;'>
		<li><b>".lang('username_not_allowed')." :</b></li>
		<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_1').".</li>
		<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_2').".</li>
		<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_3').".</li>
		<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_4').".</li>
		<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_5').".</li>
		</ul>";
			return false;
		}elseif (!filter_var($signup_email, FILTER_VALIDATE_EMAIL)) {
			echo "<p class='alertRed'>".lang('invalid_email_address')."</p>";
			return false;
		}elseif (!preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $signup_email)) {
			echo "<p class='alertRed'>".lang('invalid_email_address')."</p>";
			return false;
		}elseif ((!preg_match('/[0-9]/', $signup_fullname) || strlen($signup_fullname) < 6)) {
			echo "<p class='alertRed'>".lang('invalid_phone_number')."</p>";
			return false;
		}else{
			if ($req == "admin_sign" && isset($_SESSION['id'])){
				$verifi_now = "verified";
			}else{
				$verifi_now = "not verified";
			}

			$recordCounts=$this->comman_model->get_all_dataCounts_by_query("SELECT id FROM signup");

			$cusers_q_num_rows =$recordCounts;

			$data = array(
				'id'      => $signup_id,
				'phone'      => $signup_fullname,
				'username'      => $signup_username,
				'email'      => $signup_email,
				'Password'      => $signup_password,
				'language'      => $signup_language,
				'account_type'      => $account_type,
				'mode'      => 'auto',
				'account_setup'      => date('d/m/Y'),
				'user_activation_code'      => $user_activation_code,
				'phone_activation_code'      => $phone_activation_code,
				'user_email_status'      => $verifi_now,
			);
			$this->account_model->insert_entry("signup",$data);

		}
		//===========================================[email send]======================================================================
		if ($req == "sign" && !isset($_SESSION['id']))
		{
			if(project_settings('email') == "email"){
				$terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
				$mail_body = email_body($signup_username,base_url().'Account/email_check?activation_code='.$user_activation_code,'شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);
			}

			//SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

			$result = SendEmail('Email Verification',$signup_email,$mail_body);


			if($result){
				$message = '<label class="text-success">Register Done, Please check your mail.</label>';
			}
			// ========================== login code after signup ============================

			$query=$this->account_model->check_login($signup_username,$signup_password);
			$num = $query->num_rows();

			$this->GetLoginWhileFetch($query,$req);

		}else{
			if(project_settings('email') == "email"){
				$terms_mail = "يتم ارسال هده الرساله لان تم تسجيلك في نظام project ارسال هذه الرسالة من قبل تطبيق الصرّاف وهده هي بيانات تسجيل الدخول.
<br> اسم المستخدم: $signup_username
<br> كلمة السر: $signup_password_var";
				$mail_body = email_body($signup_username,'','شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);
			}

			//SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

			$result = SendEmail('Email Verification',$signup_email,$mail_body);
		}
		echo 1;

	}
//==================================[forget_verification]=========================
	public function forgot_verifi(){
		$url=base_url()."Dashboard";
		loginRedirect($url);

		ini_set('error_log', dirname(__file__) . 'error_log.txt');
// ========================= config the languages ================================
		error_reporting(E_NOTICE ^ E_ALL);
		$data['page_name']['name'] = "verify";

		$story_id = filter_var(htmlentities($_GET['veri']), FILTER_SANITIZE_NUMBER_INT);
		$data["story_id"]=$story_id;

		$fPosts_sql_sql = "SELECT * FROM forg_pass WHERE numi = '$story_id'";
		$FetchData=$this->comman_model->get_all_data_by_query($fPosts_sql_sql);
		$countSaved = count($FetchData);
		$data["countSaved"]=$countSaved;

		if($countSaved < 1){
			$this->load->view('errors/404',$data);
		}else{
			$this->load->view('account/forgot_verifi',$data);
		}

	}
	public function doforgot_verifi(){
		$passco = filter_var(htmlentities($_POST['passco']),FILTER_SANITIZE_STRING);
		$pd = filter_var(htmlentities($_POST['pd']),FILTER_SANITIZE_STRING);
		$cpd = filter_var(htmlentities($_POST['cpd']),FILTER_SANITIZE_STRING);

		$emExist ="SELECT email FROM forg_pass WHERE numi ='$passco'";
		$FetchData=$this->comman_model->get_all_data_by_query($emExist);
		foreach ($FetchData as $postsfetch) {
			$email = $postsfetch['email'];
		}

		if($pd == null || $cpd == null){
			echo "<p class='alertRed'>".lang('please_fill_required_fields')."</p>";
		}elseif(strlen($pd) < 6){
			echo "<p class='alertRed'>".lang('password_short').".</p>";
		}elseif($pd != $cpd){
			echo "<p class='alertRed'>".lang('password_not_match_with_cpassword')."</p>";
		}else{

			$options = array(
				'cost' => 12,
			);
			$password_var = password_hash($pd, PASSWORD_BCRYPT, $options);

			$update_info_sql = "UPDATE signup SET Password= '$password_var' WHERE email= '$email'";
			$update_info=$this->comman_model->run_query($update_info_sql);
			echo 1;

			$query=$this->account_model->check_login($email,$password_var);

			$num = $query->num_rows();
			$this->GetLoginWhileFetch($query,'login_code');

			$loginsql = "DELETE FROM forg_pass WHERE email= '$email'";
			$IsDelete = $this->comman_model->run_query($loginsql);

			exit;
		}
	}
//==================================[phone_number_check]=========================
	public  function phone_check(){
		$code = htmlentities($_POST['cContent'], ENT_QUOTES);
		$id = $_SESSION['id'];

		$fetchUsers_sql = "UPDATE signup SET user_email_status= 'verified' WHERE phone_activation_code='$code' AND id='$id'";
		$resultx = $this->comman_model->run_query($fetchUsers_sql);

		$fetchUsers_sql = "SELECT user_email_status FROM signup WHERE id='$id' AND phone_activation_code='$code'";
		$result = $this->comman_model->get_all_data_by_query($fetchUsers_sql);

		foreach($result as $item){
			$user_email_status = $item["user_email_status"];
			$_SESSION['user_email_status'] = $user_email_status;
		}
		if($user_email_status == "verified"){
			echo"yes";
		}
	}
//========================================[email_verification]==========================
	public function Email_verification(){

		if($_SESSION['user_email_status'] == "verified"){
			header("location:".base_url()."Dashboard");
		}

		$email_var = filter_var(htmlentities($_POST['edit_email']),FILTER_SANITIZE_STRING);
		$data["email_var"]=$email_var;
		if (isset($_POST['general_save_changes'])) {

			if (empty($email_var)) {
				$data["general_save_result"] = "<p id='error_msg'>".lang('please_fill_required_fields')."</p>";
				return false;
			}

			if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
				$data["general_save_result"] = "<p id='error_msg'>".lang('invalid_email_address')."</p>";
				return false;
			}

			$session_un = $_SESSION['Username'];
			$emExist = "SELECT Email FROM signup WHERE Email ='$email_var'";
			$FetchedData = $this->comman_model->get_all_data_by_query($emExist);
			$emExistCount = count($FetchedData);
			if ($emExistCount > 0) {
				if ($email_var != $_SESSION['Email']) {
					$data["general_save_result"] = "<p id='error_msg'>".lang('email_already_exist')."</p>";
					return false;
				}
			}


			$update_info_sql = "UPDATE signup SET Email= '$email_var' WHERE username= '$session_un'";
			$update_info = $this->comman_model->run_query($update_info_sql);

			if (isset($update_info)) {
				$_SESSION['Email'] = $email_var;
				$user_activation_code = $_SESSION['user_activation_code'];
				$terms_mail = "يتم ارسال هده الرساله لانك سجلت في نظام الصرايتم ارسال هذه الرسالة من قبل تطبيق الصرّاف فقط لتأكيد البريد الإلكتروني ، ولا يتم طلب أي معلومات شخصية أو مالية أو بيانات الحساب بأي شكل من الأشكال ، ويتم مخاطبة المستخدم بإسم المستخدم الذي إختاره عند التسجيل فقط ، ولا يتحمل فريق الصرّاف أي مسئولية عن عدم الإنتباه لأي محاولة تلاعب بالبيانات أو احتيال قد تتم بتمثيل دور الصرّاف وإرسال رسالة إلى بريدك الإلكتروني، فرجاء الإنتباه والتأكد من إسم المستخدم الذي اخترت أنه هو المخاطب به في الرسالة";
				$mail_body = email_body($signup_username,base_url().'Account/email_check?activation_code='.$user_activation_code,'شكرا لتسجيلك في نظام الصرّاف. للإتمام عملية فتح الحساب رجاء الضغط على الرابط التالي، أو نسخه للمتصفح ليتم تفعيل حسابك بنجاح.',$terms_mail);

				//SendSms($signup_fullname,'رقم التأكيد:'.$phone_activation_code);

				$result = SendEmail('Email Verification',$signup_email,$mail_body);

				echo "<p class='success_msg'>".lang('changes_email_seccessfully')."</p>";
			} else {
				echo "<p id='error_msg'>".lang('errorSomthingWrong')."</p>";
			}

		}
		error_reporting(0);

		$email_var = filter_var(htmlentities($_POST['edit_email']),FILTER_SANITIZE_STRING);
		$phone_var = filter_var(htmlentities($_POST['edit_phone']),FILTER_SANITIZE_STRING);

		if(isset($_POST['resend'])){
			$id = $_SESSION['id'];

			if (empty($email_var) || empty($phone_var)) {
				echo "<p id='error_msg'>".lang('please_fill_required_fields')."</p>";
				return false;
			}

			if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
				echo "<p id='error_msg'>".lang('invalid_email_address')."</p>";
				return false;
			}

			$session_un = $_SESSION['Username'];
			$emExist = "SELECT Email FROM signup WHERE Email ='$email_var' AND id!='$id'";
			$FetchedData = $this->comman_model->get_all_data_by_query($emExist);

			$emExistCount = count($FetchedData); //$emExist->rowCount();
			if ($emExistCount > 0) {
				if ($email_var != $_SESSION['Email']) {
					echo "<p id='error_msg'>".lang('email_already_exist')."</p>";
					return false;
				}
			}


			$phExist = "SELECT phone FROM signup WHERE phone ='$phone_var' AND id!='$id'";
			$FetchedData = $this->comman_model->get_all_data_by_query($phExist);

			$phExistCount = count($FetchedData); //$emExist->rowCount();
			if ($phExistCount > 0) {
				if ($phone_var != $_SESSION['phone']) {
					echo "<p id='error_msg'>".lang('invalid_phone_number')."</p>";
					return false;
				}
			}

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

			}


		}

		$fetchUsers_sql = "SELECT user_email_status FROM signup WHERE id='$id'";
		$result = $this->comman_model->get_all_data_by_query($fetchUsers_sql);
		$array=array();
		foreach($result as $item){
			$user_email_status = $item["user_email_status"];
			$_SESSION['user_email_status'] = $user_email_status;
		}


		$this->load->view('Account/Email_verification', $data);
	}
//==================================[email_check]=========================
	public  function email_check(){

		$activation_code_url = $_GET['activation_code'];
		if(isset($_GET['activation_code'])) {

			$activationCode=$_GET['activation_code'];
			$query = " SELECT * FROM signup WHERE user_activation_code = '$activationCode' ";
			$FetchData=$this->comman_model->get_all_data_by_query($query);
			$no_of_row =count($FetchData);
			if($no_of_row > 0){

				$result = $FetchData;
				foreach($result as $row)
				{
					if($row['user_email_status'] == 'not verified'){
						$update_query = "
	UPDATE signup SET user_email_status = 'verified' WHERE user_activation_code = '$activation_code_url'";
						$statement=$this->comman_model->run_query($update_query);
						if(isset($statement)){
							$url=base_url()."Dashboard";
							header("location: $url");
							$_SESSION['user_email_status'] = "verified";
						}
					}else{
						$url=base_url()."Dashboard";
						header("location: $url");
						$_SESSION['user_email_status'] = "verified";

					}
				}

			}else{
				echo '<label class="text-danger">Invalid Link</label>';
			}

		}
	}
}
