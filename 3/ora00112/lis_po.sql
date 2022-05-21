set define on
set verify off
prompt Enter a po number please
accept num number prompt 'number : '
select po.po_number, po.po_date, pa.pa_name, s.supplier_id, s.supplier_name, s.addr, s.contact, p.product_id, p.product_name, p.unit, p.unit_price, d.qty_order, d.qty_rec
from purchase_order po, contractual c, pa_task pt, pa_agent pa, supplier s, detail d, product p
where po.po_number=&num and c.po_number=&num and pt.po_number=&num and pa.emp_num=pt.emp_num and s.supplier_id=c.supplier_id and d.po_number=&num and d.product_id=p.product_id;