drop table log_part;
drop trigger tr1;
create table log_part
	(user_code	char(12),
	type		char(8),
	hour		char(20));
	
create trigger tr1 after update or delete or insert on part for each row
declare
	typ	char(8);
	hr	char(20);
begin
	if updating then typ := 'update'; 	end if;
	if deleting then typ := 'delete'; 	end if;
	if inserting then typ := 'insert'; 	end if;
	hr := to_char(sysdate,'dd-mm-yyyy hh:mm:ss');
	insert into log_part values(user,typ, hr);
end;
/
