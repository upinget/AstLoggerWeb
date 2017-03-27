<?php
include('config.php');
include_once('auditTrial.php'); 
include_once('option.php');
include_once('utility.php'); 
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// username and password sent from Form 
	$myUsername=addslashes($_POST['username']); 
	$myPasswd=addslashes($_POST['password']); 
	$myPasswd = md5($myPasswd);	// convert to MD5
	// format the sql statement using the username and password fields of the form 
	$sql="SELECT id_userid, id_fullname, id_groupid, id_email, 
			id_agentid1, id_agentid2, id_agentid3, id_extension, id_playbackextension,
			id_searchextension, id_searchsplit, id_searchdnis, id_searchagentid FROM t_astuser WHERE 
			id_username='$myUsername' and id_password='$myPasswd'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)==1) {
		// If result matched $myusername and $mypassword, table row must be 1 row
		$_SESSION['s_loginUserid'] = $row['id_userid']; 
		$_SESSION['s_loginFullname'] = $row['id_fullname'];
		$_SESSION['s_loginGroupid'] = $row['id_groupid'];
		$_SESSION['s_loginEmail'] = $row['id_email'];
		$_SESSION['s_loginAgentID1'] = $row['id_agentid1'];
		$_SESSION['s_loginAgentID2'] = $row['id_agentid2'];
		$_SESSION['s_loginAgentID3'] = $row['id_agentid3'];
		$_SESSION['s_loginExtension'] = $row['id_extension'];
		$_SESSION['s_loginPlaybackExtension'] = $row['id_playbackextension'];
		if (!empty($row['id_searchextension'])) {
			$_SESSION['s_loginSearchExtension'] = formatSQLCondInFromConfigString($row['id_searchextension'], "id_device");
		}
		if (!empty($row['id_searchsplit'])) {
			$_SESSION['s_loginSearchSPLIT'] = formatSQLCondInFromConfigString($row['id_searchsplit'], "id_split");
		}
		if (!empty($row['id_searchdnis'])) {
			$_SESSION['s_loginSearchDNIS'] = formatSQLCondInFromConfigString($row['id_searchdnis'], "id_callednumber");
		}
		if (!empty($row['id_searchagentid'])) {
			$_SESSION['s_loginSearchAgentID'] = formatSQLCondInFromConfigString($row['id_searchagentid'], "id_agentid");
		}
		$_SESSION['s_loginUsername'] = $myUsername; 
		$_SESSION['s_loginPasswd'] = $myPasswd;
		// specific user options here 
		$callRecPerPage = getOption($_SESSION['s_loginUserid'], "al_callrecordperpage");
		if (isset($callRecPerPage)) {
			$_SESSION['s_callrecordperpage'] = $callRecPerPage; 
		} else {
			$_SESSION['s_callrecordperpage'] = 10; 
		}
		$auditTrial = "login successfully.";
		insertAuditTrial($auditTrial);
		$urlPage = $_SESSION['s_loginDestination'];  
		unset($_SESSION['s_loginDestination']);
		if (isset($urlPage)) {
			header("location: $urlPage"); 
		} else {
			header("location: welcome.php");
		}
		
	} else { 
		$auditTrial = "login failed.";
		insertAuditTrial($auditTrial);
	}
} 
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="libs/jqueryui/css/ui-lightness/jquery-ui-1.9.1.custom.css">
<link rel="stylesheet" href="libs/timepicker/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" href="libs/css/astlogger.css">  
<title>Login</title>
</head>
<body> 
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form action="" method="post">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>AstLogger Login</strong></td>
</tr>
<tr>
<td width="78">Username</td>
<td width="6">:</td>
<td width="294"><input name="username" type="text" id="username"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="password" type="password" id="password"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" value="  Submit  "></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
</body>
</html>

