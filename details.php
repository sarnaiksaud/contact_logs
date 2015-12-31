<?php include_once('db.php');?>
<html>
	<head>
		<title>Detail</title>
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
			if($set == 1)
			{
				
		$pnumber = trim($_REQUEST['pnumber']);
		
		$stmt = oci_parse($conn, "select * from name_detail_min_max where pnumber like '%$pnumber%'");
		oci_execute($stmt);
		$name_row = oci_fetch_array($stmt);
		$set = 0;
		if(isset($name_row[0]) || isset($name_row[1]) || isset($name_row[2]) || isset($name_row[3]))
		{
			$set = 1;
		}
		$name = $name_row[0];
		$pnumber = $name_row[1];
		$min_call = '';
		$max_call = '';
		if(isset($name_row[2])) $min_call = 'First Call : ' . $name_row[2]; 
		if(isset($name_row[3])) $max_call = 'Last Call : ' . $name_row[3];
		
		if($set == 1)
		{
			
		?>
		
				<div class="main size20">
					<div class="picture"><span><?=substr($name_row[0],0,1)?></span></div>
					<div class="content">
						<p class="name"><?=$name?></p>
						<p class="number"><?=$pnumber?></p>
						<p class="number"><?=$min_call?></p>
						<p class="number"><?=$max_call?></p>
					</div>
				</div>
		<hr>
		<?php
		
		
		$stmt = oci_parse($conn, "SELECT call_type,count,time from statistics_detail where pnumber like '%$pnumber%'");
		if(oci_execute($stmt))
		{
			while($name_row=oci_fetch_array($stmt))
			{
			?>
				<div class="main size18">
					<div class="content">
					<p class="name"><?=$name_row[0]?></p>
					<p class="number"><?=$name_row[1]?>
					<?php if ($name_row[1] > 1) echo "calls"; else echo "call"; ?>
					</p>
					<p class="number"><?=$name_row[2]?></p>
					</div>
				</div>
			<?php
			}
		}
		}
			}
		?>
	</body>
</html>