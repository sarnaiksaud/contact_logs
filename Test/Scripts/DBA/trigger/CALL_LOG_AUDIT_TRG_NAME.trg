CREATE OR REPLACE TRIGGER "SAUD"."CALL_LOG_AUDIT_TRG_NAME" 
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