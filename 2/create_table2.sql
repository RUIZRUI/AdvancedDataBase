drop view purchase_pds;
drop view part_sks;

drop table detail;
drop table contractual;
drop table pa_task;
drop table pot_supplier;
drop table purchase_order;
drop table product;
drop table responsible;
drop table component;
drop table supplier;
drop table pa_agent;
drop table part;

-- first level
create table part
        (part_id        number(4)       primary key, 
        part_name       char(15)        not null, 
        unit            char(15)        not null, 
        unit_price      number(6,2)     not null, 
        min_qty         number(5)       not null, 
        stock_qty       number(5)       default 0,
        order_qty       number(5)       default 0);

create table pa_agent
        (emp_num        number(4)      	primary key,
        pa_name    	char(15)        not null);

create table supplier
        (supplier_id    number(4)       primary key,
        supplier_name 	char(15)        not null,
        addr        	char(20)        not null,
        contact         char(15)        not null);

-- second level
create table component
        (part_id         number(4)  constraint fk_component_part references part(part_id),
        component_id     number(4)  constraint fk_component_part2 references part(part_id),
        constraint pk_component primary key (part_id, component_id));
    
create table responsible
        (part_id         number(4)  constraint fk_responsible_part references part(part_id),
        emp_num          number(4)  constraint fk_responsible_pa references pa_agent(emp_num),
        constraint pk_responsible primary key (part_id, emp_num));

create table product
        (supplier_id     number(4) constraint fk_product_supplier references supplier(supplier_id),
        product_id       number(4),
        product_name     char(20)         not null,
        unit             number(5)        not null,
        unit_price       number(6,2)      not null,
        constraint pk_product primary key (supplier_id, product_id));

create table purchase_order
        (po_number     	 number(4)	primary key,
        po_date  	     char(8)         not null,
        total            number(6,2)     default 0,
        status           char(15)        default 'not_completed');


-- third level
create table pot_supplier
        (supplier_id        number(4) constraint fk_pot_supplier references supplier(supplier_id),
        product_id          number(4) not null,
        part_id             number(4) constraint fk_pot_part references part(part_id),
        constraint pk_pot_supplier primary key (supplier_id, product_id, part_id));

create table pa_task
        (emp_num            number(4) constraint fk_pa_task references pa_agent(emp_num),
        po_number           number(4) constraint fk_pa_po references purchase_order(po_number),
        constraint pk_pa_task primary key (emp_num, po_number));

create table contractual
        (supplier_id        number(4) constraint fk_contractual references supplier(supplier_id),
        po_number           number(4) constraint fk_contractual_po references purchase_order(po_number),
        constraint pk_contractual primary key (supplier_id, po_number));

create table detail
        (po_number          number(4) constraint fk_detail_po references purchase_order(po_number),
        product_id          number(4)   not null,
        qty_order           number(5)   not null,
        qty_rec             number(5)   not null,
        constraint pk_detail primary key (po_number, product_id));
        
create or replace view purchase_pds as
	select po_number,total from purchase_order;

create or replace view part_sks as  
        select stock_qty,unit_price from part;
