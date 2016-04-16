select d_call_date,type,cnt,(select nvl(name,'Unknown') || ' - ' || nvl(pnumber,'Unknown') || ' - ' || GET_TIME(duration) from call_log where trunc(d_call_date) = a.d_call_date and type = a.type and duration <> '0') name,
(select listagg(nvl(name,'Unknown') || ' - ' || nvl(pnumber,'Unknown'),' ;') within group (order by 1) from call_log where trunc(d_call_date) = a.d_call_date and type = a.type and a.type = 'Missed') missed_caller
 from
(select trunc(d_call_date) d_call_date,type,count(*) cnt from call_log
where type in ('Incoming','Outgoing') 
and duration <> '0'
group by type,trunc(d_call_date)
UNION
select trunc(d_call_date),type,count(*) from call_log
where type in ('Missed') 
group by type,trunc(d_call_date)
) a
where cnt = 1
order by 1

 

select * from call_log
where trunc(d_call_date) = '12-Feb-2016'
and (type = 'Outgoing' and duration <> '0')
and type = 'Outgoing';