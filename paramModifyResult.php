<html>
<head>
<title>Parameter Modify Result</title>    
<?php 
include('config.php');
include_once('auditTrial.php');
include_once('parameter.php');
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
	include('paramModifyForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="paramModifyForm") {
			$variable=addslashes($_POST['variable']);
			if (strlen($variable)) {
				// format the sql statement using the variable fields of the form
				$sql="SELECT pValue, pDescription FROM tParameter WHERE pVariable='$variable'";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				if (mysql_num_rows($result)==1) {
					$value = $row['pValue'];
					$description = $row['pDescription'];
					// format the form
					echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
					echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
					echo "<form action=\"paramModifyResult.php\" method=\"post\">";
					echo "<table>";
					// hidden field
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"pVariable\" type=\"hidden\" id=\"pVariable\" value=\"";
					echo $variable;
					echo "\"></td>";
					echo "</tr>";
					// display pVariable 
					echo "<tr>";
					echo "<td >pVariable</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $variable;
					echo "</td>";
					echo "</tr>";										
					// Edit pValue
					echo "<tr>";
					echo "<td >pValue</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"pValue\" id=\"pValue\" rows=\"1\" cols=\"80\" >$value</textarea></td>";
					echo "</tr>";
					// Edit pDescription
					echo "<tr>";
					echo "<td >pDescription</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"pDescription\" id=\"pDescription\" rows=\"1\" cols=\"80\" >$description</textarea></td>";					
					echo "</tr>";
					// hidden form name 
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"paramModifyResult\" /></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td><input type=\"submit\" value=\"  Modify  \"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
			}			
		} else if ($formname=="paramModifyResult") {
			// username and password sent from Form
			$variable=addslashes($_POST['pVariable']);
			$value=addslashes($_POST['pValue']);
			$description=addslashes($_POST['pDescription']);
			if (setParameter($variable, $value, $description)) {
				$_SESSION['s_systemMessage'] = "Update parameter $variable successfully.";
				// audit trial
				$auditTrial = "update parameter $variable successfully.";
				insertAuditTrial($auditTrial);				
			} else {
				$_SESSION['s_systemMessage'] = "Update parameter $variable failed.";
				// audit trial
				$auditTrial = "update parameter $variable failed.";
				insertAuditTrial($auditTrial);				
			}
			header("location: welcome.php?action=paramModify");			
		}
	}
	?>		
	</div>
</body>
</html>