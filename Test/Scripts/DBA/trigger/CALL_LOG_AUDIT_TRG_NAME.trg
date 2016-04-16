CREATE OR REPLACE TRIGGER "SAUD"."CALL_LOG_AUDIT_TRG_NAME" 
after update of name on call_log
for each row
DECLARE
PRAGMA AUTONOMOUS_TRANSACTION;
begin
if :old.name is not null and :new.name is not null then
if :old.name <> :new.name then
insert into call_log_audit
VALUES
(
call_log_audit_seq.NEXTVAL,
'NAME',
:old.name,
:new.name,
systimestamp,
:old.pnumber
);
commit;
end if;
end if;
end;
/