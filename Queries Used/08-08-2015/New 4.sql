select * from 
(
select name,pnumber,ROUND(sum(duration)/60,2) total_duration,count(*) total_count,type 
from call_log
where duration <> 0
and lower(type) <> 'missed'
group by pnumber,name,type
order by sum(duration) desc
)
where rownum <= 10
--and lower(type) = 'incoming'
and lower(type) = 'incoming'