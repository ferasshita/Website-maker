
<?php
function project_settings($name){
	ob_start();
// if 1==1 then do the function.
	$toggle = "false";
	if($name == "signup" && $toggle=="true"){
		echo "signup";
	}
	if($name == "index" && $toggle=="true"){
		header("location: ".base_url()."Account/login");
	}
	if($name == "captcha" && $toggle=="false"){
		echo "captcha";
	}
	if($name == "email" && $toggle=="false"){
		echo "email";
	}
	if($name == "payment" && $toggle=="false"){
		echo"payment";
	}
	if($name == "delete_account" && $toggle=="true"){
		echo "delete_account";
	}
	if($name == "delete_database" && $toggle=="false"){
		echo "delete_database";
	}
	if($name == "devolpment" && $toggle=="true"){
		echo "devolpment";
	}

	return ob_get_clean();
}
?>
