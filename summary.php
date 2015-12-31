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

		$set = 0;
			$stmt = oci_parse($conn, "SELECT * from show_data");
			if(oci_execute($stmt))
			{
				$name_row = oci_fetch_array($stmt);
				if(isset($name_row[0])) $set = 1; 
				else
					echo "Session has ended <a class='show' href='login_form.php'>Click here</a> to login" ;
			}
			if($set == 1)
			{
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
				<!--
				<td class="ndata"><h3>Top 10 longest Outgoing calls</h3></td>
				-->
				<td class="ndata"><h3>Top 10 people called (duration)</h3></td> <!-- added 10-10-2015 -->
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
				<a class="accordion-section-title" href="#accordion-3">Hour Wise Analysis</a>
				<div id="accordion-3" class="accordion-section-content">
					<?php
						$query = "select * from hour_wise_analysis";
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
		<div class="accordion-section">
				<a class="accordion-section-title" href="#accordion-4">Day Wise Analysis</a>
				<div id="accordion-4" class="accordion-section-content">
					<?php
						$query = "select * from day_wise_analysis";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal' align='center'>";
							$data = $data . "<tr>";
							$data = $data . "<th>Call Type</th>";
							$data = $data . "<th>D 01</th>";
							$data = $data . "<th>D 02</th>";
							$data = $data . "<th>D 03</th>";
							$data = $data . "<th>D 04</th>";
							$data = $data . "<th>D 05</th>";
							$data = $data . "<th>D 06</th>";
							$data = $data . "<th>D 07</th>";
							$data = $data . "<th>D 08</th>";
							$data = $data . "<th>D 09</th>";
							$data = $data . "<th>D 10</th>";
							$data = $data . "<th>D 11</th>";
							$data = $data . "<th>D 12</th>";
							$data = $data . "<th>D 13</th>";
							$data = $data . "<th>D 14</th>";
							$data = $data . "<th>D 15</th>";
							$data = $data . "<th>D 16</th>";
							$data = $data . "<th>D 17</th>";
							$data = $data . "<th>D 18</th>";
							$data = $data . "<th>D 19</th>";
							$data = $data . "<th>D 20</th>";
							$data = $data . "<th>D 21</th>";
							$data = $data . "<th>D 22</th>";
							$data = $data . "<th>D 23</th>";
							$data = $data . "<th>D 24</th>";
							$data = $data . "<th>D 25</th>";
							$data = $data . "<th>D 26</th>";
							$data = $data . "<th>D 27</th>";
							$data = $data . "<th>D 28</th>";
							$data = $data . "<th>D 29</th>";
							$data = $data . "<th>D 30</th>";
							$data = $data . "<th>D 31</th>";
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
								$data = $data . "<td align='center'>$name_row[25]</td>";
								$data = $data . "<td align='center'>$name_row[26]</td>";
								$data = $data . "<td align='center'>$name_row[27]</td>";
								$data = $data . "<td align='center'>$name_row[28]</td>";
								$data = $data . "<td align='center'>$name_row[29]</td>";
								$data = $data . "<td align='center'>$name_row[30]</td>";
								$data = $data . "<td align='center'>$name_row[31]</td>";
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
			</div>
		<div class="accordion-section">
				<a class="accordion-section-title" href="#accordion-5">Week wise Analysis</a>
				<div id="accordion-5" class="accordion-section-content">
					<?php
						$query = "select * from week_wise_analysis";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal' align='center'>";
							$data = $data . "<tr>";
							$data = $data . "<th>Call Type</th>";
							$data = $data . "<th>Monday</th>";
							$data = $data . "<th>Tuesday</th>";
							$data = $data . "<th>Wednesday</th>";
							$data = $data . "<th>Thursday</th>";
							$data = $data . "<th>Friday</th>";
							$data = $data . "<th>Saturday</th>";
							$data = $data . "<th>Sunday</th>";
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
			</div>	
			<div class="accordion-section">
				<a class="accordion-section-title" href="#accordion-6">Month Wise Analysis</a>
				<div id="accordion-6" class="accordion-section-content">
					<?php
						$query = "select * from month_wise_analysis";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal' align='center'>";
							$data = $data . "<tr>";
							$data = $data . "<th>Call Type</th>";
							$data = $data . "<th>Jan</th>";
							$data = $data . "<th>Feb</th>";
							$data = $data . "<th>Mar</th>";
							$data = $data . "<th>Apr</th>";
							$data = $data . "<th>May</th>";
							$data = $data . "<th>Jun</th>";
							$data = $data . "<th>Jul</th>";
							$data = $data . "<th>Aug</th>";
							$data = $data . "<th>Sep</th>";
							$data = $data . "<th>Oct</th>";
							$data = $data . "<th>Nov</th>";
							$data = $data . "<th>Dec</th>";
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
			</div>
			<div class="accordion-section">
				<a class="accordion-section-title" href="#accordion-7">Year Wise Analysis</a>
				<div id="accordion-7" class="accordion-section-content">
					<?php
						$query = "select * from Year_wise_analysis";
						$stmt = oci_parse($conn, $query);
						if(oci_execute($stmt))
						{
							$data = "";
							$count = 0;
							
							$data = $data . "<table class='internal' align='center'>";
							$data = $data . "<tr>";
							$data = $data . "<th>Call Type</th>";
							$data = $data . "<th>2015</th>";
							$data = $data . "<th>2016</th>";
							$data = $data . "<th>2017</th>";
							$data = $data . "</tr>";
							while($name_row=oci_fetch_array($stmt))
							{
								$data = $data . "<tr>";
								$data = $data . "<td align='center'>$name_row[0]</td>";
								$data = $data . "<td align='center'>$name_row[1]</td>";
								$data = $data . "<td align='center'>$name_row[2]</td>";
								$data = $data . "<td align='center'>$name_row[3]</td>";
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
			</div>
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
			}
oci_close($conn);
?>
</html>