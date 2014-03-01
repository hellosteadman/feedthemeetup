alter table quotation add column price real;

drop table if exists quotation_meal;
create table quotation_meal (
	id integer primary key autoincrement,
	quotation_id integer,
	mealprice_id integer
);