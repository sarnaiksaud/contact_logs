CREATE OR REPLACE function SAUD.get_cost(p_duration number,p_number call_log.pnumber%type default null)
return number
is
return_value number := -1;
p_type1 number_categorization.type1%type;
p_type2 number_categorization.type2%type;
begin

if p_number is null and p_duration is null then
return -1;
end if;

Begin
    select type1,type2  into p_type1,p_type2
    from number_categorization
    where pnumber = p_number;
exception
    when others then
    p_type1 := 'N';
    p_type2 := 'N';
end ;

select NVL(sum(ceil(NVL(p_duration,0)/60)*NVL(rate,1)),0)
into return_value
from
call_reference cr1, call_reference cr2, tariff_cube tc
 where CR1.TYPE = 'TYPE1'
 and cr2.type = 'TYPE2'
 and cr1.char_value = NVL(p_type1,'N')
 and cr2.char_value = NVL(p_type2,'N')
 and tc.type1 = cr1.char_value
 and tc.type2 = cr2.char_value;
 
 return return_value;
 
 exception 
 when others then return return_value;
 end;
/