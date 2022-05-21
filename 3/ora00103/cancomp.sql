set define on
set verify off
prompt Enter a parent part number please
accept num1 number prompt 'number : '
prompt Enter a component part number please
accept num2 number prompt 'number : '
delete from component
where part_id=&num1 and component_id=&num2;