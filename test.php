<?php


$data = '[{"cName":"Kapil_TL_GNW_IGATE","phNum":"+919967102312","callTypeCode":"Outgoing","callDate":"Thu Apr 09 20:06:10 GMT+05:30 2015","callDuration":"33"},{"cName":"Paul_GNW_IGATE","phNum":"+919892999062","callTypeCode":"Outgoing","callDate":"Thu Apr 09 20:08:04 GMT+05:30 2015","callDuration":"0"},{"cName":"Paul_GNW_IGATE","phNum":"+919892999062","callTypeCode":"Outgoing","callDate":"Thu Apr 09 20:08:19 GMT+05:30 2015","callDuration":"26"},{"cName":"Kapil_TL_GNW_IGATE","phNum":"+919967102312","callTypeCode":"Incoming","callDate":"Thu Apr 09 20:50:39 GMT+05:30 2015","callDuration":"166"},{"cName":"Mom Voda","phNum":"+919833034070","callTypeCode":"Incoming","callDate":"Fri Apr 10 07:51:06 GMT+05:30 2015","callDuration":"112"},{"cName":"Justdial","phNum":"8888888888","callTypeCode":"Outgoing","callDate":"Fri Apr 10 07:54:49 GMT+05:30 2015","callDuration":"64"},{"cName":"Prathamesh Bhilare","phNum":"9833658517","callTypeCode":"Outgoing","callDate":"Fri Apr 10 08:06:05 GMT+05:30 2015","callDuration":"0"},{"cName":"Prathamesh Bhilare","phNum":"9833658517","callTypeCode":"Outgoing","callDate":"Fri Apr 10 08:07:02 GMT+05:30 2015","callDuration":"0"},{"cName":"Prathamesh Bhilare","phNum":"9833658517","callTypeCode":"Outgoing","callDate":"Fri Apr 10 08:07:57 GMT+05:30 2015","callDuration":"0"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Missed","callDate":"Fri Apr 10 08:12:23 GMT+05:30 2015","callDuration":"0"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 08:12:39 GMT+05:30 2015","callDuration":"31"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Incoming","callDate":"Fri Apr 10 08:41:43 GMT+05:30 2015","callDuration":"33"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 08:42:27 GMT+05:30 2015","callDuration":"0"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 08:43:28 GMT+05:30 2015","callDuration":"0"},{"cName":"Prathamesh Bhilare","phNum":"+919833658517","callTypeCode":"Incoming","callDate":"Fri Apr 10 08:46:13 GMT+05:30 2015","callDuration":"331"},{"cName":"Mom Voda","phNum":"+919833034070","callTypeCode":"Incoming","callDate":"Fri Apr 10 08:53:27 GMT+05:30 2015","callDuration":"69"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 09:20:51 GMT+05:30 2015","callDuration":"0"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Incoming","callDate":"Fri Apr 10 12:36:42 GMT+05:30 2015","callDuration":"0"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 12:37:10 GMT+05:30 2015","callDuration":"22"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 12:37:48 GMT+05:30 2015","callDuration":"26"},{"cName":"Mom Voda","phNum":"+919833034070","callTypeCode":"Incoming","callDate":"Fri Apr 10 12:57:21 GMT+05:30 2015","callDuration":"56"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 13:17:42 GMT+05:30 2015","callDuration":"0"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 13:18:32 GMT+05:30 2015","callDuration":"23"},{"cName":"Mom Voda","phNum":"+919833034070","callTypeCode":"Outgoing","callDate":"Fri Apr 10 13:31:41 GMT+05:30 2015","callDuration":"0"},{"cName":"Subiya","phNum":"+918976447579","callTypeCode":"Outgoing","callDate":"Fri Apr 10 13:35:58 GMT+05:30 2015","callDuration":"21"},{"cName":"Mom Voda","phNum":"+919833034070","callTypeCode":"Outgoing","callDate":"Fri Apr 10 14:15:06 GMT+05:30 2015","callDuration":"9"},{"cName":"Prathamesh Bhilare","phNum":"+919833658517","callTypeCode":"Outgoing","callDate":"Fri Apr 10 14:15:48 GMT+05:30 2015","callDuration":"0"},{"cName":"Mom Voda","phNum":"+919833034070","callTypeCode":"Missed","callDate":"Fri Apr 10 14:15:52 GMT+05:30 2015","callDuration":"0"}]';


$json = json_decode($data);
if($json == null)
	echo "error";
echo "<pre>";
foreach ($json as $d)
		{
			echo $d->cName;
			echo $d->phNum;
			echo $d->callTypeCode;
			echo $d->callDate;
			echo $d->callDuration;
			
		}


echo "</pre>";
?>