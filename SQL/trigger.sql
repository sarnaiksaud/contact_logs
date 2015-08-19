CREATE OR REPLACE  TRIGGER log_in_trg
AFTER INSERT
ON
CHECK_TABLE
DECLARE
	V_SQL VARCHAR2(1000);
BEGIN
	BEGIN
        V_SQL:= 'BEGIN DBMS_SCHEDULER.drop_job(''MINUTE_JOB''); END;';
		EXECUTE IMMEDIATE V_SQL;
        EXCEPTION WHEN OTHERS THEN
            NULL;
    END;
    
    V_SQL:= 'BEGIN
		DBMS_SCHEDULER.create_job (
    job_name        => ''MINUTE_JOB'',
    job_type        => ''PLSQL_BLOCK'',
    job_action      => ''BEGIN DELETE FROM CHECK_TABLE; COMMIT; END;'',
    start_date      => SYSDATE+1/(24*60),
    end_date        => SYSDATE+1.5/(24*60),
    repeat_interval => ''FREQ=MINUTELY;INTERVAL=1;'',
    auto_drop => true,
    enabled         => TRUE);
	END;';
	
	EXECUTE IMMEDIATE V_SQL;
	
END;



create or replace trigger call_log_audit_trg
after update of name on call_log
for each row
DECLARE
PRAGMA AUTONOMOUS_TRANSACTION;
begin
insert into call_log_audit
VALUES
(
call_log_audit_seq.NEXTVAL,
'NAME',
:old.name,
:new.name,
systimestamp
);
commit;
end;
/ 
