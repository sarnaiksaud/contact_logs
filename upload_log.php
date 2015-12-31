<?php include_once('db.php');?>
<html>
	<head>
		<title>Upload log</title>
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
				echo "<table border=1>";
				echo "<tr>";
				$stmt = oci_parse($conn, "SELECT count,uploaded_when from upload_log order by timestamp desc");
				if(oci_execute($stmt))
				{
					$ncols = oci_num_fields($stmt);
					echo "<tr>\n";
					for ($i = 1; $i <= $ncols; ++$i) {
						$colname = oci_field_name($stmt, $i);
						echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
					}
					echo "</tr>";
				}
				while($name_row=oci_fetch_array($stmt))
				{
						echo "<tr>";
						for ($i=0;$i<$ncols;$i++)
						{
							echo "<td align='center'>$name_row[$i]</td>";
						}
						echo "</tr>";
						//echo "<td>$name_row[1]</td>";
						//echo "<td>$name_row[2]</td></tr>";
				}
				echo "</table>";
			}
			?>
	</body>
	</html>