set define on
set verify off
prompt Enter a part number please
accept num number prompt 'number : '
prompt Enter the qty taken out please
accept qty number prompt 'qty : '
update part
set stock_qty = (select stock_qty from part where part_id=&num)-&qty
where part_id=&num;
