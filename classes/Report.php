<?php
class Report {
	public static function lokalbidrag($year, $days) {
		global $db;
		$data = array();
		$stmt = $db->prepare_full("
			SELECT
				CONCAT(MIN(age), '-', MAX(age)) as ages,
				kommun,
				sex,
				count(*) as count
			FROM
				(
				SELECT
					? - year(birthdate) - 1 as age,
					in_kommun(user_id, 'Stockholm') AS kommun,
					sex
				FROM
					users
				WHERE
					yearly_attendance(user_id, ?) >= ?
				) u
			GROUP BY
				kommun,
				sex,
				CASE
				WHEN age < 7 THEN 0
				WHEN age < 10 THEN 1
				WHEN age < 13 THEN 2
				WHEN age < 17 THEN 3
				WHEN age < 21 THEN 4
				ELSE 5
				END
			ORDER BY
				kommun desc, sex, age
			", $data, 'iii',  $year, $year, $days
		);
		while($stmt->fetch()) {
			$tnp = array();
			foreach($data as $key => $value) {
				$tmp[$key] = $value;
			}
			$ret[] = $tmp;
		}
		return $ret;
	}

	public static function attendance_grant($year, $days) {
		global $db;
		$data = array();
		$stmt = $db->prepare_full("
			SELECT
				CONCAT(MIN(age), '-', MAX(age)) as ages,
				sex,
				sum(
					CASE
					WHEN attendance < ? THEN 0
					WHEN attendance > 120 THEN 120
					ELSE attendance
					END
				) as attendance
			FROM
				(
				SELECT
					? - year(birthdate) - 1 as age,
					yearly_attendance(user_id, ?) AS attendance,
					sex
				FROM
					users
				) u
			GROUP BY
				sex,
				CASE
				WHEN age < 7 THEN 0
				WHEN age < 10 THEN 1
				WHEN age < 13 THEN 2
				WHEN age < 17 THEN 3
				WHEN age < 21 THEN 4
				ELSE 5
				END
			ORDER BY
				sex, age
			", $data, 'iii',  $days, $year, $year
		);
		while($stmt->fetch()) {
			$tnp = array();
			foreach($data as $key => $value) {
				$tmp[$key] = $value;
			}
			$ret[] = $tmp;
		}
		return $ret;
	}
}
?>
