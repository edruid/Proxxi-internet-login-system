DELIMITER $$
CREATE TRIGGER `groups_before_insert` BEFORE INSERT ON `groups`
FOR EACH ROW
BEGIN
	set @tmp_code_name = CONCAT('grant_tmp_', floor(rand()*1000000000));
	INSERT INTO accesses (name, code_name) VALUES
		(CONCAT('Grant "', NEW.name, '"'), @tmp_code_name);
	set NEW.access_id = (SELECT `access_id` 
		FROM accesses
		WHERE code_name = @tmp_code_name);
END $$
CREATE TRIGGER `groups_after_insert` AFTER INSERT ON `groups`
FOR EACH ROW
BEGIN
	UPDATE accesses SET code_name = CONCAT('grant_', NEW.group_id) WHERE access_id = NEW.access_id;
END $$
CREATE TRIGGER `groups_after_update` AFTER UPDATE ON `groups`
FOR EACH ROW
BEGIN
	UPDATE accesses SET name = CONCAT('Grant "', NEW.name, '"') WHERE access_id = NEW.access_id;
END $$

DELIMITER ;
