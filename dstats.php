<html>
<head>
<title>Tabular Statictics</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
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

$stmt = oci_parse($conn, "select distinct phone,INITCAP(TRIM(SUBSTR(phone,0,INSTR(phone,'/', 1)-1))) from call_log");
oci_execute($stmt);
$text = "";
while($phone=oci_fetch_array($stmt))
{
	$text = $text . "<option value='".$phone[0]."'>".$phone[1]."</phone>";
}
	$name  = "";
	$type  = "";
	$number  = "";
	$fromD  = date("Y-m-01");
	$toD = date("Y-m-d");
	$phone  = "";
	$callcount = 2;
	$shownum  = "on";

if(isset($_REQUEST['shownum']))
		$shownum  = $_REQUEST['shownum'];
	

if(isset($_REQUEST['from']))
	$fromD = strtolower($_REQUEST['from']);

if(isset($_REQUEST['to']))
	$toD = strtolower($_REQUEST['to']);


if(isset($_REQUEST['callcount']))
	$callcount = $_REQUEST['callcount'];



?>
<form>
	<table>
	<tr><td>Name</td><td><input name="name" type="text"></td></tr>
	<tr><td>Number</td><td><input name="number" type="text"></td></tr>
	<tr><td>Type</td>
	<td><select name='type'>
				<option>All</option>
				<option>Incoming</option>
				<option>Outgoing</option>
				<option>Missed</option>
			</select>
	</td></tr>
	<tr><td>Date range</td>
	<td>
	From 
		<input name="from" type="date" value="<?=$fromD?>">
	To
		<input name="to" type="date" value="<?=$toD?>">
	</td></tr>
	<tr><td>Phone</td>
	<td><select name='phone'>
				<option>All</option>
				<?php echo $text; ?>
			</select>
	</td></tr>
	<tr><td>Calls more than</td><td><input name="callcount" value='<?=$callcount?>' type="text"></td></tr>
	<tr><td>Show Numbers</td><td><input type="checkbox" name="shownum" />
	<tr colspan=2><td><input type="submit"></td></tr>
	<tr colspan=2><td><button onclick="openWindow()">Show Graphical Data</button></td></tr>
	</table>
	<hr>
</form>
<?php
	include 'function.php';
	show_data($conn,$_REQUEST,1);
			}
?>
<script>
	function openWindow()
	{
		window.open('stats.php');
	}
</script>
</body>
</html>
