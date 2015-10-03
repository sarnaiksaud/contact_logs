<?php
	include_once('db.php');
	

	if(isset($_REQUEST['username']))
			$username  = md5($_REQUEST['username']);
	if(isset($_REQUEST['password']))
			$password  = md5($_REQUEST['password']);
		

	$stmt = oci_parse($conn, "begin :return_data := login_cre_p 
			(
			:username,
			:password
			);
			END;
			");
			
			oci_bind_by_name($stmt, "username", $username);
			oci_bind_by_name($stmt, "password", $password);
			oci_bind_by_name($stmt, "return_data", $return_data,-1);
			
oci_execute($stmt);

if ($return_data = 1)
{
	$stmt = oci_parse($conn, "begin log_in; end;");
	oci_execute($stmt);
	echo  "<script type='text/javascript'>";
	echo "window.close();";
	echo "</script>";
}
{
echo "invalid credentials";
}	


?>