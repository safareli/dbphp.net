<?php

	//use this file to extend \user\base class with traits
	//to make custom user class
	namespace user;

	class user extends base
	{
		use \facebook\user;
		use \core\user;
		use \cashier\user;
	}

?>