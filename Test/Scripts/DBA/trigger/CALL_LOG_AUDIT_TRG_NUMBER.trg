CREATE OR REPLACE TRIGGER "SAUD"."CALL_LOG_AUDIT_TRG_NUMBER" 
after update of pnumber on call_log
for each row
DECLARE
PRAGMA AUTONOMOUS_TRANSACTION;
begin

insert into call_log_audit
VALUES
(
call_log_audit_seq.NEXTVAL,
'NUMBER',
:old.pnumber,
:new.pnumber,
systimestamp
);
commit;
end;
/