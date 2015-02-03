<?php

	//for the first run if project specific database is empty
	//this file will create default tables and will install
	//fresh copy of admin and site projects

	//$database->debug ();

	//admin menu scope became global
	//add menu item parts
	//create page units
	//add menu item units

	//$system->debug = true;

	//$database->debug();


    new \core\input ('manage', 'iotareader', true);
    $manage = new \core\manage ($system->request['manage']);

	if ($system->install)
	{
		class setup
		{
			public $unit;
			public $type;
			public $layout;
			public $upload;
			public $menu;
			public function __construct ()
			{
				$this->unit = new \stdClass();
				$this->type = new \stdClass();
				$this->layout = new \stdClass();
				$this->upload = new \stdClass();
				$this->menu = new \stdClass();
			}
		}

		$admin = new setup ();


		$database->save (new \user\user('admin','123456'));

		$system->unit('core.manage', $system->project, true);

		//$system->unit('menu.load', $system->project, true);

		//$system->unit('page.title',null,true);
		$admin->unit->title = $system->unit('page.title')->save();
		$database->save (new \core\plug(null,$admin->unit->title, 'Title'));
		$system->unit('page.add')->part('pages');
		$system->unit('page.edit')->part('pages')->part('texts')->part('layouts')->part('news')->part('gallery');
		$system->unit('page.list')->part('pages');

		$system->unit('user.users')->part('users');
		$system->unit('user.groups')->part('users');

		$system->unit('menu.create')->part('menus');
		$system->unit('menu.modify')->part('menus');
		$system->unit('menu.select')->part('menus');
		$system->unit('menu.add')->part('menus');
		$system->unit('menu.edit')->part('menus');
		$system->unit('menu.list')->part('menus');

		$system->unit('layout.create')->part('layouts');
		$system->unit('layout.edit')->part('layouts');
		$database->save(new \core\type (null, $system->page('layouts'), 'custom'));

		$system->unit('news.storys')->part('news');
		$system->unit('news.events')->part('news');
		$system->unit('news.categorys')->part('news');
		$system->unit('news.topics')->part('news');
		$system->unit('news.picks')->part('news');
		$database->save (new \upload\field('news',null,800,600));
		$database->save (new \upload\field('news','image',1000,400));
		$database->save (new \upload\field('event',null,800,600));
		$database->save (new \upload\field('event','image',1000,400));
		$admin->type->news = $database->save(new \core\type ('news', $system->page('news')));
		$admin->type->news->bind ($system->unit('news.route')->save());
		$admin->type->news->bind ($system->unit('news.story')->save());
		$admin->type->news->bind ($system->unit('news.event')->save());
		$admin->type->news->bind ($system->unit('news.next')->save());
		$admin->type->news->bind ($system->unit('news.archive')->save());
		$admin->type->news->bind ($system->unit('news.pick')->save(null,'Feature'));
		$database->save (new \core\plug(null, $system->unit('news.pick'), 'News 2', 'slider_2_cell'));
		$database->save (new \core\plug(null, $system->unit('news.pick'), 'News 3', 'slider_3_cell'));
		$database->save (new \core\plug(null, $system->unit('news.pick'), 'News 4', 'slider_4_cell'));
		$database->save (new \core\edit('news.pick',$system->page('news'),'news.picks'),\db\query::insert);

		$system->unit('social.networks')->part('social');

		//$system->unit('text.code', null, true);
		$system->unit('text.edit')->part('texts');
		$database->save (new \upload\field('text',null,800,600));
		$admin->layout->text = $database->save(new \core\layout('text'));
		$admin->layout->text->add ('text');
		$admin->unit->text = $system->unit ('text.view')->save();
		$admin->type->text = $database->save(new \core\type ($admin->layout->text, $system->page('texts'), 'text'));
		$admin->type->text->bind ($admin->unit->text, 'text');
		$admin->type->text->bind ($admin->unit->title);

		$database->save (new \core\plug(null, $admin->unit->text, 'Text'));
		//$database->save (new \core\plug(null, $admin->unit, 'Custom', 'code'));
		$database->save (new \core\edit('text.view',$system->page('texts'),'text.edit'),\db\query::insert);

		$system->unit('gallery.edit')->part('gallery');
		$system->unit('gallery.albums')->part('gallery');
		$system->unit('gallery.items')->part('gallery');
		$database->save (new \core\plug(null, $system->unit('gallery.view'), 'Gallery', '*'));
		$database->save (new \core\edit('gallery.view',$system->page('gallery'),'gallery.edit'),\db\query::insert);
		$admin->type->gallery = $database->save (new \core\type('gallery',$system->page('gallery'),'gallery'));
		$admin->type->gallery->bind ('gallery.view',null,null,'*');
		$admin->type->gallery->bind ('gallery.menu',null,null,'*');
		$admin->type->gallery->bind ($admin->unit->title);
		$admin->upload->gallery = new stdClass ();
		$admin->upload->gallery->album = $database->save (new \upload\field('gallery','album',500,500));
		$database->save (new \upload\thumb($admin->upload->gallery->album,'edit',360,228));
		$database->save (new \upload\thumb($admin->upload->gallery->album,'view',175,175));
		$admin->upload->gallery->item = $database->save (new \upload\field('gallery','item',800,600));
		$database->save (new \upload\thumb($admin->upload->gallery->item,'edit',360,228));
		$database->save (new \upload\thumb($admin->upload->gallery->item,'view',75,75));

		$system->unit('upload.fields')->part('upload');
		$system->unit('upload.thumbs')->part('upload');
		$system->unit('upload.edit')->part('texts')->part('news');

		$system->unit('core.project')->part('projects');
		$system->unit('core.plug')->part('plugs');
		$system->unit('core.unit')->part('units');
		$system->unit('core.page')->part('parts');
		$system->unit('core.part')->part('parts');

		$system->unit('slider.edit')->part ('sliders');
		$system->unit('slider.type')->part ('sliders');
		$system->unit('slider.item')->part ('sliders');
		$database->save (new \core\plug(null, $system->unit('slider.view'), 'Slider', '*'));
		$database->save (new \core\edit('slider.view',$system->page('sliders'),'slider.edit'),\db\query::insert);

		$admin->unit->menu = $system->unit ('menu.view');
		if ($admin->unit->menu->save ($system->project,'Main',null,true))
		{
			$admin->menu->pages = $database->save (new \menu\item ($admin->unit->menu, $system->page('pages')));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('texts'), null, null, $admin->menu->pages,null,true));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('layouts'), null, null, $admin->menu->pages,null,true));

			$database->save (new \menu\item ($admin->unit->menu, $system->page('menus')));

			$admin->menu->modules = $database->save (new \menu\item ($admin->unit->menu, $system->page('news'), 'Modules', 'modules'));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('news'), 'News', 'news', $admin->menu->modules));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('upload'), 'Upload', 'upload', $admin->menu->modules));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('social'), 'Social', 'social', $admin->menu->modules));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('gallery'), 'Gallery', 'gallery', $admin->menu->modules));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('sliders'), 'Sliders', 'sliders', $admin->menu->modules));

			$database->save (new \menu\item ($admin->unit->menu, $system->page('users')));

			$admin->menu->system = $database->save (new \menu\item ($admin->unit->menu, $system->page('plugs'), 'System', 'system'));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('plugs'), 'Plugs', 'plugs', $admin->menu->system));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('units'), 'Units', 'units', $admin->menu->system));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('parts'), 'Pages', 'parts', $admin->menu->system));
			$database->save (new \menu\item ($admin->unit->menu, $system->page('projects'), 'Projects', 'projects', $admin->menu->system));
		}

		$system->unit('menu.scope', $system->project, 'Main')->part('news')->part('settings')->part('upload')->part('social')->part('gallery')->part('users')->part('plugs')->part('parts')->part('units')->part('sliders')->part('projects');

		$admin->unit->scope = $system->unit('menu.scope',null,'Navigation','main');
		$database->save (new \core\plug(null, $admin->unit->scope, 'Navigation'));

		$system->parts ();

		include $system->project->path('install');

	}

	//$database->debug (false);


?>