GRANT CREATE SESSION TO FTEST;
--added on 21-08-2015 by Saud
GRANT CREATE VIEW TO FTEST;				
GRANT CREATE SYNONYM TO FTEST;

--added on 21-08-2015 by Saud
GRANT SELECT ON CALL_LOG TO FTEST;
--added on 21-08-2015 by Saud
GRANT SELECT ON CHECK_TABLE TO FTEST;

-- GRANT SELECT ON LONGEST_CALL TO FTEST;
-- GRANT SELECT ON SUMMARY TO FTEST;
-- GRANT SELECT ON TOP_10_CALLS TO FTEST;
-- GRANT SELECT ON TOP_10_I_COUNT TO FTEST;
-- GRANT SELECT ON TOP_10_I_DURATION TO FTEST;
-- GRANT SELECT ON TOP_10_M_COUNT TO FTEST;
-- GRANT SELECT ON TOP_10_O_COUNT TO FTEST;
-- GRANT SELECT ON TOP_10_O_DURATION TO FTEST;

GRANT INSERT,SELECT ON DATES TO FTEST;

GRANT EXECUTE ON log_in TO FTEST;
GRANT EXECUTE ON log_out TO FTEST;
GRANT EXECUTE ON INSERT_TO_CALL_LOG TO FTEST;
GRANT EXECUTE ON GET_NUMBER_TYPE TO FTEST;
