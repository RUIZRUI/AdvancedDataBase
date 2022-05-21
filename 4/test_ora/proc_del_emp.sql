create procedure del_emp(num number) as
begin
	delete from emp where emp_num = num;
end;
/
