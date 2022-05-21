-- Incomplete example of table creation for TUT-Lab2 8trd157
-- Paul Girard Ph.D. UQAC

drop view purchase_pds;

drop table purchase_order;
drop table supplier;
drop table pa_agent;

create table pa_agent
        (emp_num        number(4)      	primary key,
        pa_name    	char(15)        not null);

create table supplier
        (supplier_id    number(4)       primary key,
        supplier_name 	char(15)        not null,
        addr        	char(20)        not null,
        contact         char(15)        not null);

create table purchase_order
        (po_number     	number(4)	primary key,
        po_date  	char(8)         not null,
        total           number(5,2)     default 0,
        status          char(15)        default 'not_completed');
        
create or replace view purchase_pds as
	select po_number,total from purchase_order;       
