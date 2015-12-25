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
					echo "Session has ended <a class='show' href='index.php'>Click here</a> to login" ;
			}
			if($set == 1)
			{
				
		$pnumber = trim($_REQUEST['pnumber']);
		$mobile_op = '';
		$locality = '';
		
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
		
		$stmt = oci_parse($conn, "select nvl(max(mobile_op),'Unknown'),nvl(max(locality),'Unknown') from number_cat where pnumber like '%$pnumber%'");
		oci_execute($stmt);
		$name_row = oci_fetch_array($stmt);
		
		$mobile_op = str_replace('Number','',$name_row[0]); 
		$locality = str_replace('Number','',$name_row[1]); 
		
		
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
						<p class="number"><?=$mobile_op?> - <?=$locality?></p>
					</div>
				</div>
		<hr>
		<?php
		
		
		$stmt = oci_parse($conn, "SELECT TO_CHAR(d_call_date,'DD-MON-YYYY HH24:MI:SS') call_date,
		pnumber,type,GET_TIME(duration) from call_log where pnumber like '%$pnumber%' order by d_call_date desc");
		if(oci_execute($stmt))
		{
			while($name_row=oci_fetch_array($stmt))
			{
			?>
				<div class="main size20">
					<div class="content">
					<p class="name"><?=$name_row[0]?></p>
					<p class="number"><?=$name_row[1]?></p>
					<p class="type_<?=substr($name_row[2],0,1)?>"><?=$name_row[2]?></p>
					<p class="number"><?=$name_row[3]?></p>
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