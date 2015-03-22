<?php

    //for the first run here happens very basic installation of admin project
    //$database->debug ();

    @include module ('tinymce');
    include module ('news');
    include module ('social');
    include module ('gallery');
    include module ('slider');

    $system->skin->name = 'mp7';

    if ($system->locales===false)
    {
/*
        $database->save (new \core\locale('eng'),\db\query::insert);
        $database->save (new \core\locale('geo'),\db\query::insert);
        $database->save (new \core\locale('pol'),\db\query::insert);

        $system->locales();
        $database->update ();

*/    }

    if ($system->pages===false)
    {
        $system->install = true;

        $layout = new \stdClass();
        $layout->modules = $database->save (new \core\layout('modules'));
        $layout->news = $database->save (new \core\layout('news'));

        $database->save (new \core\page($system->project,'login',null,null,\core\accept::guest));
        $database->save (new \core\page($system->project,'home',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'pages',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'texts',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'layouts',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'news',null,$layout->news,\core\accept::user));
        $database->save (new \core\page($system->project,'menus',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'widgets',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'modules',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'users',null,null,\core\accept::user));
        $database->save (new \core\page($system->project,'upload', null, $layout->modules,\core\accept::user));
        $database->save (new \core\page($system->project,'social', null, $layout->modules,\core\accept::user));
        $database->save (new \core\page($system->project,'gallery', null, $layout->modules,\core\accept::user));
        $database->save (new \core\page($system->project,'projects', null, $layout->modules,\core\accept::user));
        $database->save (new \core\page($system->project,'plugs', null, $layout->modules,\core\accept::user));
        $database->save (new \core\page($system->project,'units', null, $layout->modules,\core\accept::user));
        $database->save (new \core\page($system->project,'parts', null, $layout->modules,\core\accept::user));
        $database->save (new \core\page($system->project,'sliders', null, $layout->modules,\core\accept::user));
        $system->pages ();

        $system->project->default = $system->page ('pages');
        $database->save ($system->project);
    }


    // $user = $database->user->user->load (1);
    // $user->password = \user\password('123');
    // $database->save ($user);

?>