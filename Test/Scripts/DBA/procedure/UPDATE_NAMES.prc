CREATE OR REPLACE procedure SAUD.update_names
as
    cursor main_c
    is
        select pnumber,
    (select nvl(name,'*#$%') from call_log where d_call_date in (select min(d_call_date) from call_log where pnumber = c.pnumber)) min_name,
    (select name from call_log where d_call_date in (select max(d_call_date) from call_log where pnumber = c.pnumber)) max_name
    from call_log c
    group by pnumber
    having count(distinct nvl(name,'*#$%')) > 1;
    
    p_data main_c%ROWTYPE;
     BEGIN
     writelog('LOG','START of UPDATE_NAMES');
     OPEN main_c;

     LOOP
        FETCH main_c INTO p_data;
        EXIT WHEN main_c%NOTFOUND;
            --DBMS_OUTPUT.PUT_LINE(p_data.pnumber || ' ' || p_data.min_name || ' ' || p_data.max_name);
            
            update call_log
            set name = p_data.max_name
            where pnumber = p_data.pnumber
            and nvl(name,'*#$%') = p_data.min_name;

            writelog('UPDATE_NAME','Updated name for ' || p_data.pnumber || ' from ' || p_data.min_name || ' to ' || p_data.max_name || '. Rows updated ' || SQL%ROWCOUNT);
            
     END LOOP;

     CLOSE main_c;
     writelog('LOG','END of UPDATE_NAMES');
  END;
/
  
  
  
grant execute on saud.update_names to front_end;

create or replace  synonym front_end.update_names for saud.update_names ;