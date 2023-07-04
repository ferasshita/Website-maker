<?php

//=======================[redirect to login]===============================
function Checkloginhome($baseurl){
    session_start();

if(!isset($_SESSION['id']) || !isset($_COOKIE['id'])){
if($_COOKIE['id'] == NULL){
    header("location: $baseurl");
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
  header("location: $baseurl");
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
