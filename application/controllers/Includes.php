<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class includes extends CI_Controller {

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
 				array('langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone')
 		);
 			$this->load->model('comman_model');
 			//LoadLang();
 			// Your own constructor code


 	}
	public function mode()
	{
    $id = $_SESSION['id'];
    $dhsh = date("H");

if($_SESSION['mode'] == "light" || ($_SESSION['mode'] == "auto" && $dhsh>=4&&$dhsh<=18)){
$mode = "night";
}else{
$mode = "light";
}
     $update_info_sql = "UPDATE signup SET mode= '$mode' WHERE id= '$id'";
     $update_info=$this->comman_model->run_query($update_info_sql);

         $_SESSION['mode'] = $mode;

echo"yes";
	}
}
