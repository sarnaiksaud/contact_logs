create or replace view show_data
as
select * from check_table;

grant select on saud.show_data to front_end;

create or replace  synonym front_end.show_data for saud.show_data ;