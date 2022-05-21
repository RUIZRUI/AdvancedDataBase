set define on
set verify off
select pa.emp_num, pa.pa_name, p.part_id, p.part_name 
from responsible r, part p, pa_agent pa
where r.part_id=p.part_id and r.emp_num=pa.emp_num;