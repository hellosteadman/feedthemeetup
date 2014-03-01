drop table if exists user;
create table user (
	id integer primary key autoincrement,
	username text,
	password text
);

drop table if exists menu;
create table menu (
	id integer primary key autoincrement,
	name text not null,
	cover_price real,
	kind integer
);

drop table if exists quotation;
create table quotation (
	id integer primary key autoincrement,
	name text not null,
	email text not null
);

drop table if exists quotation_menu;
create table quotation_menu (
	id integer primary key autoincrement,
	menu_id integer,
	day integer
);