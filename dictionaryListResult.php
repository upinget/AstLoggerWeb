<html>
<head>
<title>Dictionary List Result</title>    
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
	include('dictionaryListForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="dictionaryListForm") {
			$id=addslashes($_POST['id']);
			if (strlen($id)) {
				// format the sql statement using the id field of the form
				$sql="SELECT id_id, id_name FROM t_dictionary WHERE id_id LIKE '%$id%'";
			} else {
				// format the sql statement
				$sql="SELECT id_id, id_name FROM t_dictionary";
			}
			$result=mysql_query($sql);
			if (mysql_num_rows($result) > 0) {
				// format the form
				echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
				echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
				echo "<table width=\"100%\" border=\"1\">";
				echo "<tr>";
				echo "<th>ID</th><th>Name</th>";
				echo "</tr>"; 
				while($row = mysql_fetch_array($result)){
					$id_id = $row['id_id'];
					$id_name = $row['id_name'];
					echo "<tr>";
					echo "<td>";
					echo $id_id;
					echo "</td>";
					echo "<td>";
					echo $id_name;
					echo "</td>";
					echo "</tr>";
				}		
				echo "</table>";
				echo "</form>";
				// audit trial 
				$username=addslashes($_POST['username']);
				if (strlen($username)) {
					$auditTrial = "list dictionary like $id successfully.";
					insertAuditTrial($auditTrial);						
				} else {
					$auditTrial = "list all dictionary successfully.";
					insertAuditTrial($auditTrial);					
				}
			}		
		} 
	}
	?>		
	</div>
</body>
</html>