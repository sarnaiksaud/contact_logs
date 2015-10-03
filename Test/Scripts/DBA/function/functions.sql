CREATE OR REPLACE FUNCTION get_number_type (p_number VARCHAR2)
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

create or replace function
login_cre_p
(p_username varchar2,p_password varchar2)
return number
as
cnt number := 0;
return_data number := -1;
begin
select count(*) into cnt from login_cre where username = p_username and password = p_password;
if(cnt >= 1) then
    return_data := 1;
    update login_cre set last_login = SYSTIMESTAMP where username = p_username and password = p_password;
end if;
commit;
return return_data;
end;