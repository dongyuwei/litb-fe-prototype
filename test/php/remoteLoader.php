<?php
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

try {
    $html = file_get_contents("http://127.0.0.1:8888/lightsource/widget/reviews/item/main.html?raw=true");
} catch (Exception $e) {
    echo 'Error when file_get_contents : '.$e->getMessage();
}
echo($html);
?>