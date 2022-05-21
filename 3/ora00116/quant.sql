set define on
set verify off
prompt Enter a emu number please
accept num number prompt 'number: ' 
select po.po_number, po.po_date, po.total, po.status 
from pa_task pt, purchase_order po 
where po.po_number=pt.po_number and pt.emp_num=&num;