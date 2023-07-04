<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class project extends CI_Controller {

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
 				array('langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','excel')
 		);
    $this->load->model('account_model');
 			$this->load->model('comman_model');
 			//LoadLang();
 			// Your own constructor code


 	}
	public function pages()
	{
  	$data["dircheckPath"]= base_url()."Asset/";
  	$mode=LoadMode();
  	$data["layoutmode"]  =   $mode;

  	$this->load->view('project/pages',$data);
	}
	public function new_project()
	{
		$data["dircheckPath"]= base_url()."Asset/";
		$mode=LoadMode();
		$data["layoutmode"]  =   $mode;

		$this->load->view('project/new_project',$data);
	}
	public function new_page()
	{
		$data["dircheckPath"]= base_url()."Asset/";
		$mode=LoadMode();
		$data["layoutmode"]  =   $mode;

		$this->load->view('project/new_page',$data);
	}
	public function labraries()
	{
		$data["dircheckPath"]= base_url()."Asset/";
		$mode=LoadMode();
		$data["layoutmode"]  =   $mode;

		$this->load->view('project/labraries',$data);
	}
	public function edit()
	{
		$data["dircheckPath"]= base_url()."Asset/";
		$mode=LoadMode();
		$data["layoutmode"]  =   $mode;

		$this->load->view('project/editor',$data);
	}
	public function wpage()
	{
		$page_name = filter_var(htmlentities($_POST['page_name']),FILTER_SANITIZE_STRING);
		$title = filter_var(htmlentities($_POST['title']),FILTER_SANITIZE_STRING);
		$project_name = filter_var(htmlentities($_POST['project_name']),FILTER_SANITIZE_STRING);
		$type_r = filter_var(htmlentities($_POST['type']),FILTER_SANITIZE_STRING);
		if($title != ""){
			$titl = '
$data["title_name"]["title"] = "'.$title.'";
$data["page_name"]["name"] = "'.$page_name.'";
			';
		}else{
			$titl = '
$data["page_name"]["name"] = "'.$page_name.'";
			';
		}
		if($type_r == "new_folder"){
			//===================[make new folder in views]===================
			mkdir("../projects/$project_name/application/views/$page_name");
			//===================[make new file in controllers]===================
			$type = $page_name;
			$control = str_repeat('
<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class '.$type.' extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(
		array("langs", "IsLogedin","timefunction","Mode","countrynames", "functions_zone","app_info")
		);
		$this->load->model("account_model");
		$this->load->model("comman_model");
		LoadLang();
	}
	public function '.$page_name.'()
	{
		$data["dircheckPath"]= base_url()."Asset/";
		$mode=LoadMode();
		$data["layoutmode"]  =   $mode;
		'.$titl.'
		$this->load->view("'.$type.'/'.$page_name.'",$data);
	}
/*next_line*/
}', 1);
			$file_read = fopen("../projects/$project_name/application/controllers/$type.php","w+");
			fwrite($file_read,$control);
			fclose($file_read);
		}

		//===================[make new file in views]===================
		$file_read = fopen("../projects/$project_name/application/views/$type/$page_name.php","w+");
		$view = str_repeat('
<!DOCTYPE html>
<html class="<?php $this->load->view("includes/mode"); ?>" translate="no" lang="en">
	<head>
		<?php $this->load->view("includes/head_info", $data); ?>
	</head>
	<body class="<?php $this->load->view("includes/mode.php"); ?> theme-primary sidebar-collapse fixed">
	<div class="wrapper animate-bottom">
		<div id="loader"></div>
	</div>
	<!-- ./wrapper -->

<!-- endJS --><?php $this->load->view("includes/endJScodes", $data); ?><!-- /endJS -->
	</body>
</html>', 1);
		fwrite($file_read,$view);
		fclose($file_read);
		//===================[edit file in controllers]===================
		if($type_r != "new_folder") {
			global $control_x;
			$control_x = str_repeat('
		public function '.$page_name.'()
		{
			$data["dircheckPath"]= base_url()."Asset/";
			$mode=LoadMode();
			$data["layoutmode"]  =   $mode;
			ini_set("error_log", dirname(__file__) . "/error_log.txt");
			LoadLang();
			'.$titl.'
			$this->load->view("'.$type.'/'.$page_name.'",$data);
		}
/*next_line*/
 ',1);

			file_put_contents("../projects/$project_name/application/controllers/$type.php", implode('', array_map(function ($data) {
				global $control_x;
				return stristr($data, '/*next_line*/') ? $control_x : $data;
			}, file("../projects/$project_name/application/controllers/$type.php"))));
		}
	}
  public function wproject()
	{
	$num_random = rand(0, 99);
  $name = filter_var(htmlentities($_POST['project']),FILTER_SANITIZE_STRING);
  $author = filter_var(htmlentities($_POST['author']),FILTER_SANITIZE_STRING);
  $description = filter_var(htmlentities($_POST['description']),FILTER_SANITIZE_STRING);
  $host = filter_var(htmlentities($_POST['host']),FILTER_SANITIZE_STRING);
  $username = filter_var(htmlentities($_POST['username']),FILTER_SANITIZE_STRING);
  $password = filter_var(htmlentities($_POST['password']),FILTER_SANITIZE_STRING);
  $database = filter_var(htmlentities($_POST['database']),FILTER_SANITIZE_STRING);

  if($username == NULL){$username = "root";}
  if($host == NULL){$host = "localhost";}
  if($password == NULL){$password = "";}
  $new_dir = '..\projects\\';
$project_link = "http://localhost/projects/".$name."_".$num_random."/";
mkdir("../projects/".$name."_".$num_random);

shell_exec("xcopy Asset\upload\project ".$new_dir.$name."_".$num_random." /E/H/C/I");

//==================[config]===================
	  $file_data = "<?php \$link = '$project_link'; ?>\n";
	  $file_data .= file_get_contents("../projects/".$name."_".$num_random."/application/config/config.php");
	 file_put_contents("../projects/".$name."_".$num_random."/application/config/config.php", $file_data);
//==================[app_info]===================
	  $file_data = "<?php \n function project_name(){\n return '$name';\n }\nfunction descrition(){\n return '$description';\n }\nfunction author(){\n return '$author';\n }\n ?> \n";
	  $file_data .= file_get_contents("../projects/".$name."_".$num_random."/application/helpers/app_info_helper.php");
	  file_put_contents("../projects/".$name."_".$num_random."/application/helpers/app_info_helper.php", $file_data);
//==================[database]===================
	  $file_data = "<?php \$host = '$host';\n \$username = '$username';\n \$password = '$password';\n \$database = '$database';\n ?>\n";
	  $file_data .= file_get_contents("../projects/".$name."_".$num_random."/application/config/database.php");
	  file_put_contents("../projects/".$name."_".$num_random."/application/config/database.php", $file_data);

	  //file_upload("../projects/".$name."_".$num_random."/Asset/imgs",'logoz','ico','');
  }
  public function delete_transaction()
	{
    $dir = htmlentities($_POST['table'], ENT_QUOTES);
		shell_exec("rmdir $dir /S/Q");
			echo "done";

	}
}
