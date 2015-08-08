select * from (
    select name,pnumber,CEIL(sum(duration)/60) total_duration,count(*) total_count,type from call_log
    where pnumber in (
select pnumber from (
select pnumber 
from call_log
group by pnumber
order by sum(duration) desc)
)
and lower(type) <> 'missed'
group by pnumber,name,type
order by CEIL(sum(duration)/60) desc
)
where lower(type) = 'incoming'
and total_duration <> 0
