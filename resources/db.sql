INSERT INTO freelancers (user_id)
SELECT DISTINCT s.user_id
FROM skills s
JOIN users u ON s.user_id = u.id
WHERE u.user_role = 'freelancer';

SELECT u.first_name, u.last_name, s.skill
FROM users u
JOIN skills s ON u.id = s.user_id
JOIN freelancers f ON f.user_id = u.id;


DELIMITER $$
CREATE TRIGGER insert_freelancer
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    IF NEW.user_type = 'freelancer' THEN
        INSERT INTO freelancers (user_id) VALUES (NEW.id);
    END IF;
END;
$$

DELIMITER $$

CREATE TRIGGER delete_freelancer
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    IF NEW.user_type != 'freelancer' AND OLD.user_type = 'freelancer' THEN
        DELETE FROM freelancers WHERE user_id = NEW.id;
    END IF;
END;
$$

DELIMITER ;
