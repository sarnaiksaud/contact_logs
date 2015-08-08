select * from top_10_calls
where type = 'Incoming'

select * from user_views

export start_date = '01-Aug-2015'

create table dates (start_date date, end_date date);

insert into dates values ('01-Aug-2015',SYSDATE);

create or replace view top_10_calls
as
select coalesce(name,pnumber) name,pnumber,ROUND(sum(duration)/60,2) total_duration,count(*) total_count,type 
from call_log
where duration <> 0
and TRUNC(d_call_date) between (select NVL(MAX(start_date),'01-Jan-2015') from dates) and (select NVL(MAX(end_date),sysdate) from dates)  
group by pnumber,name,type


select name,pnumber,ROUND(sum(duration)/60,2) total_duration,count(*) total_count,type from call_log
where pnumber in (
select pnumber from (
select pnumber 
from call_log
group by pnumber
order by sum(duration) desc)
where rownum <= 10
)
--and lower(type) = 'incoming'
and lower(type) <> 'missed'
group by pnumber,name,type
order by sum(duration) desc



select type,sum(duration),count(*) from call_log
where name = 'Tasmine'
group by type;