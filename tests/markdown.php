<?php

	const project = 'site';

	include '../config.php';
	include './parsedown.php';

	$readme = system.'db/readme.md';

	if (!file_exists($readme))
	{
		echo "no readme.md found";
		exit;
	}

	$readme = file_get_contents($readme);

	$toc = explode("\n",trim(between('<!-- MarkdownTOC -->','<!-- /MarkdownTOC -->',$readme)));
	if (!is_array($toc) || !$toc)
	{
		echo "no toc found";
		exit;
	}

	$map = array ();
	foreach ($toc as $item)
	{
		$level = strlen(before('-',$item))/4;
		$title = between ('- [','](#', $item);
		$link = between ('(#',')',$item);
		$name = str_replace(array("-"),"_",$link);
		if ($level==0)
		{
			$parent = $name;
		}
		$page = array ();
		$page['id'] = null;
		$page['name'] = $name;
		$page['title'] = $title;
		$page['link'] = $link;
		$page['level'] = $level;
		if ($level>0)
		{
			$page['parent'] = $parent;
		}
		$page['text'] = null;
		$map[$name] = $page;
	}

	$readme = after ('<!-- /MarkdownTOC -->', $readme);
	$next = null;
	foreach (array_reverse($map) as $page)
	{
		if ($next!=null)
		{
			$map[$page['name']]['text'] = between(str_repeat('#',$page['level']+1).' '.$page['title'], str_repeat('#',$next['level']+1).' '.$next['title'], $readme);
		}
		else
		{
			$map[$page['name']]['text'] = after(str_repeat('#',$page['level']+1).' '.$page['title'], $readme);
		}
		$next = $page;
	}

	$parsedown = new Parsedown();

	$skin = str_replace("\\",'/',__DIR__).'/pages/';
	foreach ($map as &$page)
	{
		$page['text'] = $parsedown->text ($page['text']);
		//debug ($page['link']);
		if ($page['text'])
		{
			file_put_contents($skin.$page['name'].'.htm', $page['text']);
		}
	}

	$import = array (
		'solution'=>array(),
		'projects'=>array(
			'site'=>array(
				'name'=>'site'),
			'units'=>array(),
			'pages'=>array(),
			'menus'=>array()));
	$project = &$import['projects']['site'];
	$project['units']['menu.view.manual'] = array ('base'=>'menu.view','name'=>'manual','title'=>'Manual','global'=>true);
	$project['menus']['menu.view.manual'] = array ('name'=>'menu.view.manual','items'=>array());

	foreach ($map as &$page)
	{
		if ($page['text'])
		{
			$project['pages'][$page['name']] = array ('name'=>$page['name'],'link'=>$page['link'],'title'=>$page['title']);
		}
		$project['menus']['menu.view.manual']['items'][$page['name']] = array ('name'=>$page['name'],'title'=>$page['title'],'parent'=>$page['parent'], 'page'=>$page['name']);
	}

	include module ('menu');

	$database = new \db\database (hostname, database, username, password);
	$database->scan ('.core');
	$database->scan ('.menu');


	\core\import ($import);
	//debug ($import);
?>