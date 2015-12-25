CREATE OR REPLACE function SAUD.get_time(p_duration number)
return varchar2
as
return_text varchar2(50);
begin
select decode(sum(p_duration),0,null,TO_CHAR(TRUNC(sum(p_duration)/3600),'FM9900') || ' HRS ' || 
    TO_CHAR(TRUNC(MOD(sum(p_duration),3600)/60),'FM00') || ' MINS ' ||
        TO_CHAR(MOD(sum(p_duration),60),'FM00') || ' SECS')
    into return_text
    from dual;
    select nvl(return_text,'00 HRS 00 MINS 00 SECS') into return_text from dual;
    return return_text;
exception when others then
return '';
end get_time;
/


grant execute on saud.get_time to front_end;

create or replace  synonym front_end.get_time for saud.get_time ;