<?php
include('lock.php');
$groupID = $_SESSION['s_loginGroupid'];
if (isset($groupID)) {
	if ($groupID==0) {
		$form = "
		<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
		<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">
		<form action=\"userListResult.php\" method=\"post\">
		<table>
		<tr>
		<td >Username(%)</td>
		<td >:</td>
		<td ><input name=\"username\" type=\"text\" id=\"username\"></td>
		</tr>
		<tr>
		<td ></td>
		<td ></td>
		<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"userListForm\" /></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type=\"submit\" value=\"  Search  \"></td>
		</tr>
		</table>
		</form>
		";
		echo $form; 
	}
}
?>



