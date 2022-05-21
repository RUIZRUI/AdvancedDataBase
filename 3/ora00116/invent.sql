set define on
set verify off
select distinct part_id from part;
select sum(stock_qty) from part;