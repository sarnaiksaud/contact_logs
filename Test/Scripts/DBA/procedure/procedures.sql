CREATE OR REPLACE PROCEDURE SAUD.insert_to_call_log
(
p_name VARCHAR2,
p_pnumber VARCHAR2,
p_type VARCHAR2,
p_call_date VARCHAR2,
p_duration VARCHAR2,
p_device VARCHAR2,
inserted out number
)
IS
x NUMBER;
pnumber_f VARCHAR2(20);
d_call_date varchar2(50);
error_text call_log_error.error_text%type;
BEGIN
    inserted := -1;
    
    --insert into front_end.text_data values (p_pnumber || '-' || p_call_date);
    
    BEGIN
        SELECT 1 INTO x FROM call_log
        WHERE call_date = p_call_date;
        
    EXCEPTION WHEN no_data_found  THEN
    
        pnumber_f := p_pnumber;
        
        IF get_number_type(pnumber_f) = 3 THEN
            pnumber_f := '+91' || pnumber_f;
        END IF;
        
        d_call_date := SUBSTR(p_call_date,5);
        
        d_call_date := SUBSTR(d_call_date,1,INSTR(d_call_date,'GMT')-1) || SUBSTR(d_call_date,-4);
        
        INSERT INTO call_log
        (
            log_id,
            name,
            pnumber,
            type,
            d_call_date,
            call_date,
            duration,
            timestamp,
            phone
        )
        VALUES
        (
            seq_cl.NEXTVAL,
            p_name,
            pnumber_f,
            p_type,
            TO_DATE(UPPER(d_call_date),'MON DD HH24:MI:SS RRRR'),
            p_call_date,
            p_duration,
            SYSDATE,
            p_device
        );
        inserted := 1;
    END;
EXCEPTION
    WHEN OTHERS THEN
    error_text := SQLERRM;
    INSERT INTO call_log_error
        (
            log_id,
            name,
            pnumber,
            type,
            d_call_date,
            call_date,
            duration,
            timestamp,
            phone,
            error_text
        )
        VALUES
        (
            seq_cl.NEXTVAL,
            p_name,
            pnumber_f,
            p_type,
            d_call_date,
            p_call_date,
            p_duration,
            SYSDATE,
            p_device,
            error_text
        );
END;
/

CREATE OR REPLACE PROCEDURE to_log
(
p_query VARCHAR2,
p_status VARCHAR2
)
IS
x NUMBER;
BEGIN
    BEGIN
        SELECT 1 INTO x FROM query_log
        WHERE UPPER(query) = UPPER(p_query) AND status = p_status;
		
    EXCEPTION WHEN no_data_found  THEN
		INSERT INTO query_log
		(
			log_id,
			query,
			status,
			timestamp
		)
		VALUES
		(
			log_cl.NEXTVAL,
			p_query,
			p_status,
			SYSDATE
		);
	END;
END; 
/

CREATE OR REPLACE PROCEDURE log_in
AS
PRAGMA AUTONOMOUS_TRANSACTION;
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
PRAGMA AUTONOMOUS_TRANSACTION;
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