drop view number_cat;

create view number_cat
as
select pnumber,(select description from CALL_REFERENCE where table_name = 'NUMBER_CATEGORIZATION' and type = 'TYPE1' and char_value = n.type1) MOBILE_OP,
(select description from CALL_REFERENCE where table_name = 'NUMBER_CATEGORIZATION' and type = 'TYPE2' and char_value = n.type2) LOCALITY
 from NUMBER_CATEGORIZATION n;
 
grant select on saud.number_cat to front_end ;

create or replace  synonym front_end.number_cat for saud.number_cat;