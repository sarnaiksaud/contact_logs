CREATE INDEX i_contact_log ON call_log(pnumber);
--CREATE INDEX call_date_index ON call_log(TO_DATE(SUBSTR(call_date,5,INSTR(call_date,'GMT', 1)-6),'Mon DD HH24:MI:SS'));
CREATE INDEX d_call_date_index ON call_log(TRUNC(d_call_date));