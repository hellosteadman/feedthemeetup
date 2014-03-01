drop table if exists mealprice;
create table mealprice (
	id integer primary key autoincrement,
	name text not null,
	price real not null
);