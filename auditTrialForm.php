<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="libs/jqueryui/css/ui-lightness/jquery-ui-1.9.1.custom.css">
<link rel="stylesheet" href="libs/timepicker/jquery-ui-timepicker-addon.css" >
<link rel="stylesheet" href="libs/css/astlogger.css">
<?php
include('lock.php');
if ($_SESSION['s_loginGroupid'] <= 1) { // 0 is admin, 1 is supervisor
	$form = "
	<form action=\"auditTrialResult.php\" method=\"post\">
	<table>
	<tr>
	<td >From:</td>
	<td >:</td>
	<td ><input name=\"startdatetime\" id=\"startdatetime\"></td>
	</tr>
	<tr>
	<td >To:</td>
	<td >:</td>
	<td ><input name=\"enddatetime\" id=\"enddatetime\"></td>
	</tr>
	<tr>
	<td >Contains</td>
	<td >:</td>
	<td ><input name=\"contains\" type=\"text\" id=\"contains\"></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><input type=\"submit\" value=\"  Submit  \"></td>
	</tr>
	</table>
	</form>
	";
	echo $form; 
}
?>
<script type="text/javascript" src="libs/timepicker/jquery-ui-timepicker-addon.js"></script>	
<script>
(function($){
var startDateTextBox = $("#startdatetime");
var endDateTextBox = $("#enddatetime");

startDateTextBox.datetimepicker({ 
	onClose: function(dateText, inst) {
		if (endDateTextBox.val() != '') {
			var testStartDate = startDateTextBox.datetimepicker('getDate');
			var testEndDate = endDateTextBox.datetimepicker('getDate');
			if (testStartDate > testEndDate)
				endDateTextBox.datetimepicker('setDate', testStartDate);
		}
		else {
			endDateTextBox.val(dateText);
		}
	},
	onSelect: function (selectedDateTime){
		endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
	}
});
endDateTextBox.datetimepicker({ 
	onClose: function(dateText, inst) {
		if (startDateTextBox.val() != '') {
			var testStartDate = startDateTextBox.datetimepicker('getDate');
			var testEndDate = endDateTextBox.datetimepicker('getDate');
			if (testStartDate > testEndDate)
				startDateTextBox.datetimepicker('setDate', testEndDate);
		}
		else {
			startDateTextBox.val(dateText);
		}
	},
	onSelect: function (selectedDateTime){
		startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
	}
});
})(jQuery);	
</script>