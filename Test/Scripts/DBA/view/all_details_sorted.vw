create or replace view all_details_sorted
as
SELECT nvl(name,'Unknown') name,pnumber,type,TO_CHAR(d_call_date,'DD-Mon-YYYY HH24:MI:SS') d_call_date 
		FROM call_log where EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1)
		order by log_id desc;
		
grant select on saud.all_details_sorted to front_end;

create or replace  synonym front_end.all_details_sorted for saud.all_details_sorted ;