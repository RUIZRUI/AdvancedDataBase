set define on
set verify off
prompt Enter a part number please
accept num1 number prompt 'part number: '
prompt Enter a pa number please
accept num2 number prompt 'pa number: '
update responsible
set emp_num=&num2
where part_id=&num1;