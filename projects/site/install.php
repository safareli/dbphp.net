<?php

	//install units and parts for project
	//use \core\page and \core\part for easy function

	\core\part ('menu.view', true, 'Main');
	\core\part ('menu.scope', true, 'Main');
	\core\part ('menu.view', true, 'User');
	\core\part ('user.status', true);

	$manage->page ('home', 'Home', null, \core\accept::any);
	$manage->page ('login', 'Login', null, \core\accept::guest);

?>