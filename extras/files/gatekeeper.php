<?php
ini_set('upload_max_filesize', '50MB');
ini_set('post_max_size', '50MB');

$AppName = 'docuvault';
$parent_directory = dirname(__DIR__);
if(isset($_ENV['SIMPLONPHP_DIR'])){$simplon_root = $_ENV['SIMPLONPHP_DIR'];}else{$simplon_root = $parent_directory.DIRECTORY_SEPARATOR;}
$app_root = $parent_directory;


require_once $simplon_root.'/vendor/autoload.php';  // Include Composer's autoloader
require_once($simplon_root.DIRECTORY_SEPARATOR.'SC_Main.php');
require_once($simplon_root.DIRECTORY_SEPARATOR.'Tools'.DIRECTORY_SEPARATOR.'tools.php');

$redenderFlavor = 'htmlJQuery';
$redender = new SC_Main::$RENDERER();
$redender->SimplOn_path(realpath($simplon_root));
$redender->App_path(realpath($app_root));
if(str_starts_with($parent_directory, '/home1')){
    $app_web_root = '';
    $redender->App_web_root($app_web_root);
}else{
    $app_web_root = '/'.$AppName;
    $redender->App_web_root($app_web_root);
}
$redender->imgsPath($app_root.'/Layouts/imgs');
$redender->cssWebRoot($app_web_root.'/Layouts/css');
$redender->jsWebRoot($app_web_root.'/Layouts/js');
$redender->imgsWebRoot($app_web_root.'/Layouts/imgs');

if(str_starts_with($parent_directory, '/home1')){
    $DataStorage = new SDS_MySql('localhost', 'demomake_1','demomake_jaime','3SV?C*2Fun!V?C*2');
}else{
    // Select DB from enviroment variable (used to run Docker seamlessly)
    if ($_ENV['DB_HOST']) {
        $DataStorage = new SDS_MySql($_ENV['DB_HOST'], $AppName, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    } else if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost') {
        $DataStorage = new SDS_MySql('localhost',$AppName);
    } else {
        $DataStorage = new SDS_MySql('localhost', 'gonbon32_'.$AppName,'gonbon32_Filemon442',',xp(a8cveD$8sR4--');
    }
}

date_default_timezone_set('America/Mexico_City');

//$_SERVER['HTTP_REFERER']='Pato';

SC_Main::setup(array(
    'DEFAULT_ELEMENT' => 'AE_File',
    'DEFAULT_METHOD' => 'access',
    'DEV_MODE' => true,
    'DATA_STORAGE' => $DataStorage,
    'RENDERER' => $redender,
    'LANG' => 'ES',
    ////////////////////////////////////////
    'LOCAL_ROOT' => $parent_directory,
    'WEB_ROOT' => '',
    'App_PATH' => realpath($app_root),
    'App_web_root' => $app_web_root,
    'SimplOn_PATH' => realpath($simplon_root),
    'SystemMessage' => '',
    'App_Name' => $AppName,
    'Layouts_Processing' => 'OnTheFly', // OnTheFly  OverWrite Update  Preserve   
    'PERMISSIONS' => 'SE_User', //'SE_User'
    'LOAD_ROLE_CLASS' => true,
));


$server_URI = '.'.urldecode(substr($_SERVER['REQUEST_URI'], strlen(SC_Main::$App_web_root)));

$filePath = preg_replace('/\.\/files\//', '', $server_URI, 1);

$inline=true;
$pathParts=explode('/', $filePath);
if($pathParts[0]==='d'){ 
    $inline=false;
    array_shift($pathParts);
}
$scriptFilePath='./'.implode('/', $pathParts);
$dsFilePath='./files/'.implode('/', $pathParts);


$file = new AE_File();

//set the path as it's in the DS
$file->file($dsFilePath);
//set the filter criteria to look only for exact matches
$file->Ofile()->filterCriteria('name == :name');
//get the first exact match
$file = $file->Elements()[0];



$file->servFile($inline);