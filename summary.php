<html>
<head>
	<title>Summary</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/demo.css">

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/accordion.js"></script>
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
<p>
	<?php echo "<i>$start_date</i> to <i>$end_date</i>"; ?>
	<a href="set_dates_form.php" target="_blank">Change dates</a>
</p>
	<div class="main">
		<div class="accordion">
		<div class="accordion-section">
				<a class="accordion-section-title" href="#accordion-1">Regular Summary</a>
				<div id="accordion-1" class="accordion-section-content">
		<table class="main">
			<tr>
				<td class="ndata"><h3>Top 10 Incoming call (counts)</h3></td>
				<td class="ndata"><h3>Top 10 Outgoing call (counts)</h3></td>
				<td class="ndata"><h3>Top 10 longest Incoming calls</h3></td>
			</tr>
			<tr>
				<td class="data">
					<?php
						$query = "select * from top_10_I_count";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = "<table class='internal'>";
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
				</td>

				</td>
				<td class="data">
					<?php
						$query = "select * from top_10_O_count";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = "<table class='internal'>";
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
				</td>
				<td class="data">
					<?php
						$query = "select * from top_10_I_duration";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = "<table class='internal'>";
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
				</td>
			</tr>
		</table>
		<hr>
		<table class="main">
			<tr>
				<td class="ndata"><h3>Top 10 longest Outgoing calls</h3></td>
				<td class="ndata"><h3>Longest call</h3></td>
				<!--<td class="ndata"><h3>Summary call</h3></td>-->
				<td class="ndata"><h3>Top 10 Missed Caller</h3></td>
			</tr>
			<tr>
					<td class="data">
					<?php
						$query = "select * from top_10_O_duration";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal'>";
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
				</td>
				<td class="data">
					<?php
						$query = "select * from longest_call";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal'>";
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
				</td>
				<!--<td class="data">
					<?php
						$query = "select * from summary";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal'>";
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
				</td>-->
				<td class="data">
					<?php
						$query = "select * from top_10_M_count";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal'>";
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
				</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="accordion-section">
				<a class="accordion-section-title" href="#accordion-3">Hourly Analysis</a>
				<div id="accordion-3" class="accordion-section-content">
					<?php
						$query = "select * from hourly_analysis";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal' align='center'>";
							$data = $data . "<tr>";
							$data = $data . "<th>Call Type</th>";
							$data = $data . "<th>H 00</th>";
							$data = $data . "<th>H 01</th>";
							$data = $data . "<th>H 02</th>";
							$data = $data . "<th>H 03</th>";
							$data = $data . "<th>H 04</th>";
							$data = $data . "<th>H 05</th>";
							$data = $data . "<th>H 06</th>";
							$data = $data . "<th>H 07</th>";
							$data = $data . "<th>H 08</th>";
							$data = $data . "<th>H 09</th>";
							$data = $data . "<th>H 10</th>";
							$data = $data . "<th>H 11</th>";
							$data = $data . "<th>H 12</th>";
							$data = $data . "<th>H 13</th>";
							$data = $data . "<th>H 14</th>";
							$data = $data . "<th>H 15</th>";
							$data = $data . "<th>H 16</th>";
							$data = $data . "<th>H 17</th>";
							$data = $data . "<th>H 18</th>";
							$data = $data . "<th>H 19</th>";
							$data = $data . "<th>H 20</th>";
							$data = $data . "<th>H 21</th>";
							$data = $data . "<th>H 22</th>";
							$data = $data . "<th>H 23</th>";
							$data = $data . "</tr>";
							while($name_row=oci_fetch_array($stmt))
							{
								$data = $data . "<tr>";
								$data = $data . "<td align='center'>$name_row[0]</td>";
								$data = $data . "<td align='center'>$name_row[1]</td>";
								$data = $data . "<td align='center'>$name_row[2]</td>";
								$data = $data . "<td align='center'>$name_row[3]</td>";
								$data = $data . "<td align='center'>$name_row[4]</td>";
								$data = $data . "<td align='center'>$name_row[5]</td>";
								$data = $data . "<td align='center'>$name_row[6]</td>";
								$data = $data . "<td align='center'>$name_row[7]</td>";
								$data = $data . "<td align='center'>$name_row[8]</td>";
								$data = $data . "<td align='center'>$name_row[9]</td>";
								$data = $data . "<td align='center'>$name_row[10]</td>";
								$data = $data . "<td align='center'>$name_row[11]</td>";
								$data = $data . "<td align='center'>$name_row[12]</td>";
								$data = $data . "<td align='center'>$name_row[13]</td>";
								$data = $data . "<td align='center'>$name_row[14]</td>";
								$data = $data . "<td align='center'>$name_row[15]</td>";
								$data = $data . "<td align='center'>$name_row[16]</td>";
								$data = $data . "<td align='center'>$name_row[17]</td>";
								$data = $data . "<td align='center'>$name_row[18]</td>";
								$data = $data . "<td align='center'>$name_row[19]</td>";
								$data = $data . "<td align='center'>$name_row[20]</td>";
								$data = $data . "<td align='center'>$name_row[21]</td>";
								$data = $data . "<td align='center'>$name_row[22]</td>";
								$data = $data . "<td align='center'>$name_row[23]</td>";
								$data = $data . "<td align='center'>$name_row[24]</td>";
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
				</div><!--end .accordion-section-content-->
			</div><!--end .accordion-section-->
		</div>
</div>
</div>
<!--
<div class="wrapper ">
	<div class="container">
		<div class="middle">
			<h3>Top 10 People called<h3>
		</td>
-->
<?php
oci_close($conn);
?>
</html>