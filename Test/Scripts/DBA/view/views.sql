CREATE OR REPLACE VIEW CALL_LOG
AS
	SELECT * FROM (
	SELECT * FROM SAUD.CALL_LOG
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);

CREATE OR REPLACE VIEW TOP_10_CALLS
AS 
	SELECT * FROM (
	SELECT COALESCE(NAME,PNUMBER) NAME,PNUMBER,ROUND(SUM(DURATION)/60,2) TOTAL_DURATION,COUNT(*) TOTAL_COUNT,TYPE 
	FROM CALL_LOG
	WHERE DURATION <> 0
	AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	GROUP BY PNUMBER,COALESCE(NAME,PNUMBER),TYPE
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);



CREATE OR REPLACE VIEW TOP_10_I_COUNT
AS 
	SELECT * FROM (
	SELECT "NAME","PNUMBER","TOTAL_DURATION","TOTAL_COUNT","TYPE" FROM (SELECT * FROM TOP_10_CALLS WHERE UPPER(TYPE) = 'INCOMING'
	ORDER BY TOTAL_COUNT DESC) WHERE ROWNUM <= 10
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);



CREATE OR REPLACE VIEW TOP_10_O_COUNT
AS 
	SELECT * FROM (
	SELECT "NAME","PNUMBER","TOTAL_DURATION","TOTAL_COUNT","TYPE" FROM (SELECT * FROM TOP_10_CALLS WHERE UPPER(TYPE) = 'OUTGOING'
	ORDER BY TOTAL_COUNT DESC) WHERE ROWNUM <= 10
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);



CREATE OR REPLACE VIEW TOP_10_I_DURATION
AS 
	SELECT * FROM (
	SELECT "NAME","PNUMBER","TOTAL_DURATION","TOTAL_COUNT","TYPE" FROM (SELECT * FROM TOP_10_CALLS WHERE UPPER(TYPE) = 'INCOMING'
	ORDER BY TOTAL_DURATION DESC) WHERE ROWNUM <= 10
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);



CREATE OR REPLACE VIEW TOP_10_O_DURATION
AS 
	SELECT * FROM (
	SELECT "NAME","PNUMBER","TOTAL_DURATION","TOTAL_COUNT","TYPE" FROM (SELECT * FROM TOP_10_CALLS WHERE UPPER(TYPE) = 'OUTGOING'
	ORDER BY TOTAL_DURATION DESC) WHERE ROWNUM <= 10
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);



CREATE OR REPLACE VIEW LONGEST_CALL
AS 
	SELECT * FROM (
	SELECT COALESCE(NAME,PNUMBER) NAME,ROUND(TO_NUMBER(DURATION)/60,2) DURATION FROM CALL_LOG
	WHERE DURATION IN (SELECT MAX(TO_NUMBER(DURATION)) FROM CALL_LOG WHERE TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES))
	--AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  --mofidied on 04-Sep-2015
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);



CREATE OR REPLACE VIEW SUMMARY
AS 
	SELECT * FROM (
	SELECT 'ALL CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	UNION ALL
	SELECT 'MISSED CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE UPPER(TYPE) = 'MISSED' AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	UNION ALL
	SELECT 'INCOMING CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE UPPER(TYPE) = 'INCOMING' AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	UNION ALL
	SELECT 'OUTGOING CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE UPPER(TYPE) = 'OUTGOING' AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	UNION ALL
	SELECT 'MOBILE CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE GET_NUMBER_TYPE(PNUMBER) IN (3,5) AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	UNION ALL
	SELECT 'LANDLINE CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE GET_NUMBER_TYPE(PNUMBER) IN (2) AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	UNION ALL
	SELECT 'INTERNATIONAL CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE GET_NUMBER_TYPE(PNUMBER) IN (6) AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	UNION ALL
	SELECT 'OTHER CALLS' TYPE,COUNT(*) COUNT FROM CALL_LOG WHERE GET_NUMBER_TYPE(PNUMBER) NOT IN (2,3,5,6) AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);


CREATE OR REPLACE VIEW TOP_10_M_COUNT
AS 
	SELECT * FROM (
	SELECT "NAME","PNUMBER","TOTAL_DURATION","TOTAL_COUNT","TYPE" FROM (
	SELECT COALESCE(NAME,PNUMBER) NAME,PNUMBER,'0' TOTAL_DURATION,COUNT(*) TOTAL_COUNT,TYPE 
	FROM CALL_LOG
	WHERE UPPER(TYPE) = 'MISSED'
	AND TRUNC(D_CALL_DATE) BETWEEN (SELECT NVL(MAX(START_DATE),'01-JAN-2015') FROM DATES) AND (SELECT NVL(MAX(END_DATE),SYSDATE) FROM DATES)  
	GROUP BY PNUMBER,COALESCE(NAME,PNUMBER),TYPE
	ORDER BY TOTAL_COUNT DESC
	) WHERE ROWNUM <= 10
	)
	WHERE EXISTS (SELECT 1 FROM CHECK_TABLE WHERE ROWNUM <= 1);
	
CREATE OR REPLACE VIEW HOUR_WISE_ANALYSIS AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                               AS call_type, 
                     Trim(Lower(To_char(d_call_date,'hh24'))) AS day 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT Nvl(Max(start_date),To_date('01' 
                                                        || To_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT Nvl(Max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR day IN ('00' AS h_00, 
                                                                       '01' AS h_01, 
                                                                       '02' AS h_02, 
                                                                       '03' AS h_03, 
                                                                       '04' AS h_04, 
                                                                       '05' AS h_05, 
                                                                       '06' AS h_06, 
                                                                       '07' AS h_07, 
                                                                       '08' AS h_08, 
                                                                       '09' AS h_09, 
                                                                       '10' AS h_10, 
                                                                       '11' AS h_11, 
                                                                       '12' AS h_12, 
                                                                       '13' AS h_13, 
                                                                       '14' AS h_14, 
                                                                       '15' AS h_15, 
                                                                       '16' AS h_16, 
                                                                       '17' AS h_17, 
                                                                       '18' AS h_18, 
                                                                       '19' AS h_19, 
                                                                       '20' AS h_20, 
                                                                       '21' AS h_21, 
                                                                       '22' AS h_22, 
                                                                       '23' AS h_23)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     trim(lower(to_char(d_call_date,'hh24'))) AS day 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR day IN ('00' AS h_00, 
                                                                       '01' AS h_01, 
                                                                       '02' AS h_02, 
                                                                       '03' AS h_03, 
                                                                       '04' AS h_04, 
                                                                       '05' AS h_05, 
                                                                       '06' AS h_06, 
                                                                       '07' AS h_07, 
                                                                       '08' AS h_08, 
                                                                       '09' AS h_09, 
                                                                       '10' AS h_10, 
                                                                       '11' AS h_11, 
                                                                       '12' AS h_12, 
                                                                       '13' AS h_13, 
                                                                       '14' AS h_14, 
                                                                       '15' AS h_15, 
                                                                       '16' AS h_16, 
                                                                       '17' AS h_17, 
                                                                       '18' AS h_18, 
                                                                       '19' AS h_19, 
                                                                       '20' AS h_20, 
                                                                       '21' AS h_21, 
                                                                       '22' AS h_22, 
                                                                       '23' AS h_23)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     trim(lower(to_char(d_call_date,'hh24'))) AS day 
              FROM   call_log 
              WHERE  TYPE = 'Missed' 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR day IN ('00' AS h_00, 
                                                                       '00' AS h_01, 
                                                                       '02' AS h_02, 
                                                                       '03' AS h_03, 
                                                                       '04' AS h_04, 
                                                                       '05' AS h_05, 
                                                                       '06' AS h_06, 
                                                                       '07' AS h_07, 
                                                                       '08' AS h_08, 
                                                                       '09' AS h_09, 
                                                                       '10' AS h_10, 
                                                                       '11' AS h_11, 
                                                                       '12' AS h_12, 
                                                                       '13' AS h_13, 
                                                                       '14' AS h_14, 
                                                                       '15' AS h_15, 
                                                                       '16' AS h_16, 
                                                                       '17' AS h_17, 
                                                                       '18' AS h_18, 
                                                                       '19' AS h_19, 
                                                                       '20' AS h_20, 
                                                                       '21' AS h_21, 
                                                                       '22' AS h_22, 
                                                                       '23' AS h_23));
																	   
CREATE OR REPLACE VIEW DAY_WISE_ANALYSIS AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                       AS call_type, 
                     Lower(To_char(d_call_date,'DD')) AS dat 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT Nvl(Max(start_date),To_date('01' 
                                                        || To_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT Nvl(Max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR dat IN ('01' AS d_01, 
                                                                       '02' AS d_02, 
                                                                       '03' AS d_03, 
                                                                       '04' AS d_04, 
                                                                       '05' AS d_05, 
                                                                       '06' AS d_06, 
                                                                       '07' AS d_07, 
                                                                       '08' AS d_08, 
                                                                       '09' AS d_09, 
                                                                       '10' AS d_10, 
                                                                       '11' AS d_11, 
                                                                       '12' AS d_12, 
                                                                       '13' AS d_13, 
                                                                       '14' AS d_14, 
                                                                       '15' AS d_15, 
                                                                       '16' AS d_16, 
                                                                       '17' AS d_17, 
                                                                       '18' AS d_18, 
                                                                       '19' AS d_19, 
                                                                       '20' AS d_20, 
                                                                       '21' AS d_21, 
                                                                       '22' AS d_22, 
                                                                       '23' AS d_23, 
                                                                       '24' AS d_24, 
                                                                       '25' AS d_25, 
                                                                       '26' AS d_26, 
                                                                       '27' AS d_27, 
                                                                       '28' AS d_28, 
                                                                       '29' AS d_29, 
                                                                       '30' AS d_30, 
                                                                       '31' AS d_31)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     lower(to_char(d_call_date,'DD')) AS dat 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR dat IN ('01' AS d_01, 
                                                                       '02' AS d_02, 
                                                                       '03' AS d_03, 
                                                                       '04' AS d_04, 
                                                                       '05' AS d_05, 
                                                                       '06' AS d_06, 
                                                                       '07' AS d_07, 
                                                                       '08' AS d_08, 
                                                                       '09' AS d_09, 
                                                                       '10' AS d_10, 
                                                                       '11' AS d_11, 
                                                                       '12' AS d_12, 
                                                                       '13' AS d_13, 
                                                                       '14' AS d_14, 
                                                                       '15' AS d_15, 
                                                                       '16' AS d_16, 
                                                                       '17' AS d_17, 
                                                                       '18' AS d_18, 
                                                                       '19' AS d_19, 
                                                                       '20' AS d_20, 
                                                                       '21' AS d_21, 
                                                                       '22' AS d_22, 
                                                                       '23' AS d_23, 
                                                                       '24' AS d_24, 
                                                                       '25' AS d_25, 
                                                                       '26' AS d_26, 
                                                                       '27' AS d_27, 
                                                                       '28' AS d_28, 
                                                                       '29' AS d_29, 
                                                                       '30' AS d_30, 
                                                                       '31' AS d_31)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     lower(to_char(d_call_date,'DD')) AS dat 
              FROM   call_log 
              WHERE  TYPE = 'Missed' 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR dat IN ('01' AS d_01, 
                                                                       '02' AS d_02, 
                                                                       '03' AS d_03, 
                                                                       '04' AS d_04, 
                                                                       '05' AS d_05, 
                                                                       '06' AS d_06, 
                                                                       '07' AS d_07, 
                                                                       '08' AS d_08, 
                                                                       '09' AS d_09, 
                                                                       '10' AS d_10, 
                                                                       '11' AS d_11, 
                                                                       '12' AS d_12, 
                                                                       '13' AS d_13, 
                                                                       '14' AS d_14, 
                                                                       '15' AS d_15, 
                                                                       '16' AS d_16, 
                                                                       '17' AS d_17, 
                                                                       '18' AS d_18, 
                                                                       '19' AS d_19, 
                                                                       '20' AS d_20, 
                                                                       '21' AS d_21, 
                                                                       '22' AS d_22, 
                                                                       '23' AS d_23, 
                                                                       '24' AS d_24, 
                                                                       '25' AS d_25, 
                                                                       '26' AS d_26, 
                                                                       '27' AS d_27, 
                                                                       '28' AS d_28, 
                                                                       '29' AS d_29, 
                                                                       '30' AS d_30, 
                                                                       '31' AS d_31));
CREATE 
OR 
replace VIEW week_wise_analysis 
AS 
  SELECT * 
  FROM  ( 
                SELECT 'Outgoing'                             AS call_type, 
                       trim(lower(to_char(d_call_date,'DY'))) AS day 
                FROM   call_log 
                WHERE  TYPE = 'Outgoing' 
                AND    duration <> 0 
                AND    d_call_date BETWEEN 
                                            ( 
                                            SELECT nvl(max(start_date),to_date('01' 
                                                          || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                            FROM   dates) 
                AND 
                       ( 
                              SELECT nvl(max(end_date),SYSDATE) 
                              FROM   dates) ) pivot(count(*) FOR day IN ('mon' AS monday, 
                                                                         'tue' AS tuesday, 
                                                                         'wed' AS wednesday, 
                                                                         'thu' AS thursday, 
                                                                         'fri' AS friday, 
                                                                         'sat' AS saturday, 
                                                                         'sun' AS sunday)) 
  UNION ALL 
  SELECT * 
  FROM  ( 
                SELECT 'Incoming', 
                       trim(lower(to_char(d_call_date,'DY'))) AS day 
                FROM   call_log 
                WHERE  TYPE = 'Incoming' 
                AND    duration <> 0 
                AND    d_call_date BETWEEN 
                                            ( 
                                            SELECT nvl(max(start_date),to_date('01' 
                                                          || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                            FROM   dates) 
                AND 
                       ( 
                              SELECT nvl(max(end_date),SYSDATE) 
                              FROM   dates) ) pivot(count(*) FOR day IN ('mon' AS monday, 
                                                                         'tue' AS tuesday, 
                                                                         'wed' AS wednesday, 
                                                                         'thu' AS thursday, 
                                                                         'fri' AS friday, 
                                                                         'sat' AS saturday, 
                                                                         'sun' AS sunday)) 
  UNION ALL 
  SELECT * 
  FROM  ( 
                SELECT 'Missed', 
                       trim(lower(to_char(d_call_date,'DY'))) AS day 
                FROM   call_log 
                WHERE  TYPE = 'Missed' 
                AND    d_call_date BETWEEN 
                                            ( 
                                            SELECT nvl(max(start_date),to_date('01' 
                                                          || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                            FROM   dates) 
                AND 
                       ( 
                              SELECT nvl(max(end_date),SYSDATE) 
                              FROM   dates) ) pivot(count(*) FOR day IN ('mon' AS monday, 
                                                                         'tue' AS tuesday, 
                                                                         'wed' AS wednesday, 
                                                                         'thu' AS thursday, 
                                                                         'fri' AS friday, 
                                                                         'sat' AS saturday, 
                                                                         'sun' AS sunday));
																		 
																		 
CREATE OR replace VIEW month_wise_analysis AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                            AS call_type, 
                     Lower(To_char(d_call_date,'MM-YYYY')) AS mon 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 ) pivot(count(*) FOR mon IN ('01-2015'  AS jan, 
                                                                '02-2015'  AS feb, 
                                                                '03-2015'  AS mar, 
                                                                '04-2015'  AS apr, 
                                                                '05-2015'  AS may, 
                                                                '06-2015'  AS jun, 
                                                                '07-2015'  AS jul, 
                                                                '08-2015'  AS aug, 
                                                                '09-2015'  AS sep, 
                                                                '010-2015' AS oct, 
                                                                '011-2015' AS nov, 
                                                                '011-2015' AS DEC)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     lower(to_char(d_call_date,'MM-YYYY')) AS month 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 ) pivot(count(*) FOR month IN ('01-2015'  AS jan, 
                                                                  '02-2015'  AS feb, 
                                                                  '03-2015'  AS mar, 
                                                                  '04-2015'  AS apr, 
                                                                  '05-2015'  AS may, 
                                                                  '06-2015'  AS jun, 
                                                                  '07-2015'  AS jul, 
                                                                  '08-2015'  AS aug, 
                                                                  '09-2015'  AS sep, 
                                                                  '010-2015' AS oct, 
                                                                  '011-2015' AS nov, 
                                                                  '011-2015' AS DEC)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     lower(to_char(d_call_date,'MM-YYYY')) AS month 
              FROM   call_log 
              WHERE  TYPE = 'Missed' ) pivot(count(*) FOR month IN ('01-2015'  AS jan, 
                                                                    '02-2015'  AS feb, 
                                                                    '03-2015'  AS mar, 
                                                                    '04-2015'  AS apr, 
                                                                    '05-2015'  AS may, 
                                                                    '06-2015'  AS jun, 
                                                                    '07-2015'  AS jul, 
                                                                    '08-2015'  AS aug, 
                                                                    '09-2015'  AS sep, 
                                                                    '010-2015' AS oct, 
                                                                    '011-2015' AS nov, 
                                                                    '011-2015' AS DEC));
																	
CREATE OR replace VIEW year_wise_analysis AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                         AS call_type, 
                     Lower(To_char(d_call_date,'YYYY')) AS year 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 ) pivot(count(*) FOR year IN (2015,2016,2017)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     lower(to_char(d_call_date,'YYYY')) AS year 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 ) pivot(count(*) FOR year IN (2015,2016,2017)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     lower(to_char(d_call_date,'YYYY')) AS year 
              FROM   call_log 
              WHERE  TYPE = 'Missed' ) pivot(count(*) FOR year IN (2015,2016,2017));CREATE OR REPLACE VIEW HOUR_WISE_ANALYSIS AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                               AS call_type, 
                     Trim(Lower(To_char(d_call_date,'hh24'))) AS day 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT Nvl(Max(start_date),To_date('01' 
                                                        || To_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT Nvl(Max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR day IN ('00' AS h_00, 
                                                                       '01' AS h_01, 
                                                                       '02' AS h_02, 
                                                                       '03' AS h_03, 
                                                                       '04' AS h_04, 
                                                                       '05' AS h_05, 
                                                                       '06' AS h_06, 
                                                                       '07' AS h_07, 
                                                                       '08' AS h_08, 
                                                                       '09' AS h_09, 
                                                                       '10' AS h_10, 
                                                                       '11' AS h_11, 
                                                                       '12' AS h_12, 
                                                                       '13' AS h_13, 
                                                                       '14' AS h_14, 
                                                                       '15' AS h_15, 
                                                                       '16' AS h_16, 
                                                                       '17' AS h_17, 
                                                                       '18' AS h_18, 
                                                                       '19' AS h_19, 
                                                                       '20' AS h_20, 
                                                                       '21' AS h_21, 
                                                                       '22' AS h_22, 
                                                                       '23' AS h_23)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     trim(lower(to_char(d_call_date,'hh24'))) AS day 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR day IN ('00' AS h_00, 
                                                                       '01' AS h_01, 
                                                                       '02' AS h_02, 
                                                                       '03' AS h_03, 
                                                                       '04' AS h_04, 
                                                                       '05' AS h_05, 
                                                                       '06' AS h_06, 
                                                                       '07' AS h_07, 
                                                                       '08' AS h_08, 
                                                                       '09' AS h_09, 
                                                                       '10' AS h_10, 
                                                                       '11' AS h_11, 
                                                                       '12' AS h_12, 
                                                                       '13' AS h_13, 
                                                                       '14' AS h_14, 
                                                                       '15' AS h_15, 
                                                                       '16' AS h_16, 
                                                                       '17' AS h_17, 
                                                                       '18' AS h_18, 
                                                                       '19' AS h_19, 
                                                                       '20' AS h_20, 
                                                                       '21' AS h_21, 
                                                                       '22' AS h_22, 
                                                                       '23' AS h_23)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     trim(lower(to_char(d_call_date,'hh24'))) AS day 
              FROM   call_log 
              WHERE  TYPE = 'Missed' 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR day IN ('00' AS h_00, 
                                                                       '00' AS h_01, 
                                                                       '02' AS h_02, 
                                                                       '03' AS h_03, 
                                                                       '04' AS h_04, 
                                                                       '05' AS h_05, 
                                                                       '06' AS h_06, 
                                                                       '07' AS h_07, 
                                                                       '08' AS h_08, 
                                                                       '09' AS h_09, 
                                                                       '10' AS h_10, 
                                                                       '11' AS h_11, 
                                                                       '12' AS h_12, 
                                                                       '13' AS h_13, 
                                                                       '14' AS h_14, 
                                                                       '15' AS h_15, 
                                                                       '16' AS h_16, 
                                                                       '17' AS h_17, 
                                                                       '18' AS h_18, 
                                                                       '19' AS h_19, 
                                                                       '20' AS h_20, 
                                                                       '21' AS h_21, 
                                                                       '22' AS h_22, 
                                                                       '23' AS h_23));
																	   
CREATE OR REPLACE VIEW DAY_WISE_ANALYSIS AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                       AS call_type, 
                     Lower(To_char(d_call_date,'DD')) AS dat 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT Nvl(Max(start_date),To_date('01' 
                                                        || To_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT Nvl(Max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR dat IN ('01' AS d_01, 
                                                                       '02' AS d_02, 
                                                                       '03' AS d_03, 
                                                                       '04' AS d_04, 
                                                                       '05' AS d_05, 
                                                                       '06' AS d_06, 
                                                                       '07' AS d_07, 
                                                                       '08' AS d_08, 
                                                                       '09' AS d_09, 
                                                                       '10' AS d_10, 
                                                                       '11' AS d_11, 
                                                                       '12' AS d_12, 
                                                                       '13' AS d_13, 
                                                                       '14' AS d_14, 
                                                                       '15' AS d_15, 
                                                                       '16' AS d_16, 
                                                                       '17' AS d_17, 
                                                                       '18' AS d_18, 
                                                                       '19' AS d_19, 
                                                                       '20' AS d_20, 
                                                                       '21' AS d_21, 
                                                                       '22' AS d_22, 
                                                                       '23' AS d_23, 
                                                                       '24' AS d_24, 
                                                                       '25' AS d_25, 
                                                                       '26' AS d_26, 
                                                                       '27' AS d_27, 
                                                                       '28' AS d_28, 
                                                                       '29' AS d_29, 
                                                                       '30' AS d_30, 
                                                                       '31' AS d_31)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     lower(to_char(d_call_date,'DD')) AS dat 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR dat IN ('01' AS d_01, 
                                                                       '02' AS d_02, 
                                                                       '03' AS d_03, 
                                                                       '04' AS d_04, 
                                                                       '05' AS d_05, 
                                                                       '06' AS d_06, 
                                                                       '07' AS d_07, 
                                                                       '08' AS d_08, 
                                                                       '09' AS d_09, 
                                                                       '10' AS d_10, 
                                                                       '11' AS d_11, 
                                                                       '12' AS d_12, 
                                                                       '13' AS d_13, 
                                                                       '14' AS d_14, 
                                                                       '15' AS d_15, 
                                                                       '16' AS d_16, 
                                                                       '17' AS d_17, 
                                                                       '18' AS d_18, 
                                                                       '19' AS d_19, 
                                                                       '20' AS d_20, 
                                                                       '21' AS d_21, 
                                                                       '22' AS d_22, 
                                                                       '23' AS d_23, 
                                                                       '24' AS d_24, 
                                                                       '25' AS d_25, 
                                                                       '26' AS d_26, 
                                                                       '27' AS d_27, 
                                                                       '28' AS d_28, 
                                                                       '29' AS d_29, 
                                                                       '30' AS d_30, 
                                                                       '31' AS d_31)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     lower(to_char(d_call_date,'DD')) AS dat 
              FROM   call_log 
              WHERE  TYPE = 'Missed' 
              AND    d_call_date BETWEEN 
                                          ( 
                                          SELECT nvl(max(start_date),to_date('01' 
                                                        || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                          FROM   dates) 
              AND 
                     ( 
                            SELECT nvl(max(end_date),SYSDATE) 
                            FROM   dates) ) pivot(count(*) FOR dat IN ('01' AS d_01, 
                                                                       '02' AS d_02, 
                                                                       '03' AS d_03, 
                                                                       '04' AS d_04, 
                                                                       '05' AS d_05, 
                                                                       '06' AS d_06, 
                                                                       '07' AS d_07, 
                                                                       '08' AS d_08, 
                                                                       '09' AS d_09, 
                                                                       '10' AS d_10, 
                                                                       '11' AS d_11, 
                                                                       '12' AS d_12, 
                                                                       '13' AS d_13, 
                                                                       '14' AS d_14, 
                                                                       '15' AS d_15, 
                                                                       '16' AS d_16, 
                                                                       '17' AS d_17, 
                                                                       '18' AS d_18, 
                                                                       '19' AS d_19, 
                                                                       '20' AS d_20, 
                                                                       '21' AS d_21, 
                                                                       '22' AS d_22, 
                                                                       '23' AS d_23, 
                                                                       '24' AS d_24, 
                                                                       '25' AS d_25, 
                                                                       '26' AS d_26, 
                                                                       '27' AS d_27, 
                                                                       '28' AS d_28, 
                                                                       '29' AS d_29, 
                                                                       '30' AS d_30, 
                                                                       '31' AS d_31));
CREATE 
OR 
replace VIEW week_wise_analysis 
AS 
  SELECT * 
  FROM  ( 
                SELECT 'Outgoing'                             AS call_type, 
                       trim(lower(to_char(d_call_date,'DY'))) AS day 
                FROM   call_log 
                WHERE  TYPE = 'Outgoing' 
                AND    duration <> 0 
                AND    d_call_date BETWEEN 
                                            ( 
                                            SELECT nvl(max(start_date),to_date('01' 
                                                          || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                            FROM   dates) 
                AND 
                       ( 
                              SELECT nvl(max(end_date),SYSDATE) 
                              FROM   dates) ) pivot(count(*) FOR day IN ('mon' AS monday, 
                                                                         'tue' AS tuesday, 
                                                                         'wed' AS wednesday, 
                                                                         'thu' AS thursday, 
                                                                         'fri' AS friday, 
                                                                         'sat' AS saturday, 
                                                                         'sun' AS sunday)) 
  UNION ALL 
  SELECT * 
  FROM  ( 
                SELECT 'Incoming', 
                       trim(lower(to_char(d_call_date,'DY'))) AS day 
                FROM   call_log 
                WHERE  TYPE = 'Incoming' 
                AND    duration <> 0 
                AND    d_call_date BETWEEN 
                                            ( 
                                            SELECT nvl(max(start_date),to_date('01' 
                                                          || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                            FROM   dates) 
                AND 
                       ( 
                              SELECT nvl(max(end_date),SYSDATE) 
                              FROM   dates) ) pivot(count(*) FOR day IN ('mon' AS monday, 
                                                                         'tue' AS tuesday, 
                                                                         'wed' AS wednesday, 
                                                                         'thu' AS thursday, 
                                                                         'fri' AS friday, 
                                                                         'sat' AS saturday, 
                                                                         'sun' AS sunday)) 
  UNION ALL 
  SELECT * 
  FROM  ( 
                SELECT 'Missed', 
                       trim(lower(to_char(d_call_date,'DY'))) AS day 
                FROM   call_log 
                WHERE  TYPE = 'Missed' 
                AND    d_call_date BETWEEN 
                                            ( 
                                            SELECT nvl(max(start_date),to_date('01' 
                                                          || to_char(SYSDATE,'-mm-yyyy'),'dd-mm-yyyy')) 
                                            FROM   dates) 
                AND 
                       ( 
                              SELECT nvl(max(end_date),SYSDATE) 
                              FROM   dates) ) pivot(count(*) FOR day IN ('mon' AS monday, 
                                                                         'tue' AS tuesday, 
                                                                         'wed' AS wednesday, 
                                                                         'thu' AS thursday, 
                                                                         'fri' AS friday, 
                                                                         'sat' AS saturday, 
                                                                         'sun' AS sunday));
																		 
																		 
CREATE OR replace VIEW month_wise_analysis AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                            AS call_type, 
                     Lower(To_char(d_call_date,'MM-YYYY')) AS mon 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 ) pivot(count(*) FOR mon IN ('01-2015'  AS jan, 
                                                                '02-2015'  AS feb, 
                                                                '03-2015'  AS mar, 
                                                                '04-2015'  AS apr, 
                                                                '05-2015'  AS may, 
                                                                '06-2015'  AS jun, 
                                                                '07-2015'  AS jul, 
                                                                '08-2015'  AS aug, 
                                                                '09-2015'  AS sep, 
                                                                '010-2015' AS oct, 
                                                                '011-2015' AS nov, 
                                                                '011-2015' AS DEC)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     lower(to_char(d_call_date,'MM-YYYY')) AS month 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 ) pivot(count(*) FOR month IN ('01-2015'  AS jan, 
                                                                  '02-2015'  AS feb, 
                                                                  '03-2015'  AS mar, 
                                                                  '04-2015'  AS apr, 
                                                                  '05-2015'  AS may, 
                                                                  '06-2015'  AS jun, 
                                                                  '07-2015'  AS jul, 
                                                                  '08-2015'  AS aug, 
                                                                  '09-2015'  AS sep, 
                                                                  '010-2015' AS oct, 
                                                                  '011-2015' AS nov, 
                                                                  '011-2015' AS DEC)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     lower(to_char(d_call_date,'MM-YYYY')) AS month 
              FROM   call_log 
              WHERE  TYPE = 'Missed' ) pivot(count(*) FOR month IN ('01-2015'  AS jan, 
                                                                    '02-2015'  AS feb, 
                                                                    '03-2015'  AS mar, 
                                                                    '04-2015'  AS apr, 
                                                                    '05-2015'  AS may, 
                                                                    '06-2015'  AS jun, 
                                                                    '07-2015'  AS jul, 
                                                                    '08-2015'  AS aug, 
                                                                    '09-2015'  AS sep, 
                                                                    '010-2015' AS oct, 
                                                                    '011-2015' AS nov, 
                                                                    '011-2015' AS DEC));
																	
CREATE OR replace VIEW year_wise_analysis AS 
SELECT * 
FROM  ( 
              SELECT 'Outgoing'                         AS call_type, 
                     Lower(To_char(d_call_date,'YYYY')) AS year 
              FROM   call_log 
              WHERE  TYPE = 'Outgoing' 
              AND    duration <> 0 ) pivot(count(*) FOR year IN (2015,2016,2017)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Incoming', 
                     lower(to_char(d_call_date,'YYYY')) AS year 
              FROM   call_log 
              WHERE  TYPE = 'Incoming' 
              AND    duration <> 0 ) pivot(count(*) FOR year IN (2015,2016,2017)) 
UNION ALL 
SELECT * 
FROM  ( 
              SELECT 'Missed', 
                     lower(to_char(d_call_date,'YYYY')) AS year 
              FROM   call_log 
              WHERE  TYPE = 'Missed' ) pivot(count(*) FOR year IN (2015,2016,2017));