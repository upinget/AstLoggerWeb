<html>
<head>
<title>Dictionary Delete Result</title>    
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
	include('dictionaryDeleteForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="dictionaryDeleteForm") {
			$id=addslashes($_POST['id']);
			if (strlen($id)) {
				// format the sql statement using the id field of the form
				$sql="SELECT id_id, id_name FROM t_dictionary WHERE id_id='$id'";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				if (mysql_num_rows($result)==1) {
					$id_id = $row['id_id'];
					$id_name = $row['id_name'];
					// format the form
					echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
					echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
					echo "<form action=\"dictionaryDeleteResult.php\" method=\"post\">";
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
					echo "<td>";
					echo $id_id;
					echo "</td>";
					echo "</tr>";										
					echo "<tr>";
					echo "<td>Name</td>";
					echo "<td>:</td>";
					echo "<td>";
					echo $id_name; 
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"dictionaryDeleteResult\" /></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td><input type=\"submit\" value=\"  Delete  \"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
			}			
		} else {
			// id and name sent from Form
			$id=addslashes($_POST['id']);			
			$sql = "DELETE FROM t_dictionary WHERE id_id='$id'";
			$result=mysql_query($sql);
			if (mysql_affected_rows()==1) {
				$_SESSION['s_systemMessage'] = "Delete dictionary $id successfully.";
				// audit trial
				$auditTrial = "delete dictionary $id successfully.";
				insertAuditTrial($auditTrial);				
			} else {
				$_SESSION['s_systemMessage'] = "Delete dictionary $id failed.";
				// audit trial
				$auditTrial = "delete user $id failed.";
				insertAuditTrial($auditTrial);				
			}
			header("location: welcome.php?action=dictionarydelete");			
		}
	}
	?>		
	</div>
</body>
</html>