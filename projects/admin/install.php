<?php

	//admin project non-common installation directives
	//also this file will lounch project(s) installation script(s)

	$manage = new \core\manage ('admin');

	$manage->page ('cashiers', 'Cashier');
	$manage->page ('currencys', 'Currencys');

	\core\part ('cashier.cashiers', 'cashiers');
	\core\part ('cashier.currencys', 'currencys');

	$manage->menu ('cashiers', 'Cashier', 'cashiers');
	$manage->menu ('cashiers', 'Cashiers', 'cashiers', 'cashiers');
	$manage->menu ('currencys', 'Currencys', 'currencys', 'cashier');


	$manage = new \core\manage ('site');
	include $manage->project->path('install');

	$manage = new \core\manage ($system->input->manage->value);

?>