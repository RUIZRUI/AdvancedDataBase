set define on
set verify off
prompt Enter a part number please
accept num number prompt 'number : '
column unit_price format $99,999.99 heading 'price'
column part_name heading 'Name of part'
select part_id "Number", part_name, stock_qty "quant in stock", unit_price
from part where part_id=&num; 