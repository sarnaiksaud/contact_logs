create or replace view duration_range
as
select * from (select TO_CHAR(TRUNC(sum(duration)/3600),'FM9900') || ' HRS ' ||  TO_CHAR(TRUNC(MOD(sum(duration),3600)/60),'FM00') || ' MINS ' ||TO_CHAR(MOD(sum(duration),60),'FM00') || ' SECS' duration from call_log where d_call_date between (select max(start_date) from dates) and (select nvl(max(end_date),sysdate) from dates)) where EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1) ;

grant select on saud.duration_range to front_end;

create or replace  synonym front_end.duration_range for saud.duration_range ;