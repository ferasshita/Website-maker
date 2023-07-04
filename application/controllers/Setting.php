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
			array('langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone')
	);

          $this->load->model('Comman_model');
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


	if($_SESSION['EditProfile_save_result']!=null){
	  $data["EditProfile_save_result"]=$_SESSION['EditProfile_save_result'];
	  $_SESSION['EditProfile_save_result']=null;
	}

	$this->load->view('setting/profile',$data);

}

public function general(){
	///check login
	Checklogin(base_url());
	CheckMailVerification();
	$data["dircheckPath"]= base_url()."Asset/";
	$mode=LoadMode();
	$data["tc"] = 'general';
	$data["layoutmode"]  =   $mode;
	$s_id = $_SESSION['id'];
	$s_username = $_SESSION['username'];

	if($_SESSION['general_save_result']!=null){
	$data["general_save_result"]=$_SESSION['general_save_result'];
	$_SESSION['general_save_result']=null;
	}

	$this->load->view('setting/general',$data);

}

public function Saveprofile(){
LoadLang();
	$name_var = filter_var(htmlentities($_POST['name']),FILTER_SANITIZE_STRING);

	$EditProfile_current_pass_var = filter_var(htmlentities($_POST['EditProfile_current_pass']),FILTER_SANITIZE_STRING);
	// =============================[ Save Edit profile settings ]==============================
	if (isset($_POST['EditProfile_save_changes'])) {
	if (!password_verify($EditProfile_current_pass_var,$_SESSION['Password'])) {
	$EditProfile_save_result = "<p id='error_msg'>".lang('current_password_is_incorrect')."</p>";

	}else{
 settings('main_currency','boss',$main_currency);

	$EditProfile_save_result = "<p class='success_msg'>".lang('changes_saved_seccessfully')."</p>";


	}

	$_SESSION['EditProfile_save_result']= $EditProfile_save_result;
	}

	$url=base_url()."Setting/";
	header("location: $url ");
	exit;
}
public function Savegeneral(){
 LoadLang();
 $fullname_var = filter_var(htmlentities($_POST['edit_fullname']),FILTER_SANITIZE_STRING);
 $username_var = filter_var(htmlentities($_POST['edit_username']),FILTER_SANITIZE_STRING);
 $email_var = filter_var(htmlentities($_POST['edit_email']),FILTER_SANITIZE_STRING);

 // =========================== password hashinng ==================================
 $new_password_var_field = filter_var(htmlentities($_POST['new_pass']),FILTER_SANITIZE_STRING);
 $options = array(
 'cost' => 12,
 );
 $new_password_var = password_hash($new_password_var_field, PASSWORD_BCRYPT, $options);
 // ================================================================================
 $rewrite_new_password_var = filter_var(htmlentities($_POST['rewrite_new_pass']),FILTER_SANITIZE_STRING);

 // filter gender as prefered language


 $general_current_pass_var = filter_var(htmlentities($_POST['general_current_pass']),FILTER_SANITIZE_STRING);
 // =============================[ Save Edit profile settings ]==============================

 if (isset($_POST['general_save_changes'])) {
 if (!password_verify($general_current_pass_var,$_SESSION['Password'])) {
 $general_save_result = "<p id='error_msg'>".lang('current_password_is_incorrect')."</p>";
 }else{
 if (empty($fullname_var) or empty($username_var) or empty($email_var)) {
 $general_save_result = "<p id='error_msg'>".lang('please_fill_required_fields')."</p>";
 } else {
 if (empty($new_password_var_field) AND empty($rewrite_new_password_var)) {
 $new_password_var = $_SESSION['Password'];
 }elseif ($new_password_var_field != $rewrite_new_password_var) {
 $general_save_result = "<p id='error_msg'>".lang('new_password_doesnt_match_the_confirm_field')."</p>";
 $stop = "1";
 }
 if(strpos($username_var, ' ') !== false || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $username_var) || !preg_match('/[A-Za-z0-9]+/', $username_var)) {
 $general_save_result =  "
 <ul id='error_msg' style='list-style:none;'>
 <li><b>".lang('username_not_allowed')." :</b></li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_1').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_2').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_3').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_4').".</li>
 <li><span class='fa fa-times'></span> ".lang('signup_username_should_be_5').".</li>
 </ul>";
 $stop = "1";
 }
 $unExist = "SELECT username FROM signup WHERE username = '$username_var' ";
 $udata=$this->Comman_model->get_all_data_by_query($unExist);

 $unExistCount = count($udata);
 if ($unExistCount > 0) {
 if ($username_var != $_SESSION['username']) {
 $general_save_result = "<p id='error_msg'>".lang('user_already_exist')."</p>";
 $stop = "1";
 }
 }

 $unExist = "SELECT email FROM signup WHERE email = '$email_var' ";
 $udata=$this->Comman_model->get_all_data_by_query($unExist);

 $emExistCount = count($udata);
 if ($emExistCount > 0) {
 if ($email_var != $_SESSION['email']) {
 $general_save_result = "<p id='error_msg'>".lang('email_already_exist')."</p>";
 $stop = "1";
 }
 }
 if (!filter_var($email_var, FILTER_VALIDATE_EMAIL)) {
 $general_save_result = "<p id='error_msg'>".lang('invalid_email_address')."</p>";
 $stop = "1";
 }
 if ($stop != "1") {

 $data = array(
 'phone'   => $fullname_var,
 'username'   => $username_var,
 'email'   => $email_var,
 );
 if($new_password_var_field != ""){
 $data = array(
 'Password'   => $new_password_var,
 );

 }
 $session_un = $_SESSION['username'];
 $where=array('username' => $session_un);
 $update_info=$this->Comman_model->update_entry("signup",$data,$where);

 if (isset($update_info)) {
 $_SESSION['phone'] = $fullname_var;
 $_SESSION['username'] = $username_var;
 $_SESSION['email'] = $email_var;
 $_SESSION['Password'] = $new_password_var;
 $general_save_result = "<p class='success_msg'>".lang('changes_saved_seccessfully')."</p>";
 } else {
 $general_save_result = "<p id='error_msg'>".lang('errorSomthingWrong')."</p>";
 }
 }
 }
 }

 $_SESSION['general_save_result']= $general_save_result;

 }
 $url=base_url()."Setting/general";
 header("location: $url ");
 exit;

}

public function language(){
	///check login
	Checklogin(base_url());
	CheckMailVerification();
	$data["dircheckPath"]= base_url()."Asset/";
	$mode=LoadMode();
	$data["tc"] = 'language';
	$data["layoutmode"]  =   $mode;
	$s_id = $_SESSION['id'];
	$s_username = $_SESSION['username'];

	if($_SESSION['lang_save_result']!=null){
	$data["lang_save_result"]=$_SESSION['lang_save_result'];
	$_SESSION['lang_save_result']=null;
	}

	$this->load->view('setting/language',$data);

}


public function Savelanguage(){
	LoadLang();
	$language_var = filter_var(htmlspecialchars($_POST['edit_language']),FILTER_SANITIZE_STRING);

	// =============================[ Save Edit profile settings ]==============================
	if (isset($_POST['lang_save_changes'])) {
	$data = array(
	'language'   => $language_var
	);
	$session_un = $_SESSION['username'];
	$where=array('username' => $session_un);
	$update_info=$this->Comman_model->update_entry("signup",$data,$where);

	if (isset($update_info)) {
	$_SESSION['language'] = $language_var;
	$lang_save_result = "<p class='success_msg'>".lang('changes_saved_seccessfully')."</p>";
	}else{
	$lang_save_result = "<p id='error_msg'>".lang('errorSomthingWrong')."</p>";
	}
	$_SESSION['lang_save_result']= $lang_save_result;
	}

	$url=base_url()."Setting/language";
	header("location: $url ");
	exit;
}

public function DeleteAccount(){
	///check login
	Checklogin(base_url());
	CheckMailVerification();
	$mode=LoadMode();
	$data["dircheckPath"]= base_url()."Asset/";
	$data["layoutmode"]  =   $mode;

	// =============================[ Remove account ]=================================
	$session_id = $_SESSION['id'];
	if (isset($_POST['removeA_save_changes'])) {
	$remeveA_current_pass_var = filter_var(htmlentities($_POST['removeA_current_pass']),FILTER_SANITIZE_STRING);

	if (!password_verify($remeveA_current_pass_var,$_SESSION['Password'])) {
	$data["removeA_save_result"] = "<p id='error_msg'>".lang('current_password_is_incorrect')."</p>";
	}else{
delete_ac($session_id,'delete_account');

	header("location: Account/login");
	}
	}

	$data["tc"] = 'remove_account';

	$this->load->view('setting/DeleteAccount',$data);

}

public function DeleteDatabase(){
	///check login
	Checklogin(base_url());
	CheckMailVerification();
	$mode=LoadMode();
	$data["dircheckPath"]= base_url()."Asset/";
	$data["layoutmode"]  =   $mode;
	$session_id = $_SESSION['id'];

	if (isset($_POST['removexj_save_changes'])) {
	$remevexj_current_pass_var = filter_var(htmlentities($_POST['removexj_current_pass']),FILTER_SANITIZE_STRING);
	if (!password_verify($remevexj_current_pass_var,$_SESSION['Password'])) {
	$data["removexj_save_result"] = "<p id='error_msg'>".lang('current_password_is_incorrect')."</p>";

	}else{

		delete_ac($session_id,'delete_database');

	$data["removexj_save_result"] = "<p class='success_msg'>".lang('changes_saved_seccessfully')."</p>";
	}
	}

	$data["tc"] = 'remove_accountxj';

	$this->load->view('setting/Deletedatabase',$data);

}

public function mode(){
	///check login
	Checklogin(base_url());
	CheckMailVerification();
	$mode=LoadMode();
	$data["dircheckPath"]= base_url()."Asset/";
	$data["layoutmode"]  =   $mode;
	////////////////////////////////////////////////////
	$data["tc"] = 'mode';

	if (isset($_POST['mode_save_changes']))
	{
	$session_un = $_SESSION['username'];
	$mode = filter_var(htmlentities($_POST['mode']),FILTER_SANITIZE_STRING);
	$mode_save_changes = filter_var(htmlentities($_POST['mode_save_changes']),FILTER_SANITIZE_STRING);

	$update_info_sql = "UPDATE signup SET mode= '$mode' WHERE username= '$session_un'";
	$update_info=$this->Comman_model->run_query($update_info_sql);
	if ($update_info)
	{
	$_SESSION['mode'] = $mode;

	if($mode=="night"){

	$data["layoutmode"]="dark-skin";
	}else{
	$data["layoutmode"]="light-skin";
	}
	$lang_save_resultsfs = "<p class='success_msg'>".lang('changes_saved_seccessfully')."</p>";
	} else {
	$lang_save_resultsfs = "<p id='error_msg'>".lang('errorSomthingWrong')."</p>";
	}

	$data["lang_save_resultsfs"]=$lang_save_resultsfs;
	}

	$this->load->view('setting/mode',$data);

}

}
