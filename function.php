<?php
function show_data($conn,$myArray,$mdata)
{
	$name  = "";
	$type  = "";
	$number  = "";
	$from  = "";
	$to  = "";
	$phone  = "";
	$callcount  = "";
	$shownum  = "";
	
	if(isset($myArray['shownum']))
			$shownum  = $myArray['shownum'];
	else
		if($mdata == 1)
			$shownum = "on";
		
	if(isset($myArray['name']))
	{
		if($myArray['name'] != "")
			$name = "%".strtolower($myArray['name'])."%";
	}	
	
	if(isset($myArray['type']))
		$type = strtolower($myArray['type']);
	
	if($type == 'all')
		$type = '';
	
	if(isset($myArray['number']))
	{
		if($myArray['number'] != "")
			$number = "%".strtolower($myArray['number'])."%";
	}
	
	if(isset($myArray['from']))
		$fromD = strtolower($myArray['from']);
	else
		$fromD = '2015-01-01';
	
	if(isset($myArray['to']))
		$toD = strtolower($myArray['to']);
	else
		$toD = date("Y-m-d");
	
	if(isset($myArray['phone']))
		$phone = strtolower($myArray['phone']);
	
	if($phone == 'all')
		$phone = '';
	
	if(isset($myArray['callcount']))
		$callcount = $myArray['callcount'];
	else
		$callcount = 2;
	
	
	
	$fromD = date('d-M-Y',strtotime($fromD));
	$toD = date('d-M-Y',strtotime($toD));
	
	$where = array();
	
	$query = 'SELECT NVL(name,\'Unknown\'),pnumber,type,count(*) as "Total Calls Counts",sum(duration),phone FROM call_log ';
	
	if($type != "") $where[] = ' lower(type) in (:type) ';
		
	if($number != "") $where[] = " lower(pnumber) like :p_pnumber ";
	
	if($name != "") $where[] = " lower(name) like :name ";
	
	if($fromD != "" AND $toD != "")
			$where[] = " TRUNC(TO_DATE(SUBSTR(call_date,5,INSTR(call_date,'GMT', 1)-6),'Mon DD HH24:MI:SS')) between :fromDate AND :toDate ";
		
	if($phone != "")
			$where[] = ' lower(phone) = :phone_val ';
		
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
		oci_bind_by_name($stmt, "phone_val", $phone);
	
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
			{
				if($mdata == 1)
				{		
					$label = $label . "</td><td class='wborder'> [" .$name_row[1] . "]";
				}
				else
				{
					$label = $label . ' [' .$name_row[1] . ']';
				}
			}
				
			if($mdata == 1)
			{
				if($type == "")
					$label = $label . "</td><td class='wborder'> (".ucwords($name_row[2]).")";	
				if($phone == "")
					$label = $label . " </td><td class='wborder'>("
				.ucwords(substr($name_row[5],0,strpos($name_row[5],'/'))).")";
				
				$name_array[] = array("y"=>$name_row[3],"indexLabel"=>$label);
			}
			else
			{
				if($type == "")
					$label = $label . " (".strtoupper(substr($name_row[2],0,1)).")";	
				if($phone == "")
					$label = $label . " (".strtoupper(substr($name_row[5],0,1)).")";
			
			$name_array[] = array("y"=>$name_row[3],"indexLabel"=>$label);
			}
		}
	}
	if($mdata == 0)
	{
		echo "<script>";
		
		echo "var cnt = '".$cnt."';";
		
		if($phone != "")
			$phone_name = substr($phone,0,strpos($phone,'/',1));
		
		if($phone != "")
			echo "var title = '$type calls between $fromD and $toD on " . ucfirst($phone_name) . "' ;";
		else
			echo "var title = '$type calls between $fromD and $toD' ;";

		echo "var names = " . json_encode($name_array). ";";
		echo "var count = " . json_encode($call_count). ";";
		echo "</script>";
	}
	else
	{
		echo "<table>";
			echo "<tr><th class='wborder'>Count</th><th class='wborder'>Name</th><th class='wborder'>Number</th><th class='wborder'>Type</th><th class='wborder'>Phone</th></tr>";
			foreach($name_array as $name)
			{
				echo "<tr>";
				foreach($name as $data){
					echo "<td class='wborder'>$data</td>";
				}
				echo "</tr>";
			}
		echo "</table>";
	}


	
}
?>