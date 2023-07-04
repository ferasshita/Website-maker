<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

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
			array('langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info')
	);

          $this->load->model('comman_model');
		LoadLang();

		// Your own constructor code
}

public function index(){
	///check login
	Checklogin(base_url());
	CheckMailVerification();
	$data["dircheckPath"]= base_url()."Asset/";
	$mode=LoadMode();
	$data["tc"] = 'edit_profile';
	$data["layoutmode"]  =   $mode;
	$s_id = $_SESSION['id'];
	$s_username = $_SESSION['username'];

	$data['pid'] = $_GET['pid'];
	if($_GET['pid'] == NULL){
		$data['page_name']['name'] = "Settings";
	}else{
		$data['page_name']['name'] = $_GET['pid'];
	}


	$this->load->view('setting/index',$data);

}
public function Savebugs()
{
	$sid=$_SESSION['id'];
	$title = filter_var(htmlentities($_POST['title']), FILTER_SANITIZE_STRING);
	$description = filter_var(htmlentities($_POST['description']), FILTER_SANITIZE_STRING);
	$data = array(
		'user_id'   => $sid,
		'title'      => $title,
		'description'	=>	$description
	);
	$this->comman_model->insert_entry("bugs",$data);
	echo"<span class='success_msg'>".lang('changes_saved_seccessfully')."</span>";
}
public function Saveprofile(){
	LoadLang();
	$sid=$_SESSION['id'];
	$name_var = filter_var(htmlentities($_POST['name']),FILTER_SANITIZE_STRING);
	$address_var = filter_var(htmlentities($_POST['address']),FILTER_SANITIZE_STRING);
	$phone_no = filter_var(htmlentities($_POST['phone_no']),FILTER_SANITIZE_STRING);
	$shop = filter_var(htmlentities($_POST['shop']),FILTER_SANITIZE_STRING);
	$email_ad = filter_var(htmlentities($_POST['email_ad']),FILTER_SANITIZE_STRING);
	$main_currency = filter_var(htmlentities($_POST['main_currency']),FILTER_SANITIZE_STRING);
	$website = filter_var(htmlentities($_POST['website']),FILTER_SANITIZE_STRING);
	$titl = filter_var(htmlentities($_POST['titl']),FILTER_SANITIZE_STRING);
	$hide_trsh = filter_var(htmlentities($_POST['hide_trsh']),FILTER_SANITIZE_STRING);
	$home_transaction = filter_var(htmlentities($_POST['home_transaction']),FILTER_SANITIZE_STRING);
	$currency_changes = filter_var(htmlentities($_POST['currency_pass']),FILTER_SANITIZE_STRING);

	$EditProfile_current_pass_var = filter_var(htmlentities($_POST['EditProfile_current_pass']),FILTER_SANITIZE_STRING);
	// =============================[ Save Edit profile settings ]==============================
	if (isset($_POST['EditProfile_save_changes'])) {
	if (!password_verify($EditProfile_current_pass_var,$_SESSION['Password'])) {
	$EditProfile_save_result = "<p id='error_msg'>".lang('current_password_is_incorrect')."</p>";

	}else{
		settings('main_currency','boss',$main_currency);
 settings('home_transaction','user',$home_transaction);

	$data = array(
	'shop_id'   => $shop,
	'name'   => $name_var,
	'address'   => $address_var,
	'phone_no'   => $phone_no,
	'email_ad'   => $email_ad,
	'website'   => $website,
	'title'   => $titl,
	'hide_trsh'   => $hide_trsh
	);
	$where=array('id' => $sid);
	$update_info=$this->comman_model->update_entry("signup",$data,$where);

	if ($update_info) {
	$_SESSION['name'] = $name_var;
	$_SESSION['phone_no'] = $phone_no;
	$_SESSION['email_ad'] = $email_ad;
	$_SESSION['shop_id'] = $shop;
	$_SESSION['website'] = $website;
	$_SESSION['address'] = $address_var;
	$_SESSION['title_h'] = $titl;
	$_SESSION['hide_trsh'] = $hide_trsh;
		echo"<span class='success_msg'>".lang('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".lang('errorSomthingWrong')."</span>";
	}

	}
	}
}
public function Savepassword(){
	$sid=$_SESSION['id'];
	$new_password_var_field = filter_var(htmlentities($_POST['new_pass']),FILTER_SANITIZE_STRING);
	$options = array(
		'cost' => 12,
	);
	$new_password_var = password_hash($new_password_var_field, PASSWORD_BCRYPT, $options);
	// ================================================================================
	$rewrite_new_password_var = filter_var(htmlentities($_POST['rewrite_new_pass']),FILTER_SANITIZE_STRING);
	$general_current_pass_var = filter_var(htmlentities($_POST['general_current_pass']),FILTER_SANITIZE_STRING);
	if (empty($new_password_var_field) AND empty($rewrite_new_password_var)) {
		$new_password_var = $_SESSION['Password'];
	}elseif ($new_password_var_field != $rewrite_new_password_var) {
		echo "<p class='error_msg'>".lang('new_password_doesnt_match_the_confirm_field')."</p>";
return false;
	}
		if($new_password_var_field != ""){
			$data = array(
				'Password'   => $new_password_var,
			);
		}
		$id = $_SESSION['id'];
		$where=array('id' => $id);
		$update_info=$this->comman_model->update_entry("signup",$data,$where);
$_SESSION['Password'] = $new_password_var;
		if (isset($update_info)) {
			echo"<span class='success_msg'>".lang('changes_saved_seccessfully')."</span>";
		} else {
			echo"<span class='error_msg'>".lang('errorSomthingWrong')."</span>";
		}


}

public function download(){
	$sid=$_SESSION['id'];
	$general_current_pass_var = filter_var(htmlentities($_POST['general_current_pass']),FILTER_SANITIZE_STRING);
	// =============================[ Save Edit profile settings ]==============================

	if (!password_verify($general_current_pass_var,$_SESSION['Password'])) {
		echo "<p class='error_msg'>".lang('current_password_is_incorrect')."</p>";
	}else {
//============================[download data]=================================

	}
}
public function Savegeneral(){
 LoadLang();
 $sid=$_SESSION['id'];
	$fullname_var = filter_var(htmlentities($_POST['edit_fullname']),FILTER_SANITIZE_STRING);
 $username_var = filter_var(htmlentities($_POST['edit_username']),FILTER_SANITIZE_STRING);
 $email_var = filter_var(htmlentities($_POST['edit_email']),FILTER_SANITIZE_STRING);
 // =========================== password hashinng ==================================

 $general_current_pass_var = filter_var(htmlentities($_POST['general_current_pass']),FILTER_SANITIZE_STRING);
 // =============================[ Save Edit profile settings ]==============================

 if (!password_verify($general_current_pass_var,$_SESSION['Password'])) {
echo "<p class='error_msg'>".lang('current_password_is_incorrect')."</p>";
 }else{
 if (empty($fullname_var) or empty($username_var) or empty($email_var)) {
echo "<p class='error_msg'>".lang('please_fill_required_fields')."</p>";
 } else {

 if(strpos($username_var, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $username_var) || !preg_match('/[A-Za-z0-9]+/', $username_var)) {
echo  "
 <ul class='error_msg' style='list-style:none;'>
 <li><b>".lang('username_not_allowed')." :</b></li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_1').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_2').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_3').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_4').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_5').".</li>
 </ul>";
return false;
 }
 $unExist = "SELECT Username FROM signup WHERE Username = '$username_var' ";
 $udata=$this->comman_model->get_all_data_by_query($unExist);
 $unExistCount = count($udata);
 if ($unExistCount > 0) {
 if ($username_var != $_SESSION['username']) {
echo"<p class='error_msg'>".lang('user_already_exist')."</p>";
	 return false;
 }
 }

 $unExist = "SELECT email FROM signup WHERE email = '$email_var' ";
 $udata=$this->comman_model->get_all_data_by_query($unExist);

 $emExistCount = count($udata);
 if ($emExistCount > 0) {
 if ($email_var != $_SESSION['email']) {
echo "<p class='error_msg'>".lang('email_already_exist')."</p>";
	 return false;
 }
 }
 if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
echo "<p class='error_msg'>".lang('invalid_email_address')."</p>";
	 return false;
 }
 $data = array(
 'phone'   => $fullname_var,
 'username'   => $username_var,
 'email'   => $email_var,
 );
 $session_un = $_SESSION['username'];
 $where=array('id' => $sid);
 $update_info=$this->comman_model->update_entry("signup",$data,$where);

 if (isset($update_info)) {
 $_SESSION['phone'] = $fullname_var;
 $_SESSION['username'] = $username_var;
 $_SESSION['email'] = $email_var;
	 echo"<span class='success_msg'>".lang('changes_saved_seccessfully')."</span>";
 } else {
	 echo"<span class='error_msg'>".lang('errorSomthingWrong')."</span>";
 }
 }
 }
}

public function Savelanguage(){
	LoadLang();
	$sid=$_SESSION['id'];
	$language_var = filter_var(htmlspecialchars($_POST['edit_language']),FILTER_SANITIZE_STRING);

	// =============================[ Save Edit profile settings ]==============================
	$data = array(
	'language'   => $language_var
	);
	$where=array('id' => $sid);
	$update_info=$this->comman_model->update_entry("signup",$data,$where);

	if (isset($update_info)) {
		$_SESSION['language'] = $language_var;
		echo"<span class='success_msg'>".lang('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".lang('errorSomthingWrong')."</span>";
	}
}

public function DeleteDatabase(){
	$sid = $_SESSION['sid'];
	if (isset($_POST['removexj_save_changes'])) {
	$remevexj_current_pass_var = filter_var(htmlentities($_POST['removexj_current_pass']),FILTER_SANITIZE_STRING);
	if (!password_verify($remevexj_current_pass_var,$_SESSION['Password'])) {
	echo "<p class='error_msg'>".lang('current_password_is_incorrect')."</p>";

	}else{
		delete_ac($sid,'delete_database');
	echo "<p class='success_msg'>".lang('changes_saved_seccessfully')."</p>";
	}
	}
}

public function DeleteAccount(){
	$sid = $_SESSION['id'];
	$remeveA_current_pass_var = filter_var(htmlentities($_POST['removeA_current_pass']),FILTER_SANITIZE_STRING);

	if (!password_verify($remeveA_current_pass_var,$_SESSION['Password'])) {
	echo"<p class='error_msg'>".lang('current_password_is_incorrect')."</p>";
	}else{
delete_ac($sid,'delete_account');

	header("location: ".base_url()."Account/login");
	}

}

public function block_ip(){
	$sid = $_SESSION['id'];
	$ip_id = "4";//filter_var(htmlentities($_POST['id']),FILTER_SANITIZE_STRING);

	$emExist = "SELECT status FROM devices WHERE user_id = '$sid' AND id='$ip_id'";
	$FetchData=$this->comman_model->get_all_data_by_query($emExist);
	foreach ($FetchData as $postsfetch ) {
		$status = $postsfetch['status'];
	}
	if($status == '1'){
		$status_val = '0';
	}else{
		$status_val = '1';
	}
	$data = array(
		'status'   => $status_val,
	);
	$where=array('id' => $ip_id);
	$update_info=$this->comman_model->update_entry("devices",$data,$where);
	echo"done";
}

public function savemode(){
	$sid = $_SESSION['id'];
	$mode = filter_var(htmlentities($_POST['mode']),FILTER_SANITIZE_STRING);
	$mode_save_changes = filter_var(htmlentities($_POST['mode_save_changes']),FILTER_SANITIZE_STRING);

	$update_info_sql = "UPDATE signup SET mode= '$mode' WHERE username= '$sid'";
	$update_info=$this->comman_model->run_query($update_info_sql);
	if ($update_info)
	{
	$_SESSION['mode'] = $mode;

	if($mode=="night"){

	$data["layoutmode"]="dark-skin";
	}else{
	$data["layoutmode"]="light-skin";
	}
		echo"<span class='success_msg'>".lang('changes_saved_seccessfully')."</span>";
	} else {
		echo"<span class='error_msg'>".lang('errorSomthingWrong')."</span>";
	}

}
}
