<?php
include('lock.php');
include_once('auditTrial.php');
include_once('dictionary.php');
$groupID = $_SESSION['s_loginGroupid'];
if (isset($groupID)) {
	if ($groupID==0) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			// id and name sent from Form 
			$id=addslashes($_POST['id']); 
			$name=addslashes($_POST['name']);
			if (insertDictionary($id, $name)) {
				$_SESSION['s_systemMessage'] = "Add dictionary $id $name successfully.";
				// audit trial
				$auditTrial = "add dictionary $id $name successfully.";		
				insertAuditTrial($auditTrial);
			} else {
				$_SESSION['s_systemMessage'] = "Add dictionary $id $name failed.";
				// audit trial
				$auditTrial = "add dictionary $id $name failed.";		
				insertAuditTrial($auditTrial);
			}					
			header("location: welcome.php?action=dictionaryadd");	
		} else {
			$form = "
			<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
			<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">
			<form class=\"dictionaryAddForm\" id=\"dictionaryAddForm\"  action=\"dictionaryAdd.php\" method=\"post\">
			<table>
			<tr>
			<td>ID(*)</td>
			<td>:</td>
			<td><input name=\"id\" type=\"text\" id=\"id\"></td>
			</tr>
			<tr>
			<td>Name(*)</td>
			<td>:</td>
			<td><input name=\"name\" type=\"text\" id=\"name\"></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type=\"submit\" value=\"  Submit  \"></td>
			</tr>
			</table>
			</form>
			";
			echo $form; 
		}
	}
}
?>
