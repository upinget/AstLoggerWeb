<html>
<head>
<title>Param List Result</title>    
<?php 
include('config.php');
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
	include('paramListForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="paramListForm") {
			$variable=addslashes($_POST['variable']);
			if (strlen($variable)) {
				// format the sql statement using the variable of the form
				$sql="SELECT pVariable, pValue, pDescription FROM tParameter WHERE pVariable LIKE '%$variable%'";
			} else {
				$sql="SELECT pVariable, pValue, pDescription FROM tParameter";
			}
			$result=mysql_query($sql);
			if (mysql_num_rows($result) > 0) {
				// format the form
				echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
				echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
				echo "<table width=\"100%\" border=\"1\" >";
				echo "<tr>";
				echo "<th>pVariable</th><th>pValue</th><th>pDescription</th>";
				echo "</tr>"; 
				while($row = mysql_fetch_array($result)){
					$variable = $row['pVariable'];
					$value = $row['pValue'];
					$description = $row['pDescription'];
					echo "<tr>";
					echo "<td>";
					echo $variable;
					echo "</td>";
					echo "<td>";
					echo $value;
					echo "</td>";
					echo "<td>";
					echo $description;
					echo "</td>";				
					echo "</tr>";
					// blank line 
					echo "<tr>"; 
					echo "</tr>"; 
				}		
				echo "</table>";
				echo "</form>";
				$variable=addslashes($_POST['variable']);
				if (strlen($variable)) {
					// audit trial
					$auditTrial = "list parameter like $variable successfully.";
					insertAuditTrial($auditTrial);
				} else {
					// audit trial
					$auditTrial = "list all parameter successfully.";
					insertAuditTrial($auditTrial);						
				}
			}		
		} 
	}
	?>		
	</div>
</body>
</html>