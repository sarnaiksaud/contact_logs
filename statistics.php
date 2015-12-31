<?php include_once('db.php');?>
<html>
	<head>
		<title>Statistics</title>
		<link rel="stylesheet" type="text/css" href="css/block.css">
	</head>
	<body>
		<?php
			$set = 0;
			$stmt = oci_parse($conn, "SELECT * from show_data");
			if(oci_execute($stmt))
			{
				$name_row = oci_fetch_array($stmt);
				if(isset($name_row[0])) $set = 1; 
				else
					echo "Session has ended <a class='show' href='login_form.php'>Click here</a> to login" ;
			}
		
			$stmt = oci_parse($conn, "SELECT TO_CHAR(max(start_date),'DD-Mon-YYYY'),TO_CHAR(nvl(max(end_date),sysdate),'DD-Mon-YYYY') from dates");
			if(oci_execute($stmt))
			{
				$name_row = oci_fetch_array($stmt);
				$start_date = $name_row[0];
				$end_date = $name_row[1];
			}


			$stmt = oci_parse($conn, "select * from count_range");
			$stmt1 = oci_parse($conn, "select * from duration_range");
			
			if(oci_execute($stmt))
			{
				$name_row = oci_fetch_array($stmt);
				$allcount = $name_row[0];
			}
			if(oci_execute($stmt1))
			{
				$name_row = oci_fetch_array($stmt1);
				$total_duration = $name_row[0];
			}

			if($set == 1)
			{
		?>
		<h1>ALL CALLS<h5>(<?=$start_date?> to <?=$end_date?>)</h35></h1>
		<br>
		Total: <?=$allcount?> CALLS, <?=$total_duration?>
		<hr>
		<?php
		$stmt = oci_parse($conn, "SELECT nvl(name,'Unkwown'),pnumber from statistics");
		if(oci_execute($stmt))
		{
			while($name_row=oci_fetch_array($stmt))
			{
			?>
				<a class="noshow" href="details.php?pnumber=<?=htmlentities ($name_row[1])?>">
				<div class="main size14">
					<div class="picture"><span><?=substr($name_row[0],0,1)?></span></div>
					<div class="content">
					<p class="name"><?=$name_row[0]?></p>
					<p class="number"><?=$name_row[1]?></p>
					</div>
				</div>
				</a>
			<?php
			}
		}
			}
		?>
	</body>
</html>