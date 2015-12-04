<?php

	IF(!ISSET($_REQUEST['data']))
		die('-1');
	
	$data = $_REQUEST['data'];
	$count = $_REQUEST['count'];
	
	include_once('db.php');
	
	$json = json_decode($data);
	
	$counter = 0;
	
	if($json != null)
	{
		foreach ($json as $d)
		{
			$inserted = -1;
			
			$stmt = oci_parse($conn, "begin insert_to_call_log 
			(
			:pname,
			:pnumber,
			:ptype,
			:pcall_date,
			:pduration,
			:device,
			:inserted
			);
			END;
			");
			
			oci_bind_by_name($stmt, "pname", $d->cName);
			oci_bind_by_name($stmt, "pnumber", $d->phNum);
			oci_bind_by_name($stmt, "ptype", $d->callTypeCode);
			oci_bind_by_name($stmt, "pcall_date", $d->callDate);
			oci_bind_by_name($stmt, "pduration", $d->callDuration);
			oci_bind_by_name($stmt, "device", $d->device);
			oci_bind_by_name($stmt, "inserted", $inserted,-1);
			
			oci_execute($stmt);
			
			if($inserted == 1) 
				$counter++;
		}
	}
	echo 1;
	
	$stmt = oci_parse($conn, "INSERT INTO upload_log (count) VALUES (:count)");
	

	oci_bind_by_name($stmt, "count", $counter);

	if (!oci_execute($stmt)) {
		echo '-1';
	}
	else
	{
		$stmt = oci_parse($conn, "BEGIN update_names; END;");
		oci_execute($stmt);
		echo '1';
	}
	
?>