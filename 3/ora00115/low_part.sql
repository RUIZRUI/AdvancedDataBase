set define on
set verify off
prompt Enter a pa number please
accept num number prompt 'number : '
select p.part_id, p.part_name
from responsible r, part p
where r.emp_num=&num and r.part_id=p.part_id and p.stock_qty+p.order_qty<=p.min_qty;