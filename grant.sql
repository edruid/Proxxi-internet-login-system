GRANT select, insert, update, delete ON pils4.user_groups TO 'pils4'@'localhost';
GRANT select, insert, update, delete ON pils4.group_access TO 'pils4'@'localhost';
GRANT select, insert ON pils4.memberships TO 'pils4'@'localhost';
GRANT select, insert ON pils4.attendance TO 'pils4'@'localhost';
GRANT select, insert, update ON pils4.blocked TO 'pils4'@'localhost';
GRANT select, insert, delete ON pils4.karaoke_queue TO 'pils4'@'localhost';
GRANT select, insert ON pils4.log TO 'pils4'@'localhost';
GRANT select, insert, update, delete ON pils4.sessions TO 'pils4'@'localhost';
GRANT select, insert, delete ON pils4.poll_alternatives TO 'pils4'@'localhost';
GRANT select, delete ON pils4.voters TO 'pils4'@'localhost';
GRANT select, insert, delete ON pils4.polls TO 'pils4'@'localhost';
GRANT select, insert, update, delete ON pils4.user_settings TO 'pils4'@'localhost';
GRANT select, insert, update, delete ON pils4.groups TO 'pils4'@'localhost';
GRANT select, insert, delete ON pils4.accesses TO 'pils4'@'localhost';
GRANT select, insert, update, delete ON pils4.settings TO 'pils4'@'localhost';
GRANT select, insert ON pils4.persistant_users TO 'pils4'@'localhost';
GRANT select, insert, update ON pils4.users TO 'pils4'@'localhost';
GRANT select, insert, delete ON pils4.avatars TO 'pils4'@'localhost';
GRANT execute ON PROCEDURE pils4.register_vote TO 'pils4'@'localhost';
