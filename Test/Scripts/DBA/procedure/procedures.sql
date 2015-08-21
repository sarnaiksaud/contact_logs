CREATE OR REPLACE PROCEDURE insert_to_call_log
(
p_name VARCHAR2,
p_pnumber VARCHAR2,
p_type VARCHAR2,
p_call_date VARCHAR2,
p_duration VARCHAR2,
p_device VARCHAR2
)
IS
x NUMBER;
pnumber_f VARCHAR2(20);
BEGIN
    BEGIN
        SELECT 1 INTO x FROM call_log
        WHERE call_date = p_call_date;
		
    EXCEPTION WHEN no_data_found  THEN
	
		pnumber_f := p_pnumber;
		
		IF get_number_type(pnumber_f) = 3 THEN
			pnumber_f := '+91' || pnumber_f;
		END IF;
		
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
			TO_DATE(UPPER(SUBSTR(p_call_date,1,INSTR(p_call_date,'GMT')-1)),'DY MON DD HH24:MI:SS'),
            p_call_date,
            p_duration,
            SYSDATE,
			p_device
        );
    END;
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