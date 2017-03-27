<html>
<head>
<title>Dictionary Modify Result</title>    
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
	include('dictionaryModifyForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="dictionaryModifyForm") {
			$id=addslashes($_POST['id']);
			if (strlen($id)) {
				// format the sql statement using the id field of the form
				$sql="SELECT id_id, id_name	FROM t_dictionary WHERE id_id='$id'";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				if (mysql_num_rows($result)==1) {
					$id_id = $row['id_id'];
					$id_name = $row['id_name'];
					// format the form
					echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
					echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
					echo "<form action=\"dictionaryModifyResult.php\" method=\"post\">";
					echo "<table>";
					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><input name=\"id\" type=\"hidden\" id=\"id\" value=\"";
					echo $id_id;
					echo "\"></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>ID</td>";
					echo "<td>:</td>";
					echo "<td>$id_id</td>";
					echo "</tr>";						
					echo "<tr>";
					echo "<td>Name</td>";
					echo "<td>:</td>";
					echo "<td><textarea name=\"name\" id=\"name\" rows=\"1\" cols=\"80\" >$id_name</textarea></td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"dictionaryModifyResult\" /></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td><input type=\"submit\" value=\"  Update  \"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
			}			
		} else {
			// username and password sent from Form
			$id=addslashes($_POST['id']);
			$name=addslashes($_POST['name']);
			$sql = "UPDATE t_dictionary SET id_name='$name' WHERE id_id='$id'";
			$result=mysql_query($sql);
			$nRows = mysql_affected_rows();
			if ($nRows==1) {
				$_SESSION['s_systemMessage'] = "Modify dictionary $id successfully.";
				// audit trial 
				$auditTrial = "modify dictionary $id successfully.";
				insertAuditTrial($auditTrial);
			} else {
				$_SESSION['s_systemMessage'] = "Modify dictionary $id failed.";
				// audit trial				
				$auditTrial = "modify dictionary $id failed.";
				insertAuditTrial($auditTrial);				
			}
			header("location: welcome.php?action=dictionarymodify");			
		}
	}
	?>		
	</div>
</body>
</html>