CREATE OR REPLACE TRIGGER SAUD.CALL_LOG_AUDIT_TRG_NUMBER 
after update of pnumber ON SAUD.CALL_LOG
for each row
DECLARE
PRAGMA AUTONOMOUS_TRANSACTION;
begin
if :old.pnumber is not null and :new.pnumber is not null then
if :old.pnumber <> :new.pnumber then
insert into call_log_audit
VALUES
(
call_log_audit_seq.NEXTVAL,
'NUMBER',
:old.pnumber,
:new.pnumber,
systimestamp,
:old.name
);

commit;
end if;
end if;
end;
/
