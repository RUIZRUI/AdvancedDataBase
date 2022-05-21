declare
     my_part_id		part.part_id%TYPE;
     status		char(1);

/* Declare the local procedure mod_status*/
     procedure mod_status (num number) is
     	begin
     		update part2 set status='I' where part_id = num;
     	end; 

begin
    my_part_id := 1001;		-- initialize part_id of part2
    mod_status (my_part_id);
    commit;
end;
/
