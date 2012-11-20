function $import(src) {
    var script = document.createElement('script');
    script.src = src;
    document.body && document.body.appendChild(script);
}

$import('../../bootstarp/js/bootstrap.min.js');

$(function(){
	$('#showDialog').click(function(){
		$('#loginDialog').modal({
			keyboard:true,
			backdrop:true
		});
	});
});