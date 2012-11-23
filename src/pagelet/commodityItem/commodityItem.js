
function $import(src) {
    var script = document.createElement('script');
    script.src = src;
    document.body && document.body.appendChild(script);
}

$import('../../widget/currency/currency.js');