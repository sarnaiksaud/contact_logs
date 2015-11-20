select pnumber,length(pnumber),
REGEXP_COUNT(pnumber,'\+91\d{10}') "MOBILE NF",
REGEXP_COUNT(pnumber,'0\d{10}') "MOBILE F",
--REGEXP_SUBSTR(pnumber,'0\d{10}'),
--decode(length(SUBSTR(REGEXP_SUBSTR(pnumber,'0\d{10}'),2)),10,'+91'||SUBSTR(REGEXP_SUBSTR(pnumber,'0\d{10}'),2),pnumber) formatted
case when length(SUBSTR(REGEXP_SUBSTR(pnumber,'0\d{10}'),2)) = 10 then '+91'||SUBSTR(REGEXP_SUBSTR(pnumber,'0\d{10}'),2)
when   length(pnumber) = 8 then '+9122'||pnumber 
else pnumber end formatted
from 
(select distinct pnumber from call_log)
--where length(pnumber) = 11
where length(pnumber) <= 11