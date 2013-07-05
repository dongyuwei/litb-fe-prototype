<?php
    require dirname(__FILE__).'/Mustache/Autoloader.php';
    Mustache_Autoloader::register();

    function render($template,$data){
        $mustache = new Mustache_Engine();

        $mustache->addHelper('i18n', function($text) {
            return array_key_exists($text, $data['I18N']) ? $data['I18N'][$text] : $text;
        });

        return $mustache->render($template, $data); 
    }
    //echo render('{{test}}ttttt{{{test}}}',array('test'=>'<a href="#">aaa</a>'));
    //die();
    if($_POST['template'] && $_POST['json']){
        try {
            $data = json_decode($_POST['json'],true);
            echo render($_POST['template'],$data);
        } catch (Exception $e) {
            echo 'Error when render mustache : '.$e->getMessage();
        }
    }
?>
