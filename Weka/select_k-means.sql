SELECT `C`.`mac_id`,`C`.`day_frequency`,`C`.`reg_per_day`,`D`.`interval`,`C`.`day`
FROM (
	SELECT `A`.`mac_id`,`A`.`day_frequency`,`B`.`qt_reg`/`A`.`day_frequency` AS `reg_per_day`,`A`.`day`
	FROM (
		SELECT `mac_id` , COUNT( `day` ) AS `day_frequency`,`day`
			FROM (
				SELECT `mac_id` , 
				CASE 
					WHEN `timestmp` LIKE '2016-11-21%'
					THEN '2016-11-21'
					WHEN `timestmp` LIKE '2016-11-22%'
					THEN '2016-11-22'
					WHEN `timestmp` LIKE '2016-11-23%'
					THEN '2016-11-23'
					WHEN `timestmp` LIKE '2016-11-24%'
					THEN '2016-11-24'
					WHEN `timestmp` LIKE '2016-11-25%'
					THEN '2016-11-25'
					WHEN `timestmp` LIKE '2016-11-26%'
					THEN '2016-11-26'
					WHEN `timestmp` LIKE '2016-11-27%'
					THEN '2016-11-27'
				END AS `day` 
				FROM `raw_entries` 
				GROUP BY `mac_id` , `day`
			) AS `r1` 
			GROUP BY `mac_id`
		) AS `A`
	INNER JOIN
		(
			SELECT `mac_id` , COUNT(`timestmp`) AS `qt_reg`
			FROM `raw_entries`
			GROUP BY `mac_id`
		) AS `B`
	ON `A`.`mac_id` = `B`.`mac_id`) AS `C`
INNER JOIN
(
	SELECT `mac_id`, (
	(
	(
	CAST( SUBSTR( MAX( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MAX( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	) - (
	(
	CAST( SUBSTR( MIN( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MIN( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	)
	) AS `interval`
	FROM `raw_entries`
	WHERE `timestmp` LIKE '2016-11-21%'
	GROUP BY `mac_id`
	UNION
	SELECT `mac_id`, (
	(
	(
	CAST( SUBSTR( MAX( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MAX( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	) - (
	(
	CAST( SUBSTR( MIN( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MIN( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	)
	) AS `interval`
	FROM `raw_entries`
	WHERE `timestmp` LIKE '2016-11-22%'
	GROUP BY `mac_id`
	UNION
	SELECT `mac_id`, (
	(
	(
	CAST( SUBSTR( MAX( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MAX( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	) - (
	(
	CAST( SUBSTR( MIN( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MIN( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	)
	) AS `interval`
	FROM `raw_entries`
	WHERE `timestmp` LIKE '2016-11-23%'
	GROUP BY `mac_id`
	UNION
	SELECT `mac_id`, (
	(
	(
	CAST( SUBSTR( MAX( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MAX( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	) - (
	(
	CAST( SUBSTR( MIN( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MIN( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	)
	) AS `interval`
	FROM `raw_entries`
	WHERE `timestmp` LIKE '2016-11-24%'
	GROUP BY `mac_id`
	UNION
	SELECT `mac_id`, (
	(
	(
	CAST( SUBSTR( MAX( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MAX( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	) - (
	(
	CAST( SUBSTR( MIN( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MIN( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	)
	) AS `interval`
	FROM `raw_entries`
	WHERE `timestmp` LIKE '2016-11-25%'
	GROUP BY `mac_id`
	UNION
	SELECT `mac_id`, (
	(
	(
	CAST( SUBSTR( MAX( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MAX( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	) - (
	(
	CAST( SUBSTR( MIN( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MIN( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	)
	) AS `interval`
	FROM `raw_entries`
	WHERE `timestmp` LIKE '2016-11-26%'
	GROUP BY `mac_id`
	UNION
	SELECT `mac_id`, (
	(
	(
	CAST( SUBSTR( MAX( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MAX( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	) - (
	(
	CAST( SUBSTR( MIN( `timestmp` ) , 12, 2 ) AS UNSIGNED ) *60
	) + ( CAST( SUBSTR( MIN( `timestmp` ) , 15, 2 ) AS UNSIGNED ) )
	)
	) AS `interval`
	FROM `raw_entries`
	WHERE `timestmp` LIKE '2016-11-27%'
	GROUP BY `mac_id`
) AS `D`
ON `C`.`mac_id` = `D`.`mac_id`
ORDER BY `C`.`mac_id`