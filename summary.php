<html>
<head>
	<title>Summary</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
$conn = oci_connect('Saud', 'saud', 'localhost') or die ("Error connection to db");

$stmt = oci_parse($conn, "select NVL(MAX(start_date),'01-JAN-2015'), NVL(MAX(end_date),SYSDATE) from dates");
if(oci_execute($stmt))
{
	$name_row = oci_fetch_array($stmt);
	$start_date = $name_row[0];
	$end_date = $name_row[1];
}
else
{
	die ("Error");
}

/*
$stmt = oci_parse($conn, 'select * from check_login');
if(oci_execute($stmt))
{
	$name_row=oci_fetch_array($stmt);
	if($name_row[0] != 1)
		die ("Wrong credentials <br><a href='login.php'>Login</a>");
}
else
{
	die ("Error");
}*/
?>
<H1>
	<?php echo "DATA SHOWN IS BETWEEN $start_date AND $end_date"; ?>
</H1>
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

<div class="wrapper ">
	<div class="container">
		<div class="left">
			<h3>Longest call</h3>
			<br>
			<?php
				$query = "select * from longest_call";
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
						echo "<td>$name_row[1]</td>";
						// echo "<td>$name_row[3]</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			?>
		</div>
	</div>
	<div class="container">
		<div class="left">
			<h3>Summary call</h3>
			<br>
			<?php
				$query = "select * from summary";
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
						echo "<td>$name_row[1]</td>";
						// echo "<td>$name_row[3]</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			?>
		</div>
	</div>
	<div class="container">
		<div class="left">
			<h3>Top 10 Missed Caller</h3>
			<br>
			<?php
				$query = "select * from top_10_M_count";
				$stmt = oci_parse($conn, $query);
				if(oci_execute($stmt))
				{
					echo "<table>";
					echo "<tr><th>Name</th>";
					// echo "<th>Duration</th>"; 
					echo "<th>Count</th>";
					echo "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						echo "<tr>";
						echo "<td>$name_row[0]</td>";
						// echo "<td>$name_row[1]</td>";
						echo "<td>$name_row[3]</td>";
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
	<div class="container">
		<div class="middle">
			<h3>Top 10 People called<h3>
		</div>
	</div>
</div>
-->
<?php
oci_close($conn);
?>
</html>