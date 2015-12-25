create or replace function get_cost(p_number call_log.pnumber%type default null,p_name call_log.name%type default null)
return number
is
return_value number := -1;

begin

if p_number is null and p_name is null then
return -1;
end if;

select NVL(sum(ceil(NVL(duration,0)/60)*NVL(rate,1)),0)
into return_value
from
 call_log c, call_reference cr1, call_reference cr2, number_categorization nc, tariff_cube tc
 where c.pnumber = nc.pnumber
 and CR1.TYPE = 'TYPE1'
 and cr2.type = 'TYPE2'
 and cr1.char_value = NVL(nc.type1,'N')
 and cr2.char_value = NVL(nc.type2,'N')
 and nc.type1 = tc.type1
 and nc.type2 = tc.type2
 and c.type = 'Outgoing'
 and c.pnumber = nvl(p_number,c.pnumber)
 and C.NAME = nvl(p_name,c.name)
 and c.duration <> '0';
 
 return return_value;
 
 exception 
 when others then return return_value;
 end;
 /