<?php
$conn = oci_connect('Saud', 'saud', 'localhost') or die ("Error connection to db");

$stmt = oci_parse($conn, "select distinct phone,INITCAP(TRIM(SUBSTR(phone,0,INSTR(phone,'/', 1)-1))) from call_log");
oci_execute($stmt);
$text = "All";
while($phone=oci_fetch_array($stmt))
{
	$text = $text . ";" .$phone[1];
}
echo $text;
?>