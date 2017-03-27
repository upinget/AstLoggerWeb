<?php
include('lock.php');
include_once('auditTrial.php');
include_once('parameter.php');
include_once('option.php');
session_start();
$maxRecPerPage = getParameter("al_callrecordperpage");
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// username and password sent from Form 
	$newNumRecord=addslashes($_POST['numrecord']); 
	$oldNumRecord=getOption($_SESSION['s_loginUserid'], "al_callrecordperpage");
	if ($newNumRecord != $oldNumRecord) {
		if (!isset($oldNumRecord)) {
			if (insertOption($_SESSION['s_loginUserid'], "al_callrecordperpage", $newNumRecord)) {
				$_SESSION['s_callrecordperpage'] = $newNumRecord;
				$_SESSION['s_systemMessage'] = "Change record per page successfully.";
				// audit trial
				$auditTrial = "change record per page successfully.";
				insertAuditTrial($auditTrial);
			} else {
				$_SESSION['s_systemMessage'] = "Change record per page failed.";
				// audit trial
				$auditTrial = "change record per page failed.";
				insertAuditTrial($auditTrial);
			}				
		} else {
			if (setOption($_SESSION['s_loginUserid'], "al_callrecordperpage", $newNumRecord)) {
				$_SESSION['s_callrecordperpage'] = $newNumRecord;
				$_SESSION['s_systemMessage'] = "Change record per page successfully.";
				// audit trial
				$auditTrial = "change record per page successfully.";
				insertAuditTrial($auditTrial);
			} else {
				$_SESSION['s_systemMessage'] = "Change record per page failed.";
				// audit trial
				$auditTrial = "change record per page failed.";
				insertAuditTrial($auditTrial);
			}				
		}
	} else {
		$_SESSION['s_systemMessage'] = "Same record per page, no change.";
		// audit trial
		$auditTrial = "same record per page, no change.";
		insertAuditTrial($auditTrial);		
	}
	header("location: welcome.php?action=chgrecpage");	
}
?>
<script type="text/javascript">
    $(function(){      
        $('#optChgRecPageForm').validate({
			rules: {
				numrecord: {
					required: true, 
					min: 10, 
					max: <?php echo $maxRecPerPage;?>,
				},
            },
        });    
    });
</script>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="libs/css/astlogger.css">
<form class="optChgRecPageForm" id="optChgRecPageForm" action="optChgRecPage.php" method="post">
<table>
	<tr>
	<td >Records/Page</td>
	<td >:</td>
	<td ><input type="number" name="numrecord" id="numrecord" value="<?php echo $_SESSION['s_callrecordperpage'];?>"></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><input type="submit" value="  Submit  "></td>
	</tr>
</table>
</form>
