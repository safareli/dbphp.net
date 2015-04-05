<?php

error_reporting(E_ALL^E_NOTICE);

include './db.php';
include './galaxy.php';

//setup database object and establish link to db server
//please change this string with your actual db server settings
$database = new \db\database('mysql:127.0.0.1', 'galaxy_db', 'commet', 'pass1234');

$database->scan ('\galaxy'); //scan all classes of namespace galaxy

//in case you downloaded this script and are refreshing for the second time
//let us truncate previously created table data
$database->link()->query("truncate ".$database->galaxy->star->name());
$database->link()->query("truncate ".$database->galaxy->planet->name());
$database->link()->query("truncate ".$database->galaxy->moon->name());
//link returns default link, but they can be many

$database->update(); //create tables and fields (magic)
//remember by this function you dont need to create any tables manyally
//to run this script just specify link, user and previously created db name
//(or user with create db permission and $database will create specified db if not exists)

//create some star alpha
$alpha = $database->save(new \galaxy\star('alpha'));
//and its planet xxx which has water
$database->save (new \galaxy\planet($alpha,'xxx',1,true),\db\query::insert);
//why ,\db\query::insert ? because planet::name is declared as primary in galaxy.php
//database asumes that the object already exists and will try to update
//but we know that it does not exist and we force him to insert planet instead of update
//by specifing \db\query::insert mode

//create sun and save
$sun = $database->save(new \galaxy\star ('sun')); //or $database->galaxy->star->save()

//add some our solar system planets
$database->save (new \galaxy\planet($sun,'mars',4,true),\db\query::insert); //has water drops
$database->save (new \galaxy\planet($sun,'venus',2,false),\db\query::insert);
$database->save (new \galaxy\planet($sun,'mercury',1,false),\db\query::insert);
$database->save (new \galaxy\planet($sun,'earth',3,true),\db\query::insert); //has water

$result = $database->galaxy->planet->load();
//\db\debug ($result); //very usefull function! if you download code will see it in action
if ($result['xxx'] && $result['earth'])
{
	//as we defined planet::name as primary property for planet
	//planet::name value is used as $result array key on planets load
	//so as ->load returns all planets available in table we will have
	//$result['xxx'] and $result['earth'] available in result
	foreach ($result as $planet)
	{
		//echo $planet->star->name.", ";
		//echoes something like alpha, sun, sun, sun, sun,
		//$planet->star is object because we defined it as @var \galaxy\star
		//and this means realtion for db.php
	}
}

//simply load all sun's planets with water
$result = $database->galaxy->planet->load (\db\by('star',$sun)->by('water',true));
//result will be in order mars, earth
if ($result['mars'])
{
	//let us create sum moons
	//planet::moons has 'enum' flug so it can support many to many relation
	$result['mars']->add ($database->save(new \galaxy\moon('fobos')));
	$result['mars']->add ($database->save(new \galaxy\moon('deimos')));
	$result['mars']->add ($database->save(new \galaxy\moon('moon')));
	$database->save ($result['mars']);
}
unset ($result);
//my appologies as I attached moon named moon to mars

//load all moons to fill db cache
//as we setted up cache 'load' for moons table
//moons will be available in cache if we load all them
$database->galaxy->moon->load();
//this is useful because in other case on every planet load
//moon load queries will be executed as planet::moons holds
//\galaxy\moon objects with many to many relation type (enum)

//well let us load all sun's planets with life in correct order now
$table = &$database->galaxy->planet; //hold planet class handler in $planets
$query = new \db\query();
$query->where->string = $table->field('star')."='".\db\id($sun)."' and ".$table->value('water',true);
$query->order->field('order');//you can ad multiple fields with order methods
$query->limit->count = 10;

$database->debug(); //this is to debug what query will be used by database
$planets = $table->load($query);
$database->debug(false); //turn off debug query
/*GENERATED QUERY:
SELECT `galaxy_db`.`galaxy_planet`.`name`, `galaxy_db`.`galaxy_planet`.`order`, `galaxy_db`.`galaxy_planet`.`water`, `galaxy_db`.`galaxy_planet`.`star`, `galaxy_db`.`galaxy_star`.`id`, `galaxy_db`.`galaxy_star`.`name`, `galaxy_db`.`galaxy_planet`.`moons`
FROM `galaxy_db`.`galaxy_planet`
LEFT JOIN `galaxy_db`.`galaxy_star` ON `galaxy_db`.`galaxy_planet`.`star`=`galaxy_db`.`galaxy_star`.`id`
WHERE `galaxy_db`.`galaxy_planet`.`star`='2' AND `galaxy_db`.`galaxy_planet`.`water`='1'
ORDER BY `galaxy_db`.`galaxy_planet`.`order`ASC
LIMIT 10
*/

\db\debug($planets); //display result
/*RESULT:
array  (
    'earth'  =
    galaxy\planet::__set_state(array(
          'name'  =  'earth',
          'order'  =  3,
          'water'  =  true,
          'star'  =
        galaxy\star::__set_state(array(
              'id'  =  2,
              'name'  =  'sun',
        )),
          'moons'  =
        array  (
        ),
    )),
    'mars'  =
    galaxy\planet::__set_state(array(
          'name'  =  'mars',
          'order'  =  4,
          'water'  =  true,
          'star'  =
        galaxy\star::__set_state(array(
              'id'  =  2,
              'name'  =  'sun',
        )),
          'moons'  =
        array  (
            1  =
            galaxy\moon::__set_state(array(
                  'id'  =  1,
                  'name'  =  'fobos',
            )),
            2  =
            galaxy\moon::__set_state(array(
                  'id'  =  2,
                  'name'  =  'deimos',
            )),
            3  =
            galaxy\moon::__set_state(array(
                  'id'  =  3,
                  'name'  =  'moon',
            )),
        ),
    )),
)
*/
if ($planets)
{
	//so here we have first earth than mars in $planets array
}

//now lets load mars and remove moon named moon
$mars = $database->galaxy->planet->load('mars');
//as planet::name is primary we can load object by primary key

unset($mars->moons[end($mars->moons)->id]); //as moon named moon was last
$database->save ($mars);

//the world is saved now
?>