<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
			// $this->load->helper("Islogedin","Paymust");

			$this->load->helper(
				array('langs', 'Islogedin', 'functions_zone','numkmcount','app_info')
		);

			$this->load->model('comman_model');
			LoadLang();
			//LoadLang();
			// Your own constructor code
	}
	public function about()
	{
		loginRedirect(base_url()."Account/login");
		ini_set('error_log', dirname(__file__) . '/error_log.txt');

		$data['page_name']['name'] = "about";
		LoadLang();
		$user_id = $_SESSION['id'];

		$this->load->view('home/about', $data);
	}
	public function contact()
	{
		loginRedirect(base_url()."Account/login");
		ini_set('error_log', dirname(__file__) . '/error_log.txt');

		$data['page_name']['name'] = "contact";
		LoadLang();
		$user_id = $_SESSION['id'];

		$this->load->view('home/contact', $data);
	}
	public function home()
	{
		loginRedirect(base_url()."Account/login");
		ini_set('error_log', dirname(__file__) . '/error_log.txt');

		$data['page_name']['name'] = "Projects";
		LoadLang();
		$user_id = $_SESSION['id'];

		$this->load->view('home/home', $data);
	}
	public function index()
	{
		loginRedirect(base_url()."Account/login");
		ini_set('error_log', dirname(__file__) . '/error_log.txt');

		$data['page_name']['name'] = "Projects";
		LoadLang();
		$user_id = $_SESSION['id'];

		$this->load->view('home/home', $data);
	}

}
