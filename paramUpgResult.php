<html>
<head>
<title>Parameter Upgrade Result</title>    
<?php 
include('config.php');
include_once('parameter.php');
include_once('auditTrial.php');
session_start();
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
	include('paramUpgForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="paramUpgForm") {
			$alSenderAddress = getParameter("al_emailsenderaddress");
			if (!isset($alSenderAddress)) {
				if (insertParameter("al_emailsenderaddress", "", "System notification email address")==true) {
					echo "Insert al_emailsenderaddress successfully.";
					echo "<br />";
				} else {
					echo "Insert al_emailsenderaddress failed.";
					echo "<br />";					
				}
			}
			$alApplicationFolder = getParameter("al_applicationfolder");
			if (!isset($alApplicationFolder)) {
				if (insertParameter("al_applicationfolder", "astlogger", "AstLoggerWeb application folder")==true) {
					echo "Insert al_applicationfolder successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_applicationfolder failed.";
					echo "<br />";					
				}
			}	
			$alPolicyUsernameMinLength = getParameter("al_policyusernameminlength");
			if (!isset($alPolicyUsernameMinLength)) {
				if (insertParameter("al_policyusernameminlength", "6", "Policy for Username Minimum Length")==true) {
					echo "Insert al_policyusernameminlength successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_policyusernameminlength failed.";
					echo "<br />";					
				}
			}			
			$alPolicyUsernameMaxLength = getParameter("al_policyusernamemaxlength");
			if (!isset($alPolicyUsernameMaxLength)) {
				if (insertParameter("al_policyusernamemaxlength", "14", "Policy for Username Maximum Length")==true) {
					echo "Insert al_policyusernamemaxlength successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_policyusernamemaxlength failed.";
					echo "<br />";					
				}
			}			
			$alPolicyPasswdMinLength = getParameter("al_policypasswdminlength");
			if (!isset($alPolicyPasswdMinLength)) {
				if (insertParameter("al_policypasswdminlength", "6", "Policy for Password Minimum Length")==true) {
					echo "Insert al_policypasswdminlength successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_policypasswdminlength failed.";
					echo "<br />";					
				}
			}	
			$alPolicyPasswdMaxLength = getParameter("al_policypasswdmaxlength");
			if (!isset($alPolicyPasswdMaxLength)) {
				if (insertParameter("al_policypasswdmaxlength", "14", "Policy for Password Maximum Length")==true) {
					echo "Insert al_policypasswdmaxlength successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_policypasswdmaxlength failed.";
					echo "<br />";					
				}
			}						
			$alPolicyPasswdNumDigits = getParameter("al_policypasswdnumdigits");
			if (!isset($alPolicyPasswdNumDigits)) {
				if (insertParameter("al_policypasswdnumdigits", "1", "Policy for Password Contains Number of Digits")==true) {
					echo "Insert al_policypasswdnumdigits successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_policypasswdnumdigits failed.";
					echo "<br />";					
				}
			}		
			$alPolicyPasswdNumCaps = getParameter("al_policypasswdnumcaps");
			if (!isset($alPolicyPasswdNumCaps)) {
				if (insertParameter("al_policypasswdnumcaps", "1", "Policy for Password Contains Number of Capital Letters")==true) {
					echo "Insert al_policypasswdnumcaps successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_policypasswdnumcaps failed.";
					echo "<br />";					
				}
			}		
			$alCallRecordPerPage = getParameter("al_callrecordperpage");
			if (!isset($alCallRecordPerPage)) {
				if (insertParameter("al_callrecordperpage", "100", "Maximum Call Records Display Per Page")==true) {
					echo "Insert al_callrecordperpage successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_callrecordperpage failed.";
					echo "<br />";					
				}
			}						
			$alCallRecordDownload = getParameter("al_callrecorddownload");
			if (!isset($alCallRecordDownload)) {
				if (insertParameter("al_callrecorddownload", "false", "Enable or Disable Call Records Download")==true) {
					echo "Insert al_callrecorddownload successfully.";
					echo "<br />";					
				} else {
					echo "Insert al_callrecorddownload failed.";
					echo "<br />";					
				}
			}			
			echo "Upgrade Completed. ";
			// audit trial
			$auditTrial = "upgrade tParameter table successfully.";
			insertAuditTrial($auditTrial);			
		} 
	}
	?>		
	</div>
</body>
</html>