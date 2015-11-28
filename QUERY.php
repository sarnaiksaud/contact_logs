<html>
<head>
<title>Statictics</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
$conn = oci_connect('saud', 'saud', 'localhost') or die ("Error connection to db");


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

$q = "select name,trunc(d_call_date) day,CEIL(sum(duration)/60) || ' minutes' as time, count(*) count,Type
from call_log
where UPPER(name) like UPPER('%')
and duration <> 0
and UPPER(type) = 'OUTGOING'
group by trunc(d_call_date),name,type
--having CEIL(sum(duration)/60) >= 50
--order by trunc(d_call_date) desc,to_number(CEIL(sum(duration)/60)) desc
order by to_number(CEIL(sum(duration)/60)) desc,trunc(d_call_date) desc";


?>
<form>
	<table>
	<tr><td colspan=3>
		<textarea name="query" rows="20" cols="100%">
<?php IF (isset($_REQUEST['query'])) 
$q = $_REQUEST['query'];

echo $q;?>
		</textarea>
	</td></tr>
	<tr><td><input type="submit"></td><td><input type="reset"></td></tr>
	</table>
	<hr>
</form>
<?php
	
	try
	{
		//echo $_REQUEST['query'];
		$q_1 = "SELECT * FROM (".$q.") WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1)";
		$stmt = oci_parse($conn, $q_1);
		
		$cnt = substr_count($q,',',0,strpos($q,'from'))+1;
		
		$subs = substr($q,strpos($q_1,' '),strpos($q,'from')-strpos($q,' '));
		$sub_a = explode(',',$subs);
		
		//echo "substr : $subs";
		//print_r($sub_a);
		

		if(oci_execute($stmt))
		{
			
			echo "<table border=1>";
			echo "<tr>";
			/*
			for ($i=0;$i<$cnt;$i++)
			{
				//echo "<th>".strtoupper($sub_a[$i])."</th>";
				echo "<th>".strtoupper(substr($sub_a[$i], strrpos($sub_a[$i], ' ')))."</th>";
			}
			*/
			$ncols = oci_num_fields($stmt);
			echo "<tr>\n";
			for ($i = 1; $i <= $ncols; ++$i) {
				$colname = oci_field_name($stmt, $i);
				echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
			}
			echo "</tr>";
			
			
			
			while($name_row=oci_fetch_array($stmt))
			{
					echo "<tr>";
					for ($i=0;$i<$ncols;$i++)
					{
						echo "<td>$name_row[$i]</td>";
					}
					echo "</tr>";
					//echo "<td>$name_row[1]</td>";
					//echo "<td>$name_row[2]</td></tr>";
			}
			echo "</table>";
			$result = "success";
		}
		else
		{
			$result = "error";
		}
	}
	catch(Exception $exception)
	{
		$result = "error";
	}
	
	$stmt1 = oci_parse($conn,"begin to_log(:q,:status); end;");
	oci_bind_by_name($stmt1, "q", $q);
	oci_bind_by_name($stmt1, "status", $result);
	oci_execute($stmt1);
	
	
			}	
?>

</body>
</html>
