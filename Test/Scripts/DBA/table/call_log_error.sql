DROP TABLE SAUD.CALL_LOG_ERROR;

CREATE TABLE SAUD.CALL_LOG_ERROR
(
  LOG_ID       NUMBER,
  NAME         VARCHAR2(200 BYTE),
  PNUMBER      VARCHAR2(200 BYTE),
  TYPE         VARCHAR2(200 BYTE),
  CALL_DATE    VARCHAR2(100 BYTE),
  DURATION     VARCHAR2(100 BYTE),
  TIMESTAMP    TIMESTAMP(6),
  PHONE        VARCHAR2(100 BYTE),
  D_CALL_DATE  VARCHAR2(100),
  ERROR_TEXT    VARCHAR2(500)
);

GRANT SELECT ON SAUD.CALL_LOG_ERROR TO FRONT_END;