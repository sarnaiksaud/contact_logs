<html>
<head>
	<title>Call Logs One Click</title>
	<link rel="stylesheet" type="text/css" href="css/one.css">
</head>
<body>
<?php include_once('db.php'); ?>
<div class="head">
	<div class="first-row">
		<div class="first-div block">
			<span>Numbers Subscribed</span>
			<hr>
			<div class="innerblock">		
				<table class="reduce">
				<tr><th>Name</th><th class="reduce">Type</th><th>Duration</th><th>Time</th></tr>
				<?php
					
					$sql = "select
nvl2(name,name || ' [' || pnumber || ']',pnumber) name,type,duration,TO_CHAR(d_call_date,'DD-MON-RRRR HH24:MI:SS') call_time from call_log
					where log_id in (
						select max(log_id) from call_log s
						where
						duration <> '0' 
						and exists (
							select 1 from call_subscribed where nvl(s.name,'$$') = nvl(name,'$$') and s.pnumber = pnumber
							)
							group by s.name,s.pnumber
						)
						order by to_number(log_id) desc";
					$stmt = oci_parse($conn, $sql);
					
					if(oci_execute($stmt))
					{
						while ($name_row = oci_fetch_array($stmt))
						echo "<tr><td>$name_row[0]</td><td>$name_row[1]</td><td>$name_row[2]</td><td>$name_row[3]</td></tr>";
					}
					
				?>
				</table>
			</div>
		</div>
		<div class="second-div block">
			<span>Call's</span>
			<hr>
			<div class="innerblock">
				<table class="reduce">
				<tr><th>Person</th><th class="reduce">Total Calls</th></tr>
				<?php
					$sql = "select name, cnt
						from (select dense_rank() over (ORDER BY count(*) DESC) rnk,nvl(name,pnumber) name,count(*) cnt from call_log
						group by nvl(name,pnumber)
						)
						where rnk <= 10
						order by rnk";
					$stmt = oci_parse($conn, $sql);
					if(oci_execute($stmt))
					{
						while ($name_row = oci_fetch_array($stmt))
						echo "<tr><td>$name_row[0]</td><td>$name_row[1]</td></tr>";
					}
				?>
				</table>
			</div>
		</div>
		<div class="third-div block">
			<span>Upload Logs</span>
			<hr>
			<div class="innerblock">
				<table>
				<tr><th>Count</th><th>Uploaded when</th></tr>
				<?php
					$sql = "select count,to_char(timestamp,'dd-Mon-RR') uploaded_when
							from (select dense_rank() over (ORDER BY timestamp DESC) rnk,count,timestamp from upload_log
							where count <> 0)
							where rnk <= 10
							order by rnk";
					$stmt = oci_parse($conn, $sql);
					if(oci_execute($stmt))
					{
						while ($name_row = oci_fetch_array($stmt))
						echo "<tr><td>$name_row[0]</td><td>$name_row[1]</td></tr>";
					}
				?>
				</table>
			</div>
		</div>
	</div>
	<br>
	<div class="second-row">
		<div class="first-div block">
			<span>Stats</span>
			<hr>
			<div class="innerblock">
				<table>
				<tr><th>Person</th><th>Call Type</th><th>Count</th></tr>
				<?php
					$sql = "select person,type, lower(GET_TIME(duration))
							from
							(
								select dense_rank() over (ORDER BY log_id DESC) rnk,nvl(name,pnumber) person,type,duration
								from call_log
								where duration <> '0'
								and duration > (select int_value
								from CALL_REFERENCE
								where table_name = 'CALL_THRESHOLD'
								and type = 'MIN')
								/*
								select dense_rank() over (ORDER BY sum(to_number(duration)) DESC) rnk,nvl(name,pnumber) person,type
								,sum(to_number(duration)) duration from
								call_log 
								where type = 'Outgoing'
								group by nvl(name,pnumber),type
								having sum(to_number(duration)) > 100
								*/
							)
							where rnk <= 5
							order by rnk";
					$stmt = oci_parse($conn, $sql);
					if(oci_execute($stmt))
					{
						while ($name_row = oci_fetch_array($stmt))
						echo "<tr class='new'><td>$name_row[0]</td><td>$name_row[1]</td><td>$name_row[2]</td><tr>";
					}
				?>
				</table>
			</div>
		</div>
		<div class="second-div block">
			<span>Under Development</span>
			<hr>
			<div class="innerblock">
			Under Development
			<!--
				<table>
				<?php
					/*
					$sql = "select address person,account_no,amt,debit_end date_of_trans,mode_of_trans,balance from get_bank_sms_details";
					$stmt = oci_parse($conn, $sql);
					if(oci_execute($stmt))
					{
						$ncols = oci_num_fields($stmt);
						echo "<tr>\n";
						for ($i = 1; $i <= $ncols; ++$i) {
							$colname = oci_field_name($stmt, $i);
							echo "  <th>".htmlentities($colname, ENT_QUOTES)."</th>\n";
						}
						echo "</tr>";
						while ($name_row = oci_fetch_array($stmt))
						{
							for ($i=0;$i<$ncols;$i++)
							{
								echo "<td>$name_row[$i]</td>";
							}
							echo "</tr>";
						}
					}
					*/
				?>
				</table>
				-->
			</div>
		</div>
	</div>
</div>
</body>