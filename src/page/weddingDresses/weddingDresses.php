<?php
require realpath(dirname(__FILE__).'/../../Mustache/Autoloader.php');
Mustache_Autoloader::register();

$mustache = new Mustache_Engine(array(
	'cache' => '/tmp/mustache/cache',
    'template_class_prefix' => '__litb_',
    'loader' => new Mustache_Loader_FilesystemLoader(realpath(dirname(__FILE__). '/../../'),array(
    	'extension' => '.html',
     )),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(realpath(dirname(__FILE__).'/../../'),array(
    	'extension' => '.html',
     )),
));

$tpl = $mustache->loadTemplate('page/weddingDresses/weddingDresses');
echo $tpl->render(array(
	'src' => 'http://cloud4.lbox.me/images/384x500/201006/A-line-Spaghetti-Straps-Chapel-Train-Satin-Wedding-Dress-with-A-Wrap--WSM0479-_yuqq1277375234171.jpg',
	'href' => 'http://cloud4.lbox.me/images/x/201006/A-line-Spaghetti-Straps-Chapel-Train-Satin-Wedding-Dress-with-A-Wrap--WSM0479-_yuqq1277375234171.jpg',
    'thumbnails' => array(
	    array(
	    	'src' => "http://cloud4.lbox.me/images/64x84/201107/pirtiq1311928757223.jpg",
	    	'href' => 'http://cloud3.lbox.me/images/384x500/201107/Sheath--Column-Bateau-Short--Mini-Chiffon-Wedding-Dress--WSH1102543-_pirtiq1311928757223.jpg',
	    	'title' => " A-line Scoop Short/ Mini Taffeta Wedding Dress" ,
	    	'alt' =>  " A-line Scoop Short/ Mini Taffeta Wedding Dress",
	     ),
	    array(
	    	'src' => "http://cloud4.lbox.me/images/64x84/201107/pirtiq1311928757223.jpg",
	    	'href' => 'http://cloud3.lbox.me/images/384x500/201107/Sheath--Column-Bateau-Short--Mini-Chiffon-Wedding-Dress--WSH1102543-_pirtiq1311928757223.jpg',
	    	'title' => " A-line Scoop Short/ Mini Taffeta Wedding Dress" ,
	    	'alt' =>  " A-line Scoop Short/ Mini Taffeta Wedding Dress",
	     ),
	    array(
	    	'src' => "http://cloud4.lbox.me/images/64x84/201107/pirtiq1311928757223.jpg",
	    	'href' => 'http://cloud3.lbox.me/images/384x500/201107/Sheath--Column-Bateau-Short--Mini-Chiffon-Wedding-Dress--WSH1102543-_pirtiq1311928757223.jpg',
	    	'title' => " A-line Scoop Short/ Mini Taffeta Wedding Dress" ,
	    	'alt' =>  " A-line Scoop Short/ Mini Taffeta Wedding Dress",
	     ),
	    array(
	    	'src' => "http://cloud4.lbox.me/images/64x84/201107/pirtiq1311928757223.jpg",
	    	'href' => 'http://cloud3.lbox.me/images/384x500/201107/Sheath--Column-Bateau-Short--Mini-Chiffon-Wedding-Dress--WSH1102543-_pirtiq1311928757223.jpg',
	    	'title' => " A-line Scoop Short/ Mini Taffeta Wedding Dress" ,
	    	'alt' =>  " A-line Scoop Short/ Mini Taffeta Wedding Dress",
	     ),
	    array(
	    	'src' => "http://cloud4.lbox.me/images/64x84/201107/pirtiq1311928757223.jpg",
	    	'href' => 'http://cloud3.lbox.me/images/384x500/201107/Sheath--Column-Bateau-Short--Mini-Chiffon-Wedding-Dress--WSH1102543-_pirtiq1311928757223.jpg',
	    	'title' => " A-line Scoop Short/ Mini Taffeta Wedding Dress" ,
	    	'alt' =>  " A-line Scoop Short/ Mini Taffeta Wedding Dress",
	     ),
	    array(
	    	'src' => "http://cloud4.lbox.me/images/64x84/201107/pirtiq1311928757223.jpg",
	    	'href' => 'http://cloud3.lbox.me/images/384x500/201107/Sheath--Column-Bateau-Short--Mini-Chiffon-Wedding-Dress--WSH1102543-_pirtiq1311928757223.jpg',
	    	'title' => " A-line Scoop Short/ Mini Taffeta Wedding Dress" ,
	    	'alt' =>  " A-line Scoop Short/ Mini Taffeta Wedding Dress",
	     ),
	  ),
	));
?>