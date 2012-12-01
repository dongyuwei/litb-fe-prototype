require('base/jquery.1.8.1.js'); 
require('bootstarp/js/bootstrap.js');

$(function(){
	var flag = false, timer;
	$('#currency-box').hover(function(){
		flag = true;
		$('#currency-list').css('display','block')
	},function(){
		flag = false;
		clearTimeout(timer);
		timer = setTimeout(function(){
			if(flag === false){
				$('#currency-list').css('display','none')
			}
		},100);
	});
});