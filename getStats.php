<html>
<head>
</head>
<body>
<?php
	$conn = oci_connect('Saud', 'saud', 'localhost') or die ("Error connection to db");

	$name  = "";
	$type  = "";
	$number  = "";
	$from  = "";
	$to  = "";
	$phone  = "";
	$callcount  = "";
	$shownum  = "";
	
	if(isset($_REQUEST['shownum']))
			$shownum  = $_REQUEST['shownum'];
		
	if(isset($_REQUEST['name']))
	{
		if($_REQUEST['name'] != "")
			$name = "%".strtolower($_REQUEST['name'])."%";
	}	
	
	if(isset($_REQUEST['type']))
		$type = strtolower($_REQUEST['type']);
	
	if($type == 'all')
		$type = '';
	
	if(isset($_REQUEST['number']))
	{
		if($_REQUEST['number'] != "")
			$number = "%".strtolower($_REQUEST['number'])."%";
	}
	
	if(isset($_REQUEST['from']))
		$fromD = strtolower($_REQUEST['from']);
	else
		$fromD = '2015-01-01';
	
	if(isset($_REQUEST['to']))
		$toD = strtolower($_REQUEST['to']);
	else
		$toD = date("Y-m-d");
	
	if(isset($_REQUEST['phone']))
		$phone = strtolower($_REQUEST['phone']);
	
	if($phone == 'all')
		$phone = '';
	
	if(isset($_REQUEST['callcount']))
		$callcount = $_REQUEST['callcount'];
	else
		$callcount = 2;
	
	
	
	$fromD = date('d-M-Y',strtotime($fromD));
	$toD = date('d-M-Y',strtotime($toD));
	
	//echo $fromD . "<br>";
	//echo $toD . "<br>";
	
	$where = array();
	
	$query = 'SELECT name,pnumber,type,count(*) as "Total Calls Counts",sum(duration),phone FROM call_log ';
	
	if($type != "") $where[] = ' lower(type) in (:type) ';
		
	if($number != "") $where[] = " lower(pnumber) like :p_pnumber ";
	
	if($name != "") $where[] = " lower(name) like :name ";
	
	if($fromD != "" AND $toD != "")
			$where[] = " TRUNC(TO_DATE(SUBSTR(call_date,5,INSTR(call_date,'GMT', 1)-6),'Mon DD HH24:MI:SS')) between :fromDate AND :toDate ";
		
	if($phone != "")
			$where[] = ' lower(phone) like :phone_val ';
		
	$query = $query . "WHERE " . implode('AND ', $where);
	
	$query = $query . ' group by pnumber,name,type,phone ';
	$query = $query . ' having count(*) > :callcount ';
	$query = $query . ' order by count(*) desc ';
	
	//echo $query;
	
	$stmt = oci_parse($conn, $query);
	
	if($type != "")
		oci_bind_by_name($stmt, "type", $type);
	
	if($name != "")
		oci_bind_by_name($stmt, "name", $name);
	if($number != "")
		oci_bind_by_name($stmt, "p_pnumber", $number);
	
	if($fromD != "" AND $toD != "")
	{
		oci_bind_by_name($stmt, "fromDate", $fromD);
		oci_bind_by_name($stmt, "toDate", $toD);
	}
	if($phone != "")
	{
		$phone = '%'.$phone.'%';
		oci_bind_by_name($stmt, "phone_val", $phone);
	}
	
	oci_bind_by_name($stmt, "callcount", $callcount);
	
	if(oci_execute($stmt))
	{
		$cnt = 0;
		$name_array = array();
		$call_count = array();
		
		while($name_row=oci_fetch_array($stmt))
		{
			$cnt++;
			if($name_row[0] == '')
				$name_row[0] = "Unknown";
			
			$label = $name_row[0];
			if($shownum == "on")
					$label = $label . ' [' .$name_row[1] . ']';
				
			if($type == "")
				$label = $label . " (".strtoupper(substr($name_row[2],0,1)).")";	
			if($phone == "")
				$label = $label . " (".strtoupper(substr($name_row[5],0,1)).")";
			
			$name_array[] = array("y"=>$name_row[3],"indexLabel"=>$label);
		}
	}
	echo "<script>";
	
	echo "var cnt = '".$cnt."';";
	
	if($phone != "")
		$phone_name = substr($phone,0,strpos($phone,'/',1));
	
	if($phone != "")
		echo "var title = '$type calls between $fromD and $toD on " . ucfirst($phone_name) . "' ;";
	else
		echo "var title = '$type calls between $fromD and $toD' ;";
	
	echo "var names = " . json_encode($name_array). ";";
	echo "</script>";
	
	echo json_encode($name_array);
?>

</body>
</html>
