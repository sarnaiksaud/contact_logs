CREATE OR REPLACE PROCEDURE SAUD.log_in
AS
BEGIN
    INSERT INTO CHECK_TABLE VALUES (1);

    BEGIN
        DBMS_SCHEDULER.drop_job('MINUTE_JOB');
        EXCEPTION WHEN OTHERS THEN
            NULL;
    END;
    
    DBMS_SCHEDULER.create_job (
    job_name        => 'MINUTE_JOB',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN DELETE FROM CHECK_TABLE; COMMIT; END;',
    start_date      => SYSDATE+10/(24*60),
    end_date        => SYSDATE+10.5/(24*60),
    repeat_interval => 'FREQ=MINUTELY;INTERVAL=1;',
    auto_drop => true,
    enabled         => TRUE);
    
    COMMIT;
END;
/


CREATE OR REPLACE PROCEDURE log_out
AS
BEGIN

	BEGIN
        DBMS_SCHEDULER.drop_job('MINUTE_JOB');
        EXCEPTION WHEN OTHERS THEN
            NULL;
    END;

    DELETE FROM CHECK_TABLE;
    COMMIT;
END;
/


create or replace procedure 
update_dates
(p_start_date varchar2,p_end_date varchar2)
is
cnt number := 0;
begin
select count(*) into cnt from dates;
IF cnt = 0 THEN
    INSERT INTO DATES VALUES (NULL,NULL);
END IF;
update dates set start_date = TO_DATE(p_start_date,'YYYY-MM_DD'), end_date = TO_DATE(p_end_date,'YYYY-MM-DD');


commit;
end;