<?php
	include_once('db.php');
	
	$start_date = date('Y-m-01');
	$end_date = date('Y-m-d');
	
	if(isset($_REQUEST['start_date']))
			$start_date  = $_REQUEST['start_date'];
	if(isset($_REQUEST['end_date']))
			$end_date  = $_REQUEST['end_date'];
		
	echo "Start Date" . $start_date;
	echo "<br>End date" . $end_date;
	
	$stmt = oci_parse($conn, "begin update_dates 
			(
			:start_date,
			:end_date
			);
			END;
			");
			
			oci_bind_by_name($stmt, "start_date", $start_date);
			oci_bind_by_name($stmt, "end_date", $end_date);
			
	if(oci_execute($stmt))
	{
		echo 1;
	}
	else
	{
		echo -1;
	}
echo  "<script type='text/javascript'>";
echo "window.close();";
echo "</script>";
?>