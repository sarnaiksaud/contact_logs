SELECT * FROM dba_scheduler_jobs WHERE OWNER = 'SAUD'

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MINUTE_JOB',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN job_test_proc(''MINUE''); END;',
    start_date      => SYSDATE+10/(24*60),
    end_date        => SYSDATE+11/(24*60),
    repeat_interval => 'FREQ=MINUTELY;INTERVAL=1;',
    auto_drop => true,
    enabled         => TRUE);  
END;
/

DROP SEQUENCE job_seq;

create sequence job_seq;

DROP TABLE JOB_TEST;

create table job_test
(num number,job_name varchar2(50),timestamp timestamp);

create or replace procedure job_test_proc (job_name VARCHAR2)
As
begin
insert into job_test VALUES (job_seq.NEXTvAL,job_name,SYSDATE);
COMMIT;
END;