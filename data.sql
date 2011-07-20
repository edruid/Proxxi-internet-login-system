INSERT INTO accesses set name='Redigera användare', code_name='edit_user';
INSERT INTO accesses set name='Redigera settings', code_name='edit_setting';
INSERT INTO accesses set name='Redigera rättigheter', code_name='edit_access';
INSERT INTO accesses set name='Redigera grupper', code_name='edit_group';
INSERT INTO accesses set name='Ge rättighet till grupp', code_name='edit_group_access';
INSERT INTO accesses set name='Se användare', code_name='view_user';
INSERT INTO accesses set name='Internet access', code_name='internet';
INSERT INTO accesses set name='Uppdatera medlemskap', code_name='edit_membership';

INSERT INTO settings set name='Visa när jag är i lokalen', code_name='show_attendance';
INSERT INTO settings set name='Visa telefonnummer för andra medlemmar', code_name='show_phone';
INSERT INTO settings set name='Visa epostadress för andra medlemmar', code_name='show_email';

INSERT INTO accesses set name='Grant "Admin"', code_name='grant_1';
INSERT INTO groups set name="Admin", access_id = (SELECT access_id from accesses where code_name="grant_1");

INSERT INTO group_access set access_id = (SELECT access_id from accesses where code_name="edit_group_access"), group_id = 1, permanent = true;
INSERT INTO group_access set access_id = (SELECT access_id from accesses where code_name="edit_group"), group_id = 1, permanent = true;
