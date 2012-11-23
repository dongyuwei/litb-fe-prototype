function $import(src) {
    var script = document.createElement('script');
    script.src = src;
    document.body && document.body.appendChild(script);
}

$import('../../bootstarp/js/bootstrap.min.js');

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