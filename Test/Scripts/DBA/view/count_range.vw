create or replace view count_range
as
SELECT count(*) count FROM call_log 
where d_call_date between (select max(start_date) from dates) and (select nvl(max(end_date),sysdate) from dates) 
and EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);

select * from count_range

grant select on saud.count_range to front_end;

create or replace  synonym front_end.count_range for saud.count_range ;

