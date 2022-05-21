declare
    num  number := 100;	-- initializate num
begin
    delete from emp;	-- initialize table emp
    for i in 1..5
    loop
		insert into emp (emp_num, emp_name) values (num, concat ('employee_name',i));
		num := num + 100;        
    end loop;
    commit;
end;
/
