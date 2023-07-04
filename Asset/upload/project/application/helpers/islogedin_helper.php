<?php

//=======================[redirect to login]===============================
function Checkloginhome($baseurl){
    session_start();
if (project_settings("payment") != "payment") {
	$CI = get_instance();

	// You may need to load the model if it hasn't been pre-loaded
	$CI->load->model('comman_model');


	if ($_SESSION['admin'] != '1') {
	if ($_SESSION['admin'] != '2') {
	//include "config/connect.php";
	$sid =  $_SESSION['id'];

	//$uInfo = $conn->prepare("SELECT sus,nex_pay FROM signup WHERE id = :ed");
	$uInfo = "SELECT next_pay FROM payment WHERE id = $sid";
	$resultCount=$CI->comman_model->get_all_dataCounts_by_query($uInfo);
	$result=$CI->comman_model->get_all_data_by_query($uInfo);
	$uInfo_count = $resultCount;
	foreach($result as $uInfoRow ) {
	$nex_pay = $uInfoRow['nex_pay'];
	$status = $uInfoRow['sus'];
	}
	$date_now = new DateTime();
	$date2 = new DateTime($nex_pay);

	if($status == "0"){
	if($_SESSION['package'] != "0" && $date2 <= $date_now){
	loginRedirect(base_url()."Home/pay");
	}
	}else{

	loginRedirect(base_url()."Home/pay");
	}
	}
	}
	}

	if(!isset($_SESSION['id']) || !isset($_COOKIE['id'])){
if($_COOKIE['id'] == NULL){
    header("location: ".$baseurl."Account/login");
    exit;
}
}}

function Checklogin($baseurl){
    session_start();

if(!isset($_SESSION['id'])){
    header("location: ".$baseurl."dashboard");
    exit;
}}
//=========================[redirect to home]======================================
function loginRedirect($baseurl){
session_start();

if(isset($_SESSION['id']) || isset($_COOKIE['id'])){
if($_COOKIE['id'] != NULL){
  header("location: ".$baseurl);
  exit;
}
}
}

function logoutredirect($baseurl){
  header("location: ".$baseurl."Account/logout");
exit;
}
//=======================[check email verification]============================
function CheckMailVerification(){
    session_start();
     if($_SESSION['user_email_status'] == "not verified"){
        header("location:email_verification");
        exit;
     }
}


?>
