set define on
set verify off
prompt Enter a part number please
accept num number prompt 'number : '
select p.part_id, p.part_name
from component c, part p
where c.part_id=p.part_id and c.component_id=&num;