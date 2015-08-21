CREATE OR REPLACE TRIGGER call_log_audit_trg
AFTER UPDATE OF name ON call_log
FOR EACH ROW
DECLARE
PRAGMA AUTONOMOUS_TRANSACTION;
BEGIN
	INSERT INTO call_log_audit
	VALUES
	(
	call_log_audit_seq.NEXTVAL,
	'NAME',
	:OLD.name,
	:NEW.name,
	systimestamp
	);
	COMMIT;
END;
/ 
