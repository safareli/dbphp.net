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
  const system = '\path\to\system\folder\' in config file.

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