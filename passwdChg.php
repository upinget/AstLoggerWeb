<?php
include('lock.php');
include_once('auditTrial.php');
include_once('parameter.php');
session_start();
$policyUsernameMinLength = getParameter("al_policyusernameminlength");
$policyUsernameMaxLength = getParameter("al_policyusernamemaxlength");
$policyPasswdMinLength = getParameter("al_policypasswdminlength");
$policyPasswdMaxLength = getParameter("al_policypasswdmaxlength");
$policyPasswdNumDigits = getParameter("al_policypasswdnumdigits");
$policyPasswdNumCaps = getParameter("al_policypasswdnumcaps");
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// username and password sent from Form 
	$oldPasswd=addslashes($_POST['oldpasswd']); 
	$newPasswd=addslashes($_POST['newpasswd']); 
	$verfication=addslashes($_POST['verfication']);	
	$oldPasswd=md5($oldPasswd);
	if ($oldPasswd==$_SESSION['s_loginPasswd']) {
		if ($newPasswd==$verfication) {
			// format the sql statement using the new password fields of the form		
			$username = $_SESSION['s_loginUsername'];
			$newPasswd = md5($newPasswd); 
			$sql = "UPDATE t_astuser SET id_password='$newPasswd' WHERE id_username='$username'";
			$result=mysql_query($sql);
			if (mysql_affected_rows()==1){ 
				$_SESSION['s_loginPasswd'] = $newPasswd;  
				$_SESSION['s_systemMessage'] = "Change password successfully."; 
				// audit trial
				$auditTrial = "change password successfully.";
				insertAuditTrial($auditTrial);				
			} else {
				$_SESSION['s_systemMessage'] = "Change password failed.";
				// audit trial
				$auditTrial = "change password failed.";
				insertAuditTrial($auditTrial);				
			}
		} else {
			$_SESSION['s_systemMessage'] = "Password verification failed.";			
		}
	} else {
		$_SESSION['s_systemMessage'] = "Password is not matched.";			
	}
	header("location: welcome.php?action=chgpasswd");	
}
?>
<script type="text/javascript">
    $(function(){
    	jQuery.validator.addMethod(
    		"ContainsAtLeastDigit",
    		function (value) { 
    			return /\d{<?php echo $policyPasswdNumDigits;?>}/.test(value); 
    		},  
    		"Your password must contain <?php echo $policyPasswdNumDigits;?> digit."
    	);
    		
        jQuery.validator.addMethod(
    		"ContainsAtLeastCapitalLetter",
    		function (value) { 
    			return /[A-Z]{<?php echo $policyPasswdNumCaps;?>}/.test(value); 
    		},  
    		"Your password must contain at <?php echo $policyPasswdNumCaps;?> capital letter."
    	);		
        
        $('#passwdChgForm').validate({
			rules: {
				oldpasswd: "required",
				newpasswd: {
					required: true, 
					rangelength: [<?php echo "$policyPasswdMinLength, $policyPasswdMaxLength";?>],
					ContainsAtLeastDigit: true,
					ContainsAtLeastCapitalLetter: true, 
				},
				verfication: {
					required: true, 
					rangelength: [<?php echo "$policyPasswdMinLength, $policyPasswdMaxLength";?>],
					ContainsAtLeastDigit: true,
					ContainsAtLeastCapitalLetter: true,	
					equalTo: "#newpasswd",									
				},
            },
            messages: {
               	password: "Password at least <?php echo $policyPasswdMinLength;?> characters, <?php echo $policyPasswdNumDigits;?> digit and <?php echo $policyPasswdNumCaps;?> capital letter.",
            	verfication: "Password at least <?php echo $policyPasswdMinLength;?> characters, <?php echo $policyPasswdNumDigits;?> digit and <?php echo $policyPasswdNumCaps;?> capital letter.",
            }            
        });    
    });
</script>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="libs/css/astlogger.css">
<form class="passwdChgForm" id="passwdChgForm" action="passwdChg.php" method="post">
<table>
	<tr>
	<td >Old Password</td>
	<td >:</td>
	<td ><input name="oldpasswd" type="password" id="oldpasswd"></td>
	</tr>
	<tr>
	<td >New Password</td>
	<td >:</td>
	<td ><input name="newpasswd" type="password" id="newpasswd"></td>
	</tr>	
	<tr>
	<td >Verfication</td>
	<td >:</td>
	<td ><input name="verfication" type="password" id="verfication"></td>
	</tr>	
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><input type="submit" value="  Submit  "></td>
	</tr>
</table>
</form>