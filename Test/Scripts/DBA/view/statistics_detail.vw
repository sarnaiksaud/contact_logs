create or replace view statistics_detail as
select "NAME","PNUMBER","TIME_IN_SEC","CALL_TYPE","COUNT","TIME" from 
(select 0 sort_order,(select distinct name from call_log where pnumber = c.pnumber) name, 
pnumber,
sum(duration) time_in_sec,
'Total' call_type,
(select count(1) from call_log where pnumber = c.pnumber and d_call_date between (select max(start_date) from dates) and (select nvl(max(end_date),sysdate) from dates)) count,
decode(sum(duration),0,null,TO_CHAR(TRUNC(sum(duration)/3600),'FM9900') || ' HRS ' || 
    TO_CHAR(TRUNC(MOD(sum(duration),3600)/60),'FM00') || ' MINS ' ||
        TO_CHAR(MOD(sum(duration),60),'FM00') || ' SECS') time 
from call_log c
where d_call_date between (select max(start_date) from dates) and (select nvl(max(end_date),sysdate) from dates) 
group by pnumber
UNION ALL
select
decode (lower(type),'incoming',2,'outgoing',1,'missed',3,4) sort_order,  
(select distinct name from call_log where pnumber = c.pnumber) name, 
pnumber,
sum(duration) time_in_sec,
type,
(select count(1) from call_log where pnumber = c.pnumber and type = c.type and d_call_date between (select max(start_date) from dates) and (select nvl(max(end_date),sysdate) from dates) ) count,
decode(sum(duration),0,null,TO_CHAR(TRUNC(sum(duration)/3600),'FM9900') || ' HRS ' || 
    TO_CHAR(TRUNC(MOD(sum(duration),3600)/60),'FM00') || ' MINS ' ||
        TO_CHAR(MOD(sum(duration),60),'FM00') || ' SECS') time 
from call_log c
where d_call_date between (select max(start_date) from dates) and (select nvl(max(end_date),sysdate) from dates) 
group by pnumber,type
order by 3 desc,1 
)
where EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);

--select * from statistics_detail;

grant select on saud.statistics_detail to front_end ;

create or replace  synonym front_end.statistics_detail for saud.statistics_detail;