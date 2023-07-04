<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
			$this->load->helper(
				array('langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info')
		);
			$this->load->model('comman_model');
			Checkloginhome(base_url());

	if(isset($_COOKIE['id']) && !isset($_SESSION['username'])){
//===========================[cookie function]===============================
	$encryption = $_COOKIE['id'];
	$options   = 0;
	$decryption_iv = '1234567891011121';
	$ciphering = "AES-128-CTR";
	$decryption_key = $_SERVER['REMOTE_ADDR'];
	$decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

//========================[fetch data]==============================
$req = "still";
	$vpsql = "SELECT * FROM signup WHERE id= '$decryption'";
	$FetchedData=$this->comman_model->get_all_data_by_query($vpsql);
	foreach($FetchedData as $row_fetch){
		$fields = $this->db->field_data('signup');
	  foreach ($fields as $postsfetchi)
	  {
		  ${"var".$postsfetchi->name} = $row_fetch[$postsfetchi->name];
	}
	}
//=========================[settings]=======================================
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
//========================[create sessions]=================================
$fields = $this->db->field_data('signup');
foreach ($fields as $postsfetchi)
{
	$_SESSION[$postsfetchi->name] = ${"var".$postsfetchi->name};
}
	}

			LoadLang();
			//LoadLang();
			// Your own constructor code
	}
	public function index()
	{
		 if($_SESSION['user_email_status'] == "not verified"){
			header("location:".base_url()."Account/email_verification");}

		ini_set('error_log', dirname(__file__) . '/error_log.txt');

		$data['page_name']['name'] = "home";
		LoadLang();
		$user_id = $_SESSION['id'];
		$this->load->view('dashboard/home',$data);
	}

}
