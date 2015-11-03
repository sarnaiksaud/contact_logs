REVOKE SELECT ON CALL_LOG FROM FRONT_END;
REVOKE SELECT ON CHECK_TABLE FROM FRONT_END;

REVOKE INSERT,SELECT ON DATES FROM FRONT_END;
REVOKE INSERT,SELECT ON UPLOAD_LOG FROM FRONT_END;

REVOKE EXECUTE ON log_in FROM FRONT_END;
REVOKE EXECUTE ON log_out FROM FRONT_END;
REVOKE EXECUTE ON INSERT_TO_CALL_LOG FROM FRONT_END;
REVOKE EXECUTE ON GET_NUMBER_TYPE FROM FRONT_END;

DROP FUNCTION GET_NUMBER_TYPE;

DROP INDEX I_CONTACT_LOG;
DROP INDEX D_CALL_DATE_INDEX;

DROP PROCEDURE LOG_OUT;
DROP PROCEDURE LOG_IN;
DROP PROCEDURE TO_LOG;
DROP PROCEDURE INSERT_TO_CALL_LOG;

DROP TRIGGER CALL_LOG_AUDIT_TRG;

DROP SEQUENCE SEQ_CL;
DROP SEQUENCE CALL_LOG_AUDIT_SEQ;
DROP SEQUENCE LOG_CL;

-- DROP VIEW TOP_10_I_COUNT;
-- DROP VIEW TOP_10_CALLS;
-- DROP VIEW TOP_10_O_COUNT;
-- DROP VIEW TOP_10_I_DURATION;
-- DROP VIEW LONGEST_CALL;
-- DROP VIEW SUMMARY;
-- DROP VIEW TOP_10_M_COUNT;
-- DROP VIEW TOP_10_O_DURATION;

DROP TABLE XLA_REFERENCE_STRUCTURE;
DROP TABLE QUERY_LOG;
DROP TABLE CHECK_TABLE;
DROP TABLE CALL_LOG_AUDIT;
DROP TABLE CALL_LOG;
DROP TABLE DATES;
DROP TABLE UPLOAD_LOG;