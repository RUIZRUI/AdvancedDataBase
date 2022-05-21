set define on
set verify off
prompt Enter a part number please
accept num number prompt 'number : '
select p.supplier_id, p.product_id, p.unit, p.unit_price
from pot_supplier pot, product p
where pot.part_id=&num and pot.product_id=p.product_id;