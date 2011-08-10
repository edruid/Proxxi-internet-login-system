CREATE TABLE `postnummer` (
	`postnr`  int(5) unsigned DEFAULT NULL,
	`zone`    varchar(20) DEFAULT NULL,
	`kommun`  varchar(20) DEFAULT NULL,
	`postort` varchar(20) DEFAULT NULL,
	KEY (`postnr`),
	PRIMARY_KEY (`kommun`, `postnr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

delimiter $$
create function yearly_attendance(_user_id int, _year int)
returns int
reads sql data
begin
	return (SELECT count(day)
	from attendance
	where user_id = _user_id and
		year(day) = _year);
end $$

create function is_member(_user_id int, _date date)
returns boolean
reads sql data
begin
	return exists (select 1
		from memberships
		where user_id = _user_id and
			_date between start and end);
end $$

create function in_kommun(_user_id int, _kommun text)
returns boolean
reads sql data
begin
	return exists (select 1
		from users
		join postnummer ON (postnr = area_code)
		where user_id = _user_id and
			_kommun = kommun
	);
end $$
delimiter ;
