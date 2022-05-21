drop procedure del_part2;
create procedure del_part2(no number) as
begin
	delete from part2 where part_id = no;
end;
/
