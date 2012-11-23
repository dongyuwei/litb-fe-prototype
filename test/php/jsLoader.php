<?php
	$base = realpath(dirname(__FILE__). '/../../src');
    if(!empty($_GET['js'])){
        echo file_get_contents($base. '/'. $_GET['js']);
        exit(0);;
    }
?>