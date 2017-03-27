<?php
// open DB connection and select the astlogger DB 
include('config.php');
include_once('utility.php');
session_start();
// get the session variable s_loginUsername
$userCheck=$_SESSION['s_loginUsername'];
// use the session variable to form sql statement 
$sessionSQL=mysql_query("select id_username from t_astuser where id_username='$userCheck'");
$row=mysql_fetch_array($sessionSQL);
$loginSession=$row['id_username'];
// if no such user, redirect to login.php 
if(!isset($loginSession)) {
	$urlPage = curPageNameWithParameters(); 
	$_SESSION['s_loginDestination'] = $urlPage; 
	header("Location: login.php");
}
?>
