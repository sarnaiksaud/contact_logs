<html>
<head>
	<title>Summary</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
$conn = oci_connect('Saud', 'saud', 'localhost') or die ("Error connection to db");
?>
<div class="wrapper ">
	<div class="container">
		<div class="left">
			<h3>Top 10 Incoming call (counts)</h3>
			<br>
			<?php
				$query = "select * from top_10_I_count";
				$stmt = oci_parse($conn, $query);
				if(oci_execute($stmt))
				{
					echo "<table>";
					echo "<tr><th>Name</th>";
					// echo "<th>Duration</th>";
					echo "<th>Count</th></tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						echo "<tr>";
						echo "<td>$name_row[0]</td>";
						// echo "<td>$name_row[2]</td>"; 
						echo "<td>$name_row[3]</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			?>
		</div>
	</div>
	<div class="container">
		<div class="middle">
			<h3>Top 10 Outgoing call (counts)</h3>
			<br>
			<?php
				$query = "select * from top_10_O_count";
				$stmt = oci_parse($conn, $query);
				if(oci_execute($stmt))
				{
					echo "<table>";
					echo "<tr><th>Name</th>";
					// echo "<th>Duration</th>"; 
					echo "<th>Count</th></tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						echo "<tr>";
						echo "<td>$name_row[0]</td>";
						// echo "<td>$name_row[2]</td>";
						echo "<td>$name_row[3]</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			?>
		</div>
	</div>
	<div class="container">
		<div class="right">
			<h3>Top 10 longest Incoming calls</h3>
			<br>
			<?php
				$query = "select * from top_10_I_duration";
				$stmt = oci_parse($conn, $query);
				if(oci_execute($stmt))
				{
					echo "<table>";
					echo "<tr><th>Name</th>";
					echo "<th>Duration</th>"; 
					// echo "<th>Count</th>";
					echo "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						echo "<tr>";
						echo "<td>$name_row[0]</td>";
						echo "<td>$name_row[2]</td>";
						// echo "<td>$name_row[3]</td>";
						// echo "<td align=center>".substr($name_row[4],0,1)."</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			?>
		</div>
	</div>
	<div class="container">
		<div class="right">
			<h3>Top 10 longest Outgoing calls</h3>
			<br>
			<?php
				$query = "select * from top_10_O_duration";
				$stmt = oci_parse($conn, $query);
				if(oci_execute($stmt))
				{
					echo "<table>";
					echo "<tr><th>Name</th>";
					echo "<th>Duration</th>"; 
					// echo "<th>Count</th>";
					echo "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						echo "<tr>";
						echo "<td>$name_row[0]</td>";
						echo "<td>$name_row[2]</td>";
						// echo "<td>$name_row[3]</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			?>
		</div>
	</div>
</div>

<!--
<div class="wrapper ">
	<div class="container"><div class="left">Top 10 people called me</div></div>
	<div class="container"><div class="middle">Top 10 People called</div></div>
	<div class="container"><div class="right">Top 10 longest calls</div></div>
</div>
-->
<?php
oci_close($conn);
?>
</html>