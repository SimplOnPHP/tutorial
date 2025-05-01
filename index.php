<?php
ini_set('upload_max_filesize', '50MB');
ini_set('post_max_size', '50MB');

$AppName = 'tutorial';


if(isset($_ENV['SIMPLONPHP_DIR'])){$simplon_root = $_ENV['SIMPLONPHP_DIR'];}else{$simplon_root = __DIR__.DIRECTORY_SEPARATOR;}
$app_root = __DIR__;

require_once $simplon_root.'/vendor/autoload.php';  // Include Composer's autoloader
require_once($simplon_root.DIRECTORY_SEPARATOR.'SC_Main.php');
require_once($simplon_root.DIRECTORY_SEPARATOR.'Tools'.DIRECTORY_SEPARATOR.'tools.php');

$redenderFlavor = 'htmlJQuery';
$redender = new ('SR_'.$redenderFlavor)();
$redender->SimplOn_path(realpath($simplon_root));
$redender->App_path(realpath($app_root));
$redender->Renderer_path($simplon_root.'/Renderers/'.$GLOBALS['redenderFlavor']);

$app_web_root = '/'.$AppName;
$redender->App_web_root($app_web_root);

$redender->imgsPath($app_root.'/'.$redenderFlavor.'/imgs');
$redender->cssWebRoot($app_web_root.'/'.$redenderFlavor.'/css');
$redender->jsWebRoot($app_web_root.'/'.$redenderFlavor.'/js');
$redender->imgsWebRoot($app_web_root.'/'.$redenderFlavor.'/imgs');

SC_Main::$LANG='ES';
SC_Main::$RENDERER=$redender;
require_once(SC_Main::$RENDERER->SimplOn_path().DIRECTORY_SEPARATOR.'Languages'.DIRECTORY_SEPARATOR.SC_Main::$LANG.'.php');

$DataStorage = new SDS_MySql($_ENV['DB_HOST'], $AppName, $_ENV['DB_USER'], $_ENV['DB_PASS']);

date_default_timezone_set('America/Mexico_City');

SC_Main::run(array(
    'DEFAULT_ELEMENT' => 'AE_File',
    'DEFAULT_METHOD' => 'showAdmin',
    'DEV_MODE' => true,
    'DATA_STORAGE' => $DataStorage,
    'RENDERER_FLAVOR' => $redenderFlavor,
    'RENDERER' => $redender,
    ////////////////////////////////////////
    'LOCAL_ROOT' => __DIR__,
    'WEB_ROOT' => '',
    'App_PATH' => realpath($app_root),
    'App_web_root' => $app_web_root,
    'SimplOn_PATH' => realpath($simplon_root),
    'SystemMessage' => '',
    'App_Name' => $AppName,
    'PERMISSIONS' => 'AE_User', //''
    'LOAD_ROLE_CLASS' => true,
));