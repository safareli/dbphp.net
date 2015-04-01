<?php

	include '../config.php';

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
		$name = between ('(#',')',$item);
		if ($level==0)
		{
			$parent = $name;
		}
		$page = array ();
		$page['id'] = null;
		$page['name'] = $name;
		$page['title'] = $title;
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

	foreach ($map as &$page)
	{
/*		$text = new \tool\text ($page['text']);
		while ($text->next('**','**'))
		{
			debug ($text->result);
		}*/
		$on = false;
		while (strpos($page['text'],'**')!==false)
		{
			$page['text'] = before('**',$page['text']).(!$on?'<b><i>':'</i></b>').after('**',$page['text']);
			if ($on){$on=false;}else{$on=true;};
		}
		echo "<h1>".$page['title']."</h1>";
		echo "<pre>".$page['text']."</pre>";
	}

?>