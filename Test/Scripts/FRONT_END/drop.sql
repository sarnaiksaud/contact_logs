DROP SYNONYM FRONT_END.CALL_LOG;
DROP SYNONYM FRONT_END.DATES;
DROP SYNONYM FRONT_END.DAY_WISE_ANALYSIS;
DROP SYNONYM FRONT_END.GET_NUMBER_TYPE;
DROP SYNONYM FRONT_END.HOUR_WISE_ANALYSIS;
DROP SYNONYM FRONT_END.LOGIN_CRE_P;
DROP SYNONYM FRONT_END.LOG_IN;
DROP SYNONYM FRONT_END.LOG_OUT;
DROP SYNONYM FRONT_END.LONGEST_CALL;
DROP SYNONYM FRONT_END.MONTHLY_WISE_ANALYSIS;
DROP SYNONYM FRONT_END.MONTH_WISE_ANALYSIS;
DROP SYNONYM FRONT_END.SUMMARY;
DROP SYNONYM FRONT_END.TOP_10_CALLS;
DROP SYNONYM FRONT_END.TOP_10_I_COUNT;
DROP SYNONYM FRONT_END.TOP_10_I_DURATION;
DROP SYNONYM FRONT_END.TOP_10_M_COUNT;
DROP SYNONYM FRONT_END.TOP_10_O_COUNT;
DROP SYNONYM FRONT_END.TOP_10_O_DURATION;
DROP SYNONYM FRONT_END.UPDATE_DATES;
DROP SYNONYM FRONT_END.WEEK_WISE_ANALYSIS;
DROP SYNONYM FRONT_END.YEAR_WISE_ANALYSIS;
DROP SYNONYM FRONT_END.INSERT_TO_CALL_LOG;
DROP SYNONYM FRONT_END.UPLOAD_LOG;


/*

select 'DROP SYNONYM ' || owner || '.' || object_name || ';' from all_objects
where owner in  ('FRONT_END')
and status = 'VALID'
and object_type = 'SYNONYM';

*/