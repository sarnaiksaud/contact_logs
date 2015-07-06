<?php

	IF(!ISSET($_REQUEST['data']))
		die('-1');
	
	$data = $_REQUEST['data'];
	$count = $_REQUEST['count'];
	
	$conn = oci_connect('Saud', 'saud', 'localhost') or die ("Error connection to db");
	
	$json = json_decode($data);
	
	if($json != null)
	{
		foreach ($json as $d)
		{
			$stmt = oci_parse($conn, "begin insert_to_call_log 
			(
			:pname,
			:pnumber,
			:ptype,
			:pcall_date,
			:pduration,
			:device
			);
			END;
			");
			
			oci_bind_by_name($stmt, "pname", $d->cName);
			oci_bind_by_name($stmt, "pnumber", $d->phNum);
			oci_bind_by_name($stmt, "ptype", $d->callTypeCode);
			oci_bind_by_name($stmt, "pcall_date", $d->callDate);
			oci_bind_by_name($stmt, "pduration", $d->callDuration);
			oci_bind_by_name($stmt, "device", $d->device);
			
			oci_execute($stmt);
		}
	}
	echo 1;
	/*
	$stmt = oci_parse($conn, "INSERT INTO TEMP_DATA VALUES (:count,:data)");
	

	oci_bind_by_name($stmt, "data", $data);
	oci_bind_by_name($stmt, "count", $count);

	if (!oci_execute($stmt)) {
		echo '-1';
	}
	else
	{
		echo '1';
	}
	*/
?>