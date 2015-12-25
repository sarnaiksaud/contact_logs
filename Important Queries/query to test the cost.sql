select (select distinct name from call_log where pnumber = p.pnumber) name,
pnumber,
--GET_NUMBER_TYPE(pnumber),
sum(get_cost(duration,pnumber)) cost
 from call_log p
 where type = 'Outgoing'
 and lower(name) like '%igate%'
 and duration <> 0
 and GET_NUMBER_TYPE(pnumber) not in (0,1,4,6)
 and d_call_date between (select start_date from dates) and (select nvl(end_date,sysdate) from dates)
group by pnumber
order by name

select name,pnumber,d_call_date,duration,ceil(duration/60)
 from call_log
 where type = 'Outgoing'
 and pnumber = '+919867131702'
 and d_call_date between '01 sep 2015' and sysdate

