#blank.php is a blank copy of cms powered by system.php and db.php frameworks
###By itself cms represents nothing then directory structure and couple of php scripts

###THIS IS THE SHORTEST INSTALLATION+INTRO GUIDE

####CONFIG
First configure sql server connection in [solution]\config\local.php.
* Note that it is not problem if database does not exist,
  db.php will create database automatically if specified sql user
  has enough permissions to create database.

You can have multi case configs for example local.php, remote.php.
Which config to load is determined by constant server located in server.php.
By default const server='local';

####INSTALL
If you are looking for install just run admin.php from browser. If no tables
exist or not database created the script run will be consedered as installation.
Will be created default projects.

This system has multi project architecture united under one solution. So during
installation two projects will be created and configured by default:
* site
* admin

####STRUCTURE
The whole folder tree represents solution. Solution may contain projects, modules,
global skins and project loader .php files and also other things.

####SYSTEM
[solution]\system folder contains system modules and it is strongly recomended not to touch or
modify them - INSTEAD you can create same module name folder under [solution]\modules folder
and override any file from system module. For example if there is jquery.js in system
jquery folder and you created \modules\jquery\jquery.js then your jquery will be loaded.
* Note some files can be overrided but some files are exended from system modules by local modules.
* system folder can be located anywhere outside of solution dir but you will need to define
```php
const system = '\path\to\system\folder\'
```
in config file.

####MODULES
[solution]\modules folder contains local solution specific modules also this folder is
used to override\extend system modules. Create new module if you are using it
from more than one porject under your solution. If module is only project specific
then create module under project folder. By default this folder is not present.

####PROJECTS
[solution]\projects folder contains local projects. Each project can have local modules. Just
create dir under project folder and it is considered as module. If you use
automatic .css .js. and font load than all files such files from your module
will be loaded in {head} variable and you can use it in master template.

####SKINS
[solution]\skins folder contains skins. Any skin from global skins folder can be extended\overriden
from same name skin folder under project skin's folder.

For example: [solution]\skins\default\home.htm is default home.htm skin but if there exists
[solution]\projects\site\skins\default\home.htm the last one is used.
* skins also contain .phs and .php files. This files store short skin snippets which
are used by widgets to parse dinamic content. Unlike .htm files .php and .phs files
are not overriden but they are extended.
* Skins also may have multilangual localisation folders. Like if you have defined
locale 'eng' you can place 'eng' folder in skins file and override\extend all
the files from parent folder when locale 'eng' is active on the site.

SO IN CONCLUSION TO INSTALL SOLUTION JUST CONFIGURE SQL CONNECTION AND RUN ADMIN.PHP

####THOUGHTS
What does future require from PHP framework:

That learing of a framework tricks filled like you already knew how easyly this could be done.

For a simple example you have to save your user object wich is instance of your user class - why not simply $database->save($user)?! hiding behind it every modern database concepts and skills.

And when you want to load an instance of \user\group class by id=1? Are you thinking about $database->user->group->load(1)? When you want to load it with a custom query you are thinking about $database->user->group->load($query).

And why to create table or database or part of it on some server by hand (Even with MySQL Workbanch or with other db modeling tool) when the only thing you are looking for is to write a class and work with its objects - If orm can scan your classes and create/synch tables in databases on distant servers for you automatically (upon your wish manually) while giving you full control of its every tiny process and feature customisation.

Imagine a modular framework done in this manner in where 'db' module deals with db, 'ui' module deals with ui, 'user' module deals with users and some other module deals with web page construction. They keep simple structure and bring full power and full customization.

In this framework form is built like this:
```php
$form = new \ui\form();
$form->label('Country')->select('country',$_REQUEST['country'],$database->country->load());
$form->submit('Save');
```

Inside page part:
```php
$this->parse('errors','error',array('name',$system->user->name()));
```

So after an year maybe I ll be ready to accept your 30 second challange.

And let me leave an answer for someone who might ask why this is needed in PHP:

By my opinion the MAIN DIFFERENCE between PHP enterprise alternatives and PHP itself is the lack of simple standard for big things and solutions. Zend has its own vision, Symphony has its own vision, Drupal adds its own vision while for example Microsoft has one way in .NET framework, something simillar can be stated for Oracle and JAVA while PHP still stays as a framework for developing frameworks. If PHP wants to survive in future some there will be need for tool wich will guide you through big solutions and will fill like naturally extended part of PHP. Maybe not from me but I beleive like this will arrive in future by someone of some group.

db.php - orm module wich can be used without framework in any project https://github.com/hazardland/db.php
system.php - a collection of modules for various solutions https://github.com/hazardland/system.php
blank.php - a simple solution uniting two projects: site and admin using system.php framework https://github.com/hazardland/blank.php
