function $import(src) {
    var script = document.createElement('script');
    script.src = src;
    document.body && document.body.appendChild(script);
}

$import('../../bootstarp/js/bootstrap.min.js');
$import('../../pagelet/commodityItem/commodityItem.js');