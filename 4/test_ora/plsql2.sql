declare
     cursor c1 is
        select part_id, part_name, stock_qty, order_qty, min_qty 
	from part 
	where min_qty  >= (stock_qty + order_qty)
        order by part_id asc;   	-- ascending order on part_id
        
     my_part_id		part.part_id%TYPE;
     my_part_name 	part.part_name%TYPE;
     my_stock_qty	part.stock_qty%TYPE;
     my_order_qty	part.order_qty%TYPE;
     my_min_qty 	part.min_qty%TYPE;
     status		char(1) := 'A';

begin
    delete from part2;		-- initialize the table part2
    
    -- open the cursor c1, execute the select and set the pointer on the first row of the result
    open c1;			

    loop
        fetch c1 into my_part_id, my_part_name, my_stock_qty, my_order_qty, my_min_qty;
        exit when c1%notfound;   	/* exit from loop if no more row
					to process in the result of select */
        insert into part2 values (my_part_id, my_part_name, status);
        commit;
    end loop;

    close c1;		-- close cursor
end;
/
