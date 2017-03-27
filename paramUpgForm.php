<?php
include('lock.php');
$groupID = $_SESSION['s_loginGroupid'];
if (isset($groupID)) {
	if ($groupID==0) {
		$form = "
		<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
		<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">
		<form action=\"paramUpgResult.php\" method=\"post\">
		<table>
		<tr>
		<td >Upgrade to Latest Version.</td>
		</tr>
		<tr>
		<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"paramUpgForm\"></td>
		</tr>
		<tr>
		<td><input type=\"submit\" value=\"  Upgrade  \"></td>
		</tr>
		</table>
		</form>
		";
		echo $form; 
	}
}
?>



