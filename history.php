<html>
    
    <head>
        <title>History</title>
        <link rel="stylesheet" type="text/css" href="css/block.css">
    </head>
    
    <body>
	
			<?php
			include_once( 'db.php'); 
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
        	<h1>All</h1>

        <?php 
		$stmt=oci_parse($conn, "select * from all_details_sorted"); 
		if(oci_execute($stmt)) 
		{ while($name_row=oci_fetch_array($stmt)) 
			{ ?>	
		<a class="noshow" href="details.php?pnumber=<?=htmlentities ($name_row[1])?>">
			<div class="main size20">
				<div class="picture"><span><?=substr($name_row[0],0,1)?></span></div>
				<div class="content">
				<p class="name"><?=$name_row[0]?></p>
				<p class="number"><?=$name_row[1]?></p>
				<p class="type_<?=substr($name_row[2],0,1)?>"><?=$name_row[2]?></p>
				<p class="time"><?=$name_row[3]?></p>
				</div>
			</div>
			</a>

			<?php } } }?>
        <!--</table>-->
    </body>

</html>