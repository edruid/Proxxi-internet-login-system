SELECT 'Migrate users';
INSERT INTO users (
	user_id, username, first_name, sex, birthdate, person_id_number, surname,
	email, phone1, phone2, co, street_address, area_code, area, password, nthash
) SELECT
	userid, uname, forename, sex, birthdate, personalnr, surname, email, tel, alttel,
	'', stradr, postnr, postadr, pass, nthash
FROM pils.users;

SELECT 'Create groups';
INSERT INTO groups (name) VALUES
	('Internet'),
	('Nyckelbärare'),
	('Ge internet'),
	('Flerdatorinloggning'),
	('Nyhetsskapare'),
	('Datoradministratör'),
	('Karaoke admin'),
	('Kiosk admin'),
	('Firmatecknare Ix'),
	('Se användare'),
	('Firmatecknare Proxxi'),
	('PILS administratör');

SELECT 'Create group accesses';
INSERT INTO group_access (access_id, group_id, permanent) VALUES
	((SELECT access_id FROM accesses WHERE code_name = 'edit_user'           ), (SELECT group_id FROM groups WHERE name = 'Nyckelbärare'        ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'edit_user'           ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Proxxi'), true),
	((SELECT access_id FROM accesses WHERE code_name = 'edit_user'           ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'edit_setting'        ), (SELECT group_id FROM groups WHERE name = 'PILS administratör'  ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'edit_access'         ), (SELECT group_id FROM groups WHERE name = 'PILS administratör'  ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'edit_group'          ), (SELECT group_id FROM groups WHERE name = 'PILS administratör'  ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'edit_group_access'   ), (SELECT group_id FROM groups WHERE name = 'PILS administratör'  ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'view_user'           ), (SELECT group_id FROM groups WHERE name = 'Se användare'        ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'internet'            ), (SELECT group_id FROM groups WHERE name = 'Internet'            ), true),
	((SELECT access_id FROM accesses WHERE code_name = 'edit_membership'     ), (SELECT group_id FROM groups WHERE name = 'Nyckelbärare'        ), true),
	((SELECT access_id FROM groups   WHERE name =      'Admin'               ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Internet'            ), (SELECT group_id FROM groups WHERE name = 'Ge internet'         ), true),
	((SELECT access_id FROM groups   WHERE name =      'Nyckelbärare'        ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Proxxi'), true),
	((SELECT access_id FROM groups   WHERE name =      'Ge internet'         ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Nyhetsskapare'       ), (SELECT group_id FROM groups WHERE name = 'Nyckelbärare'        ), true),
	((SELECT access_id FROM groups   WHERE name =      'Nyhetsskapare'       ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Proxxi'), true),
	((SELECT access_id FROM groups   WHERE name =      'Nyhetsskapare'       ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Datoradministratör'  ), (SELECT group_id FROM groups WHERE name = 'Nyckelbärare'        ), true),
	((SELECT access_id FROM groups   WHERE name =      'Datoradministratör'  ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Karaoke admin'       ), (SELECT group_id FROM groups WHERE name = 'Nyckelbärare'        ), true),
	((SELECT access_id FROM groups   WHERE name =      'Kiosk admin'         ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Proxxi'), true),
	((SELECT access_id FROM groups   WHERE name =      'Firmatecknare Ix'    ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Se användare'        ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Proxxi'), true),
	((SELECT access_id FROM groups   WHERE name =      'Se användare'        ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Firmatecknare Proxxi'), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Proxxi'), true),
	((SELECT access_id FROM groups   WHERE name =      'PILS administratör'  ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Flerdatorinloggning' ), (SELECT group_id FROM groups WHERE name = 'Firmatecknare Ix'    ), true),
	((SELECT access_id FROM groups   WHERE name =      'Flerdatorinloggning' ), (SELECT group_id FROM groups WHERE name = 'Nyckelbärare'        ), true),
	((SELECT access_id FROM groups   WHERE name =      'Flerdatorinloggning' ), (SELECT group_id FROM groups WHERE name = 'Ge internet'         ), true);

SELECT 'Migrate accesses';
INSERT INTO user_groups (user_id, group_id, valid_until, permanent)
	SELECT
		userid,
		CASE rights
			WHEN 'internet'   THEN (SELECT group_id from groups WHERE name = 'Internet')
			WHEN 'edinternet' THEN (SELECT group_id from groups WHERE name = 'Ge internet')
			WHEN 'creauser'   THEN (SELECT group_id from groups WHERE name = 'Nyckelbärare')
			WHEN 'multlogg'   THEN (SELECT group_id from groups WHERE name = 'Flerdatorinloggning')
			WHEN 'addnews'    THEN (SELECT group_id from groups WHERE name = 'Nyhetsskapare')
			WHEN 'winadmin'   THEN (SELECT group_id from groups WHERE name = 'Datoradministratör')
			WHEN 'karaoke'    THEN (SELECT group_id from groups WHERE name = 'Karaoke admin')
			WHEN 'kioskAdmin' THEN (SELECT group_id from groups WHERE name = 'Kiosk admin')
			WHEN 'proxxi'     THEN (SELECT group_id from groups WHERE name = 'Firmatecknare Ix')
			WHEN 'viewer'     THEN (SELECT group_id from groups WHERE name = 'Se användare')
			WHEN 'editright'  THEN (SELECT group_id from groups WHERE name = 'Firmatecknare Proxxi')
		END,
		CASE valid
			WHEN '1980-01-01' THEN NULL
			ELSE valid
		END,
		valid = '1980-01-01'
	FROM pils.rights;

SELECT 'Migrate settings';
SELECT 'show attendance';
INSERT INTO user_settings (setting_id, user_id, value)
	SELECT
		(SELECT setting_id FROM settings WHERE code_name = 'show_attendance'),
		userid,
		NOT anonymos
	FROM pils.users;

SELECT 'show phonenumber';
INSERT INTO user_settings (setting_id, user_id, value)
	SELECT
		(SELECT setting_id FROM settings WHERE code_name = 'show_phone'),
		userid,
		showtel
	FROM pils.users;

SELECT 'show email';
INSERT INTO user_settings (setting_id, user_id, value)
	SELECT
		(SELECT setting_id FROM settings WHERE code_name = 'show_email'),
		userid,
		showemail
	FROM pils.users;

SELECT 'Migrate blocked';
INSERT INTO blocked (user_id, admin, until, reason)
	SELECT 
		blocked,
		blocker,
		blockedto,
		message
	FROM
		pils.blocked b
	WHERE
		b.blockedto > NOW();

SELECT 'Migrate log';
INSERT INTO log (log_id, user_id, admin, time, description, action)
	SELECT
		actionnr,
		CASE
			WHEN edited = 0 OR edited IS NULL THEN userid
			ELSE edited
		END,
		CASE 
			WHEN edited = 0 OR edited IS NULL THEN NULL
			ELSE userid
		END,
		time,
		description,
		action
	FROM pils.log
	WHERE
		edited = 0 OR
		edited IS null OR
		edited in (select user_id from users);

SELECT 'Migrate memberships';
INSERT INTO memberships (user_id, start, end)
	SELECT userid, memstart, memfin
	FROM pils.members;

SELECT 'Migrate attendance';
INSERT INTO attendance (user_id, day)
	SELECT userid, day
	FROM pils.pressence;

SELECT '============ TODO: ============' as TODO;
SELECT 'Migrate polls';
SELECT 'Migrate poll alternetives';
SELECT 'Migrate voters';
SELECT 'Migrate user settings for: address';
SELECT 'Migrate area code - municipial database';
SELECT 'Migrate avatars (cant be done in this script)';
