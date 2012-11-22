<?php
require realpath(dirname(__FILE__).'/../../Mustache/Autoloader.php');
Mustache_Autoloader::register();

$mustache = new Mustache_Engine(array(
	'cache' => '/tmp/mustache/cache',
    'loader' => new Mustache_Loader_FilesystemLoader(realpath(dirname(__FILE__). '/../../'),array(
    	'extension' => '.html',
     )),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(realpath(dirname(__FILE__).'/../../'),array(
    	'extension' => '.html',
     )),
));

$tpl = $mustache->loadTemplate('page/demo/demo');
echo $tpl->render();

//start-------------------------i18n demo-------------------------------------------------------
$m = new Mustache_Engine();

$m->addHelper('i', function($text) {

    $dictionary = array(
        'Hello' => 'Hola',
        'My name is {{ name }}.' => 'Me llamo {{ name }}.',
    );

    return array_key_exists($text, $dictionary) ? $dictionary[$text] : $text;
});

$tpl = $m->loadTemplate('{{#i}}Hello{{/i}}. {{#i}}My name is {{ name }}.{{/i}} {{#i18n}}test{{/i18n}}');
echo $tpl->render(array(
	'name' => 'Justin',
	'Hello' => 'Hola',
));
//end-------------------------i18n demo-------------------------------------------------------
?>