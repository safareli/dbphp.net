<?php

    const project = 'site';

    include './config.php';

    $system = new \core\system ();

    include solution ('header');
    include project ('header');

    $system->load ();
    $system->input ();
    $system->login ();

    include project ('project');

    $system->output ();

?>