<?php
include('config.php');
include_once('auditTrial.php');
session_start();
// destroy the session
$myUsername = $_SESSION['s_loginUsername'];
if (strlen($myUsername)) {
	$auditTrial = "logout successfully.";
	insertAuditTrial($auditTrial);
}
if(session_destroy()) {
	// redirect to login.php page 
	header("Location: login.php");
}
?>
