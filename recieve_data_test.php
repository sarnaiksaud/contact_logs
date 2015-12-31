<?php

	include_once('db.php');

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
	
	$test = 'TEST';
	$old_date = '01-Jan-1900';
	$zero = '0';
	
	oci_bind_by_name($stmt, "pname", $test);
	oci_bind_by_name($stmt, "pnumber",  $test);
	oci_bind_by_name($stmt, "ptype",  $test);
	oci_bind_by_name($stmt, "pcall_date", $old_date);
	oci_bind_by_name($stmt, "pduration", $zero);
	oci_bind_by_name($stmt, "device",  $test);
	oci_bind_by_name($stmt, "inserted", $inserted,-1);

	oci_execute($stmt);
	echo "inserted : " . $inserted;
	
	$counter = 1;
	
	$stmt = oci_parse($conn, "INSERT INTO upload_log (count) VALUES (:count)");

	oci_bind_by_name($stmt, "count", $counter);

	if (!oci_execute($stmt)) {
		echo '-1';
	}
	else
	{
		echo '1';
	}
?>