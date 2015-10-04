<html>
<head>
	<title>Summary</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
include_once('db.php');

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
	<?php echo "DATA SHOWN IS BETWEEN <i>$start_date</i> AND <i>$end_date</i>"; ?>
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
					$data = "";
					$count = 0;
					
					$data = "<table>";
					$data = $data . "<tr><th>Name</th>";
					// $data = $data . "<th>Duration</th>";
					$data = $data . "<th>Count</th></tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						$data = $data . "<tr>";
						$data = $data . "<td>$name_row[0]</td>";
						// $data = $data . "<td>$name_row[2]</td>"; 
						$data = $data . "<td>$name_row[3]</td>";
						$data = $data . "</tr>";
						$count++;
					}
					$data = $data . "</table>";
					
					IF ($count > 0)
						echo $data;
					ELSEIF ($count == 0)
						echo "No Records Found";
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
					$data = "";
					$count = 0;
					
					$data = "<table>";
					$data = $data . "<tr><th>Name</th>";
					// $data = $data . "<th>Duration</th>"; 
					$data = $data . "<th>Count</th></tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						$data = $data . "<tr>";
						$data = $data . "<td>$name_row[0]</td>";
						// $data = $data . "<td>$name_row[2]</td>";
						$data = $data . "<td>$name_row[3]</td>";
						$data = $data . "</tr>";
						$count++;
					}
					$data = $data . "</table>";
					
					IF ($count > 0)
						echo $data;
					ELSEIF ($count == 0)
						echo "No Records Found";
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
					$data = "";
					$count = 0;
					
					$data = "<table>";
					$data = $data . "<tr><th>Name</th>";
					$data = $data . "<th>Duration</th>"; 
					// $data = $data . "<th>Count</th>";
					$data = $data . "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						$data = $data . "<tr>";
						$data = $data . "<td>$name_row[0]</td>";
						$data = $data . "<td>$name_row[2]</td>";
						// $data = $data . "<td>$name_row[3]</td>";
						// $data = $data . "<td align=center>".substr($name_row[4],0,1)."</td>";
						$data = $data . "</tr>";
						$count++;
					}
					$data = $data . "</table>";
					
					IF ($count > 0)
						echo $data;
					ELSEIF ($count == 0)
						echo "No Records Found";
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
					$data = "";
					$count = 0;
					
					$data = $data . "<table>";
					$data = $data . "<tr><th>Name</th>";
					$data = $data . "<th>Duration</th>"; 
					// $data = $data . "<th>Count</th>";
					$data = $data . "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						$data = $data . "<tr>";
						$data = $data . "<td>$name_row[0]</td>";
						$data = $data . "<td>$name_row[2]</td>";
						// $data = $data . "<td>$name_row[3]</td>";
						$data = $data . "</tr>";
						$count++;
					}
					$data = $data . "</table>";
					
					IF ($count > 0)
						echo $data;
					ELSEIF ($count == 0)
						echo "No Records Found";
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
					$data = "";
					$count = 0;
					
					$data = $data . "<table>";
					$data = $data . "<tr><th>Name</th>";
					$data = $data . "<th>Duration</th>"; 
					// $data = $data . "<th>Count</th>";
					$data = $data . "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						$data = $data . "<tr>";
						$data = $data . "<td>$name_row[0]</td>";
						$data = $data . "<td>$name_row[1]</td>";
						// $data = $data . "<td>$name_row[3]</td>";
						$data = $data . "</tr>";
						$count++;
					}
					$data = $data . "</table>";
					
					IF ($count > 0)
						echo $data;
					ELSEIF ($count == 0)
						echo "No Records Found";
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
					$data = "";
					$count = 0;
					
					$data = $data . "<table>";
					$data = $data . "<tr><th>Name</th>";
					$data = $data . "<th>Duration</th>"; 
					// $data = $data . "<th>Count</th>";
					$data = $data . "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						$data = $data . "<tr>";
						$data = $data . "<td>$name_row[0]</td>";
						$data = $data . "<td>$name_row[1]</td>";
						// $data = $data . "<td>$name_row[3]</td>";
						$data = $data . "</tr>";
						$count++;
					}
					$data = $data . "</table>";
					
					IF ($count > 0)
						echo $data;
					ELSEIF ($count == 0)
						echo "No Records Found";
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
					$data = "";
					$count = 0;
					
					$data = $data . "<table>";
					$data = $data . "<tr><th>Name</th>";
					// $data = $data . "<th>Duration</th>"; 
					$data = $data . "<th>Count</th>";
					$data = $data . "</tr>";
					while($name_row=oci_fetch_array($stmt))
					{
						$data = $data . "<tr>";
						$data = $data . "<td>$name_row[0]</td>";
						// $data = $data . "<td>$name_row[1]</td>";
						$data = $data . "<td>$name_row[3]</td>";
						$data = $data . "</tr>";
						$count++;
					}
					$data = $data . "</table>";
					
					IF ($count > 0)
						echo $data;
					ELSEIF ($count == 0)
						echo "No Records Found";
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