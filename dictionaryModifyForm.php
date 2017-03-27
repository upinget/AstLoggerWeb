<?php
include('lock.php');
$groupID = $_SESSION['s_loginGroupid'];
if (isset($groupID)) {
	if ($groupID==0) {
		$form = "
		<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
		<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">
		<form action=\"dictionaryModifyResult.php\" method=\"post\">
		<table>
		<tr>
		<td>ID(*)</td>
		<td>:</td>
		<td><input name=\"id\" type=\"text\" id=\"id\"></td>
		</tr>
		<tr>
		<td></td>
		<td></td>
		<td><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"dictionaryModifyForm\" /></td>
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
