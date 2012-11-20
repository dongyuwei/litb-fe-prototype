<?php
require realpath(dirname(__FILE__).'/../../Mustache/Autoloader.php');
Mustache_Autoloader::register();

$mustache = new Mustache_Engine(array(
    'template_class_prefix' => '__litb_',
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__),array(
    	'extension' => '.html',
     )),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(realpath(dirname(__FILE__).'/../../'),array(
    	'extension' => '.html',
     )),
));

$tpl = $mustache->loadTemplate('demo');
echo $tpl->render();
?>