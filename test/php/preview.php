<script>
    if(typeof require === 'undefined'){
        function require(src) {
            window['_jsLibs_'] = window['_jsLibs_'] || {};
            if(window['_jsLibs_'][src] !== 1){
                window['_jsLibs_'][src] = 1;

                var script = document.createElement('script');
                script.src = location.href.split('?')[0].replace('preview','jsLoader') + '?js=' + src;
                document.body && document.body.appendChild(script);
            }
        }
    }
</script>

<?php
    require dirname(__FILE__).'/Mustache/Autoloader.php';
    Mustache_Autoloader::register();

    function render($template,$cdn_base_url){
        $loader = new Mustache_Loader_FilesystemLoader(realpath(dirname(__FILE__). '/../../src'),array(
                'extension' => '',
        ));
        $mustache = new Mustache_Engine(array(
            'cache' => '/tmp/mustache/cache',
            'loader' => $loader,
            'partials_loader' => $loader
        ));

        $tpl = $mustache->loadTemplate($template);

        return $tpl->render(array('cdn_base_url' => $cdn_base_url));
    }

    $base = realpath(dirname(__FILE__). '/../../src');
    if(empty($_GET['template'])){
        echo '<div >you can preview Mustache template, such as: <br>'. 
        '<a href="?template=page/demo/demo.html">page/demo/demo.html</a> or '.
        '<a href="?template=page/weddingDresses/weddingDresses.html">page/weddingDresses/weddingDresses.html</a></div>';
    }else{
        $template = $_GET['template'];
        $file = $base. '/'. $template;
        if (!file_exists($file)) {
            echo '<span style="color:red;">Error: '.$file. ' does not exists!</span>';
            exit(1);
        }
        echo render($template,'http://127.0.0.1/litb-fe-prototype/src');
    };
?>