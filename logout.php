<?php
	include_once('db.php');

	$stmt = oci_parse($conn, "begin log_out; end;");
	oci_execute($stmt);
	echo  "<script type='text/javascript'>";
	echo "window.close();";
	echo "</script>";
?>