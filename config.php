<?php

    //constants
    //system - stands for system modules directory
    //remote - stands for system directory remote path
    //path - stands for path of solution
    //link - stands for link of solution
    //server -stants for server name for which to load config (local/production/etc)
    //config - stands for config dir
    //project - stands for project name

    error_reporting(E_ALL ^ E_NOTICE);

    define ('start', microtime(true));

    if (!defined('config'))
    {
        define ('config', str_replace('\\','/',__DIR__).'/config/');
    }

    if (file_exists(__DIR__.'/server.php'))
    {
        include __DIR__.'/server.php';
    }

    if (!defined('server'))
    {
        define ('server', 'local');
    }

    if (file_exists(config.server.'.php'))
    {
        include config.server.'.php';
    }

    if (!defined('path'))
    {
        define ('path', str_replace('\\','/',__DIR__).'/');
    }

    if (!defined('system'))
    {
        define ('system', path.'system/');
    }

    if (!defined('link'))
    {
        define ('link', 'http://'.$_SERVER['HTTP_HOST'].'/'.substr(path,strpos($_SERVER['DOCUMENT_ROOT'],path)+strlen($_SERVER['DOCUMENT_ROOT'])+1));
    }

    if (!defined('remote'))
    {
        define ('remote', link.'system/');
    }

    if (!defined('contact'))
    {
        define ('contact', $_SERVER["SERVER_ADMIN"]);
    }

    function module ($name,$file=null)
    {
        if ($file===null)
        {
            if (!isset($GLOBALS['modules']) || !is_array($GLOBALS['modules']))
            {
                $GLOBALS['modules'] = array ();
            }
            $GLOBALS['modules'][] = $name;
        }

        if ($file!==null && file_exists(path.'projects/'.project.'/'.$name.'/'.$file.'.php'))
        {
            return path.'projects/'.project.'/'.$name.'/'.$file.'.php';
        }
        else if ($file!==null && file_exists(path.'modules/'.$name.'/'.$file.'.php'))
        {
            return path.'modules/'.$name.'/'.$file.'.php';
        }
        else if ($file!==null && file_exists(system.$name.'/'.$file.'.php'))
        {
            return system.$name.'/'.$file.'.php';
        }
        else if ($file===null && file_exists(path.'projects/'.project.'/'.$name.'/'.$name.'.php'))
        {
            return path.'projects/'.project.'/'.$name.'/'.$name.'.php';
        }
        else if ($file===null && file_exists(path.'modules/'.$name.'/'.$name.'.php'))
        {
            return path.'modules/'.$name.'/'.$name.'.php';
        }
        else if ($file===null && file_exists(system.$name.'/'.$name.'.php'))
        {
            return system.$name.'/'.$name.'.php';
        }
    }

    function project ($name, $file=null)
    {
        return path.'projects/'.project.'/'.$name.'.php';
    }

    function solution ($name)
    {
        return path.'projects/'.$name.'.php';
    }

    function path ($name)
    {
        return path.$name.'.php';
    }

    @include module ('jquery');
    include module ('db');
    include module ('core');
    //include module ('user');
    include module ('tool');
    include module ('util');
    include module ('ui');



?>