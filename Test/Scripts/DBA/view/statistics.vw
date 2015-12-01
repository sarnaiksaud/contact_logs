create or replace view statistics 
as
select --(select distinct name from call_log where pnumber = c.pnumber) name,  --commented on 01-12-2015
initcap((select distinct lower(name) from call_log where pnumber = c.pnumber)) name,  --added on 01-12-2015
pnumber,
sum(duration) time_in_sec,
decode(sum(duration),0,null,TO_CHAR(TRUNC(sum(duration)/3600),'FM9900') || ' HRS ' || 
    TO_CHAR(TRUNC(MOD(sum(duration),3600)/60),'FM00') || ' MINS ' ||
        TO_CHAR(MOD(sum(duration),60),'FM00') || ' SECS') time 
from call_log c
where d_call_date between (select max(start_date) from dates) and (select nvl(max(end_date),sysdate) from dates)
and EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1)
group by pnumber
order by 3 desc;

grant select on saud.statistics to front_end;

create or replace synonym front_end.statistics for saud.statistics;

