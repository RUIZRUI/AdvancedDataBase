set define on
set verify off
prompt Enter a po number please
accept num1 number prompt 'number : '
insert into purchase_order values (&num1, '22-5-20', 0, 'not_completed')