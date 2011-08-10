Update users set 
	username = concat('username', user_id),
	first_name = concat('first_name', user_id),
	surname = concat('surname', user_id),
	email = concat('email', user_id, '@proxxi.org'),
	person_id_number = null,
	phone1 = concat('640-31', user_id),
	phone2 = concat('640-32', user_id),
	co = concat('co', user_id),
	street_address = concat('street_address', user_id),
	password = concat('password', user_id),
	nthash = concat('nthash', user_id)
WHERE
	user_id not in (100);

update log set
	description = 'anonymized description'
WHERE
	action not in ('login', 'logout', 'remlogin', 'remlogout', 'remright', 'addright', 'creauser', 'pressent', 'block', 'multlogout', 'multlogin');
