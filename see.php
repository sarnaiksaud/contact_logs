<?php

	include_once('db.php');
	
		$set = 0;
			$stmt = oci_parse($conn, "SELECT * from show_data");
			if(oci_execute($stmt))
			{
				$name_row = oci_fetch_array($stmt);
				if(isset($name_row[0])) $set = 1; 
				else
					echo "Session has ended <a class='show' href='index.php'>Click here</a> to login" ;
			}
			if($set == 1)
			{
				?>
				<table border=1>
<tr>
	<th>Log_id</th>
	<th>Name</th>
	<th>Number</th>
	<th>Type</th>
	<th>Call Date</th>
	<th>Duration</th>
</tr>
<?php
	$stmt = oci_parse($conn, "SELECT * FROM call_log order by log_id desc");
	if(oci_execute($stmt))
	{
		while($name_row=oci_fetch_array($stmt))
		{
		?>
			<tr>
				<td><?=$name_row[0]?></td>
				<td><?=$name_row[1]?></td>
				<td><?=$name_row[2]?></td>
				<td><?=$name_row[3]?></td>
				<td><?=$name_row[4]?></td>
				<td><?=$name_row[5]?> seconds</td>
			</tr>
		<?php
		}
	}
			}
?>
</table>