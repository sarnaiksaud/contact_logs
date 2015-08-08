select * from xla_reference

create table xla_reference_structure
(
type VARCHAR2(20),
C01_HEADER VARCHAR2(20),
C02_HEADER VARCHAR2(20),
C03_HEADER VARCHAR2(20),
C04_HEADER VARCHAR2(20),
C05_HEADER VARCHAR2(20),
C06_HEADER VARCHAR2(20),
C07_HEADER VARCHAR2(20),
C08_HEADER VARCHAR2(20),
C09_HEADER VARCHAR2(20),
C10_HEADER VARCHAR2(20),
N01_HEADER VARCHAR2(20),
N02_HEADER VARCHAR2(20),
N03_HEADER VARCHAR2(20),
N04_HEADER VARCHAR2(20),
N05_HEADER VARCHAR2(20),
N06_HEADER VARCHAR2(20),
N07_HEADER VARCHAR2(20),
N08_HEADER VARCHAR2(20),
N09_HEADER VARCHAR2(20),
N10_HEADER VARCHAR2(20),
D01_HEADER VARCHAR2(20),
D02_HEADER VARCHAR2(20),
D03_HEADER VARCHAR2(20),
D04_HEADER VARCHAR2(20),
D05_HEADER VARCHAR2(20),
D06_HEADER VARCHAR2(20),
D07_HEADER VARCHAR2(20),
D08_HEADER VARCHAR2(20),
D09_HEADER VARCHAR2(20),
D10_HEADER VARCHAR2(20),
timestamp timestamp default SYSDATE
);


create or replace view longest_call as
select * from call_log
where duration in (select max(TO_NUMBER(duration)) from call_log)

CREATE OR REPLACE FUNCTION SAUD.get_number_type (p_number VARCHAR2)
RETURN NUMBER
AS
--DECLARE
    pnumber VARCHAR(20);
    plength NUMBER;
    ntype NUMBER;
BEGIN

    --for c in (select distinct length(pnumber) len from call_log order by 1) loop
        --select pnumber,length(pnumber) into pnumber,plength from call_log where length(pnumber) = c.len and rownum <= 1;
        --DBMS_OUTPUT.PUT_LINE('PNUMBER : ' || pnumber);
        
        pnumber := p_number;
        plength := length(pnumber);
        
        IF plength between 0 and 2 THEN
            ntype := 0;
            --DBMS_OUTPUT.PUT_LINE(plength || ' - ' || pnumber || ' - INVALID NUMBER');
        ELSIF plength between 3 and 7 THEN
            ntype := 1;
            --DBMS_OUTPUT.PUT_LINE(plength || ' - ' || pnumber || ' - CC NUMBER');
        ELSIF plength between 8 and 9 THEN
            ntype := 2;
            --DBMS_OUTPUT.PUT_LINE(plength || ' - ' || pnumber || ' - LL NUMBER');
        ELSIF plength = 10 THEN
            ntype := 3;
            --DBMS_OUTPUT.PUT_LINE(plength || ' - ' || pnumber || ' - MOBILE NUMBER NOT FORMATTED');
        ELSIF plength = 11 THEN
            IF regexp_like(pnumber,'022') THEN
                ntype := 2;
            ELSE
                ntype := 4;
            END IF;
            --DBMS_OUTPUT.PUT_LINE(plength || ' - ' || pnumber || ' - TOLL FREE FORMATTED');
        ELSIF plength = 13 THEN
            ntype := 5;            
            --DBMS_OUTPUT.PUT_LINE(plength || ' - ' || pnumber || ' - MOBILE NUMBER FORMATTED');
        ELSE
            ntype := 6;
            --DBMS_OUTPUT.PUT_LINE(plength || ' - ' || pnumber || ' - INTERNATIONAL NUMBER');
        END IF;
        --DBMS_OUTPUT.PUT_LINE(ntype || ' TYPE ');
    --end loop;
    RETURN ntype;
END;
/

CREATE TABLE CHECK_TABLE
as
SELECT * FROM DUAL;