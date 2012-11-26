require('bootstarp/js/bootstrap.js');

$(function(){
	$('#showDialog').click(function(){
		$('#loginDialog').modal({
			keyboard:true,
			backdrop:true
		});
	});
});