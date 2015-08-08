<table border=1>
<tr>
	<th>Name</th>
	<th>Number</th>
	<th>Type</th>
	<th>Call Date</th>
	<th>Duration</th>
</tr>
<?php

	include_once('db.php');
	
	$stmt = oci_parse($conn, "SELECT * FROM call_log order by log_id desc");
	if(oci_execute($stmt))
	{
		while($name_row=oci_fetch_array($stmt))
		{
		?>
			<tr>
				<td><?=$name_row[1]?></td>
				<td><?=$name_row[2]?></td>
				<td><?=$name_row[3]?></td>
				<td><?=$name_row[4]?></td>
				<td><?=$name_row[5]?> seconds</td>
			</tr>
		<?php
		}
	}
	
?>
</table>