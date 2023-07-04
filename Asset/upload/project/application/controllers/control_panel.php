<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class control_panel extends CI_Controller {

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
	public function __construct()
	{

			parent::__construct();
			// $this->load->helper("langs");
			// $this->load->helper("IsLogedin","Paymust");
			$this->load->helper(
				array('langs', 'IsLogedin','timefunction','Mode','numkmcount','app_info','functions_zone')
		);
			$this->load->model('comman_model');
			Checkloginhome(base_url());

			LoadLang();
			//LoadLang();
			// Your own constructor code
	}



public function index(){
		///check login

		$mode=LoadMode();

        $data["dircheckPath"]= base_url()."Asset/";
        $data["layoutmode"]  =   $mode;
		////////////////////////////////////////////////////

		if($_SESSION['user_email_status'] == "not verified"){
		header("location:../email_verification");
		}
		// check if user is an admin or naot to access control_panel
		if ($_SESSION['account_type'] != 'admin') {
				header("location: ".base_url());
		}

        $sid =  $_SESSION['id'];

		$this->load->view('control_panel/index',$data);
	}


	public function user(){
		///check login

		Checklogin(base_url());

		$url=base_url()."control_panel";
		$emailverif=base_url()."email_verification";
		if($_SESSION['user_email_status'] == "not verified"){
		header("location:$emailverif");}
		if ($_SESSION['account_type'] != 'admin') {
				header("location: ".base_url());
		}

		$urlP = filter_var(htmlspecialchars($_GET['adb']),FILTER_SANITIZE_STRING);
		// get var's
		$ed = trim(filter_var(htmlspecialchars($_GET['ed']),FILTER_SANITIZE_STRING));
		$db_username = trim(filter_var(htmlentities($_POST['username']),FILTER_SANITIZE_STRING));
		$db_email = trim(filter_var(htmlentities($_POST['email']),FILTER_SANITIZE_STRING));

		// =========================== password hashinng ==================================
		$db_password_var = trim(filter_var(htmlentities($_POST['password']),FILTER_SANITIZE_STRING));
		$options = array(
			'cost' => 12,
		);
		$db_password = password_hash($db_password_var, PASSWORD_BCRYPT, $options);
		// ================================================================================
		$db_admin = trim(filter_var(htmlentities($_POST['admin']),FILTER_SANITIZE_STRING));
		switch ($db_admin) {
			case lang('yes'):
				$db_admin = "1";
				break;
			case lang('no'):
				$db_admin = "0";
				break;
		}

		if (isset($_POST['submit_uInfo'])) {
			if (empty($db_username) or empty($db_email)) {
				$data["update_result"] = "<p class='alertRed'>".lang('please_fill_required_fields')."</p>";
				$data["stop"] = "1";
			}
			if(strpos($db_username, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $db_username) || !preg_match('/[A-Za-z0-9]+/', $db_username)) {
				$data["update_result"] = "
					<ul class='alertRed' style='list-style:none;'>
						<li><b>".lang('username_not_allowed')." :</b></li>
						<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_1').".</li>
						<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_2').".</li>
						<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_3').".</li>
						<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_4').".</li>
						<li><span class='fa fa-times'></span> ".lang('signup_username_should_be_5').".</li>
					</ul>";
				$stop = "1";
			}

			$unExist = "SELECT username FROM signup WHERE username ='$db_username'";
			$FetchedData=$this->comman_model->get_all_data_by_query($unExist);
			$data["unExistCount"]=count($FetchedData);

			$emExist = "SELECT email FROM signup WHERE email ='$db_email'";
			$FetchedData=$this->comman_model->get_all_data_by_query($emExist);
			$data["emExistCount"]=count($FetchedData);

			if($emExistCount > 0){
				if ($uInfo_em != $db_email) {
				$data["update_result"] = "<p class='alertRed'>".lang('email_already_exist')."</p>";
				$data["stop"] = "1";
				$stop="1";
				}
			}

			if (!filter_var($db_email, FILTER_VALIDATE_EMAIL)) {
				$data["update_result"] = "<p class='alertRed'>".lang('invalid_email_address')."</p>";
				$data["stop"] = "1";
				$stop="1";
			}


			if ($stop != "1") {
				if (empty($db_password_var)) {
				$update = "UPDATE signup SET username = '$db_username',email = '$db_email',package = '$package',admin = '$db_admin' WHERE id = '$ed'";
				}else{
				$update = "UPDATE signup SET username = '$db_username',email = '$db_email',package = '$package',Password = '$db_password',admin = '$db_admin' WHERE id = '$ed' ";
				}
				// $update->bindParam(':db_username',$db_username,PDO::PARAM_STR);
				// $update->bindParam(':db_email',$db_email,PDO::PARAM_STR);
				// $update->bindParam(':package',$package,PDO::PARAM_INT);
				// if (!empty($db_password_var)) {
				// $update->bindParam(':db_password',$db_password,PDO::PARAM_STR);
				// }
				// $update->bindParam(':db_admin',$db_admin,PDO::PARAM_INT);
				// $update->bindParam(':ed',$ed,PDO::PARAM_STR);
				// $update->execute();
				$update=$this->comman_model->run_query($update);
				if ($update) {
					$data["update_result"] = "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
				}else{
					$data["update_result"] = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				}
			}

		}


		if (isset($_POST['active'])) {
			$uInfo = "SELECT user_email_status FROM signup WHERE id = '$ed'";
			$FetchedData=$this->comman_model->get_all_data_by_query($uInfo);
			// $uInfo->bindParam(':ed',$ed,PDO::PARAM_STR);
			// $uInfo->execute();
			$uInfo_count = count($FetchedData);// $uInfo->rowCount();
			if ($uInfo_count > 0) {
			foreach ($FetchedData as $uInfoRow)
			{
				$uInfo_sus= $uInfoRow['user_email_status'];
			}
			if($uInfo_sus == "not verified"){
			  $sus = "verified";
			}else{
			  $sus = "not verified";
			}

			$query ="UPDATE signup SET user_email_status = '$sus' WHERE id = '$ed' ";
			$update = $this->comman_model->run_query($query);
			// $update->bindParam(':db_username',$sus,PDO::PARAM_INT);
			// $update->bindParam(':ed',$ed,PDO::PARAM_STR);
			// $update->execute();
				if ($update) {
				}else{
					$data["update_result"] = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				}
			}
		}

		if (isset($_POST['delete_account'])) {
			delete_ac($ed,'delete_account');
		}

		if (isset($_POST['delete_database'])) {
			delete_ac($ed,'delete_database');
		}
if(isset($_POST['login_acc'])){
		// Displaying the decrypted string
	$login_id = $_POST['login_id'];
		setcookie("id", "", time() - (10 * 365 * 24 * 60 * 60), "/", false, true);
		session_destroy();
	$vpsql = "SELECT * FROM signup WHERE id= '$login_id'";
	$FetchedData=$this->comman_model->get_all_data_by_query($vpsql);
	foreach($FetchedData as $row_fetch){
		$fields = $this->db->field_data('signup');
		foreach ($fields as $postsfetchi)
		{
			${"var".$postsfetchi->name} = $row_fetch[$postsfetchi->name];
		}}

		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options   = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = $_SERVER['REMOTE_ADDR'];
		$encryption = openssl_encrypt($varid, $ciphering, $encryption_key, $options, $encryption_iv);

		setcookie('id', $encryption, time() + (10 * 365 * 24 * 60 * 60), "/", false, true);

		$uisql = "SELECT * FROM settings WHERE user_id= '$varid' AND access='user'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		foreach($udata as $rowx){
			$value_n = $rowx['value'];
			$type_n = $rowx['type'];
			$_SESSION[$type_n] = $value_n;
		}
		$uisql = "SELECT * FROM settings WHERE user_id= '$varshop' AND access='shop'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		foreach($udata as $rowx){
			$value_n = $rowx['value'];
			$type_n = $rowx['type'];
			$_SESSION[$type_n] = $value_n;
		}
		$uisql = "SELECT * FROM settings WHERE user_id= '$varboss' AND access='boss'";
		$udata=$this->comman_model->get_all_data_by_query($uisql);
		foreach($udata as $rowx){
			$value_n = $rowx['value'];
			$type_n = $rowx['type'];
			$_SESSION[$type_n] = $value_n;
		}
		$fields = $this->db->field_data('signup');
		foreach ($fields as $postsfetchi)
		{
			$_SESSION[$postsfetchi->name] = ${"var".$postsfetchi->name};
		}
		$url = base_url()."Dashboard";
		header("location: $url");

}

		if (isset($_POST['send_msg'])) {
			$msg = trim(filter_var(htmlspecialchars($_POST['msg']),FILTER_SANITIZE_STRING));
			$data = array(
				'message'      => $msg,
			);
			$this->comman_model->insert_entry("notifications",$data);
		}

		if(isset($_POST['pay_month'])){
			$next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 1 month"));
			$data = array(
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$data);
			if ($update) {
				$update_result = "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				$data["update_result"]=$update_result;
			}
		}

		if(isset($_POST['pay_one'])){
			$next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 1 year"));
			$data = array(
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$data);
			if ($update) {
				$update_result = "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				$data["update_result"]=$update_result;
			}
		}

		if(isset($_POST['pay_two'])){
			$next_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 2 year"));
			$data = array(
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$data);
			if ($update) {
				$update_result = "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				$data["update_result"]=$update_result;
			}
		}

		if(isset($_POST['pay_three'])){
			$nex_pay = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " + 3 year"));
			$data = array(
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$data);
			if ($update) {
				$update_result = "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				$data["update_result"]=$update_result;
			}
		}

		if (isset($_POST['pay'])) {
			$nex_pay = trim(filter_var(htmlspecialchars($_POST['nex_pay']),FILTER_SANITIZE_STRING));
			$data = array(
				'next_pay' => $next_pay,
			);
			$update=$this->comman_model->insert_entry("payment",$data);
			if ($update) {
				$update_result = "<p class='alertGreen'>".lang('changes_saved_seccessfully')."</p>";
			}else{
				$update_result = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				$data["update_result"]=$update_result;
			}
		}

		if (isset($_POST['susbend'])) {
			$uInfo = "SELECT sus FROM signup WHERE id = '$ed'";
			$FetchedData=$this->comman_model->get_all_data_by_query($uInfo);
			$uInfo_count = count($FetchedData);
			if ($uInfo_count > 0) {
			foreach ($FetchedData as $uInfoRow)
			{
				$uInfo_sus= $uInfoRow['sus'];
			}
			if($uInfo_sus == "1"){
			  $sus = "0";
			}else{
			  $sus = "1";
			}

			$query ="UPDATE signup SET sus = '$sus' WHERE id = '$ed' ";
			$update = $this->comman_model->run_query($query);
				if ($update) {
				}else{
					$data["update_result"] = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
				}
			}
		}

		$mode=LoadMode();
		$data["dircheckPath"]= base_url()."Asset/";
		$data["layoutmode"]  =   $mode;
		////////////////////////////////////////////////////


		$ed = trim(filter_var(htmlspecialchars($_GET['ed']),FILTER_SANITIZE_STRING));
		 $uInfo = "SELECT * FROM signup WHERE id =  '$ed'";
		$FetchedData=$this->comman_model->get_all_data_by_query($uInfo);
		$data["uinfo"]=$FetchedData;
		//print_r($FetchedData);exit;
		$uInfo_count=count($FetchedData);
		// $unExist = $conn->prepare("SELECT username FROM signup WHERE username =:db_username");
		// $unExist->bindParam(':db_username',$db_username,PDO::PARAM_STR);
		// $unExist->execute();
		$un_not_found="";
		//$uInfo_id=0;
		if ($uInfo_count > 0) {
			foreach($FetchedData as $uInfoRow ) {
				$uInfo_id = $uInfoRow['id'];
				$shop_id_him = $uInfoRow['shop_id'];
				$uInfo_type = $uInfoRow['type'];
				$uInfo_boss = $uInfoRow['boss_id'];
				$uInfo_un = $uInfoRow['username'];
				$online = $uInfoRow['online'];
				$pack_ad = $uInfoRow['package'];
				$uInfo_em = $uInfoRow['email'];
				$uInfo_ph = $uInfoRow['phone'];
				$uInfo_pd = $uInfoRow['Password'];
				$uInfo_ad = $uInfoRow['admin'];
				$status = $uInfoRow['sus'];

				$user_email_status = $uInfoRow['user_email_status'];

			}
		}else{
				$un_not_found = "user not found";
		}
			// remove a user from all tables (forever from database)

		// remove a user from all tables (forever from database)
		if (isset($_POST['rAccBtn'])) {

			delete_ac($session_id,'delete_account');


			if ($remeveAccount)
			{
				//echo "Test";exit;
				echo $url=base_url()."control_panel/panel";
				header("location: $url");
				exit;
			}
			else
			{
				//echo "Test2";exit;
				$data["update_result"] = "<p class='alertRed'>".lang('errorSomthingWrong')."</p>";
			}
		}
		if ($un_not_found != "user not found")
		{
			$admin_int = "1";
			$chAdmin = "SELECT username FROM signup WHERE id = '$ed' AND account_type = 'admin' ";
			$FetchedData=$this->comman_model->get_all_data_by_query($chAdmin);
			$data["chAdminCount"]=count($FetchedData);
		}

		$this->load->view('control_panel/user',$data);
	}

}
