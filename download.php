<?php
include('lock.php');
include_once('callData.php');
include_once('utility.php');
include_once('auditTrial.php');
include_once('parameter.php');
if ($_SESSION['s_loginGroupid'] <= 1) {
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$getKey = addslashes($_POST['key']);
        $applicationFolder = getParameter("al_applicationfolder");
        $downloadFilenames = array();
        $displayFilenames = array(); 
        $decryptedFiles = array();        
		if ($getKey!="all") {
			$recpathArray = recPathArray($getKey);
			if (sizeof($recpathArray)>0) {
				$fullFilename=$_SERVER['DOCUMENT_ROOT']."/$applicationFolder".$recpathArray[0];
				$downloadFilenames[] = $fullFilename;			
                $displayFilenames[] = $recpathArray[3];
                $decryptedFiles[] = $recpathArray[2]; 
			}		
		} else {
			include('navbar.php');
			$nav_page = addslashes($_POST['page']);
			$sql = $_SESSION['s_callQuerySQL']; 
			$nav = new navbar;
			$nav->nav_numrowsperpage = $_SESSION['s_callrecordperpage'];
			$result = $nav->execute($sql, $db, "mysql");
			if (mysql_num_rows($result) > 0) {              
				while($row = mysql_fetch_array($result)){
					$recpathArray = recPathArray($row['id_uniquekey']);
                    if (sizeof($recpathArray)>0) {
                        $fullFilename=$_SERVER['DOCUMENT_ROOT']."/$applicationFolder".$recpathArray[0];
                        $downloadFilenames[] = $fullFilename;			
                        $displayFilenames[] = $recpathArray[3];
                        $decryptedFiles[] = $recpathArray[2]; 
                    }                    
				}
			}
		}
		// download the file
		if (count($downloadFilenames)>0) {
			$archiveFilename = randomPassword().'.zip';
			zipFilesAndDownload($downloadFilenames, $displayFilenames, $decryptedFiles, $archiveFilename);
			// audit trial
			$auditTrial = "download voice files $downloadFilenames[0], $displayFilenames[0], $decryptedFiles[0], $getKey successfully.";
			insertAuditTrial($auditTrial);				
		}	
	} // only apply to post  
} // only supervisor or admin has this right to download file 
?>