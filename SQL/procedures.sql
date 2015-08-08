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