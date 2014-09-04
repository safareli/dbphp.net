<?php

	include './config.php';

	debug ('working on '.server);

	$link = new \db\link(null, hostname, username, password);

	if (defined('database'))
	{
		$link->debug = true;
		$result = $link->query ("SELECT CONCAT('DROP TABLE IF EXISTS `".database."`.`', table_name, '`') FROM information_schema.tables WHERE table_schema = '".database."'");
		if ($result)
		{
			foreach ($result as $row)
			{
				$link->query ($row[0]);
			}
		}
		$link->debug = false;
	}

	apc_clear_cache ('user');
?>