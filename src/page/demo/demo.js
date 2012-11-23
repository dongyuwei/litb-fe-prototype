require('bootstarp/js/bootstrap.min.js');

$(function(){
	$('#showDialog').click(function(){
		$('#loginDialog').modal({
			keyboard:true,
			backdrop:true
		});
	});
});