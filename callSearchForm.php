<?php
include('lock.php');
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="libs/jqueryui/css/ui-lightness/jquery-ui-1.9.1.custom.css">
<link rel="stylesheet" href="libs/timepicker/jquery-ui-timepicker-addon.css" >
<link rel="stylesheet" href="libs/css/astlogger.css">
<form action="callSearchResult.php" method="post">
<table>
	<tr>
	<td >From</td>
	<td >:</td>
	<td ><input name="startdatetime" id="startdatetime"></td>
	</tr>	
	<tr>
	<td >To</td>
	<td >:</td>
	<td ><input name="enddatetime" id="enddatetime"></td>
	</tr>	
	<?php
	if ($_SESSION['s_loginGroupid'] <= 1) { // 0 is admin, 1 is supervisor   	
		echo "<tr>";
		echo "<td >Extension</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"extension\" type=\"text\" id=\"extension\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td >AgentID</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"agentid\" type=\"text\" id=\"agentid\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td >Calling</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"clid\" type=\"text\" id=\"clid\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td >Called</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"dnis\" type=\"text\" id=\"dnis\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td >Key</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"key\" type=\"text\" id=\"key\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td >UCID</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"ucid\" type=\"text\" id=\"ucid\"></td>";
		echo "</tr>";		
		echo "<tr>";
		echo "<td >Split</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"split\" type=\"text\" id=\"split\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td >TG</td>";
		echo "<td >:</td>";
		echo "<td ><input name=\"tg\" type=\"text\" id=\"tg\"></td>";
		echo "</tr>";		
	}
	?>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><input type="submit" value="  Submit  "></td>
	</tr>
</table>
</form>
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