
require('base/jquery.1.8.1.js'); 
require('bootstarp/js/bootstrap.js');

$(function(){
	$('#showDialog').click(function(){
		$('#loginDialog').modal({
			keyboard:true,
			backdrop:true
		});
	});
});