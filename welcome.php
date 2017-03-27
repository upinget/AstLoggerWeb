<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
<?php 
include('layoutjscss.php');
?>
</head>
<body>
<div class="ui-layout-north">
<?php
include('header.php'); 
?>
</div>
<div class="ui-layout-west">
<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
	$funcPage = addslashes($_GET['action']);
	if ($funcPage=="callsearch") {
		include('callSearchForm.php');		
	} else if ($funcPage=="chgpasswd") {
		include('passwdChg.php'); 
	} else if ($funcPage=="useradd") {
		include('userAdd.php');		
	} else if ($funcPage=="usermodify") {
		include('userModifyForm.php');		
	} else if ($funcPage=="userdelete") {
		include('userDeleteForm.php');
	} else if ($funcPage=="userlist") {
		include('userListForm.php');			
	} else if ($funcPage=="resetpasswd") {
		include('passwdResetForm.php');	
	} else if ($funcPage=="paramList") {
		include('paramListForm.php');		
	} else if ($funcPage=="paramModify") {
		include('paramModifyForm.php');		
	} else if ($funcPage=="paramUpgrade") {
		include('paramUpgForm.php');		
	} else if ($funcPage=="auditTrial") {
		include('auditTrialForm.php');	
	} else if ($funcPage=="loggerList") {
		include('loggerListForm.php');
	} else if ($funcPage=="loggerAdd") {
		include('loggerAdd.php');
	} else if ($funcPage=="loggerDelete") {
		include('loggerDeleteForm.php');
	} else if ($funcPage=="loggerModify") {
		include('loggerModifyForm.php');
	} else if ($funcPage=="loggerStatus") {
		include('loggerStatusListForm.php');
	} else if ($funcPage=="chgrecpage") {
		include('optChgRecPage.php');
	} else if ($funcPage=="dictionaryadd") {
		include('dictionaryAdd.php');
	} else if ($funcPage=="dictionarymodify") {
		include('dictionaryModifyForm.php');
	} else if ($funcPage=="dictionarydelete") {
		include('dictionaryDeleteForm.php');
	} else if ($funcPage=="dictionarylist") {
		include('dictionaryListForm.php');	
	} else { // default page on the north pane
		include('callSearchForm.php');
	}
} else { // default is query php 
	include('callSearchForm.php');
}
?>    
</div>
<div class="ui-layout-center">
<?php
if(isset($_SESSION['s_systemMessage'])) {
	echo $_SESSION['s_systemMessage'];
	unset($_SESSION['s_systemMessage']);
} 
?>
</div>
</body>
</html>

