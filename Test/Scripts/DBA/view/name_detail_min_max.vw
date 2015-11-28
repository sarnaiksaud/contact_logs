create or replace view name_detail_min_max 
as
SELECT distinct name,pnumber, to_char(min(d_call_date),'DD-Mon-YYYY HH24:MI:SS') min,to_char(max(d_call_date),'DD-Mon-YYYY HH24:MI:SS') max
						from call_log
                        where EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1)
						group by pnumber,name;
						
grant select on saud.name_detail_min_max to front_end;

create or replace  synonym front_end.name_detail_min_max for saud.name_detail_min_max ;