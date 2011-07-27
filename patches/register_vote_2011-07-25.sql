DELIMITER $$

CREATE PROCEDURE register_vote (IN user_id int, IN alternative_id int)
MODIFIES SQL DATA
begin
	insert into voters(user_id, poll_id) VALUES
		(user_id,
		(select poll_id from poll_alternatives where poll_alternative_id = alternative_id));
	update poll_alternatives set num_votes = num_votes + 1
		WHERE  poll_alternative_id = alternative_id;
end$$
DELIMITER ;
GRANT execute ON PROCEDURE pils4.register_vote TO 'pils4'@'localhost';
