var path = require('path');
var fs = require('fs');
var util = require('util');
var express = require('express');
var mu = require('mu2'); // sudo npm install -g mu2


process.on('uncaughtException', function(err) {
	console.error('Caught exception: ', err);
});

var app = express();
app.use(express.bodyParser());
app.use(app.router);

var root = path.resolve(__dirname,'..','..','src');

function load(){
    function require(src) {
        var script = document.createElement('script');
        script.src = '/' + src;
        document.body && document.body.appendChild(script);
    }
    return require.toString();
}

app.get('/', function(req, res) {
	res.writeHead(200, {
		'Content-Type': 'text/html;charset=utf-8' 
	});
	res.end('<ul>you can preview Mustache template, such as: '+
        '<li><a href="/template/page/demo/demo.html">page/demo/demo.html</a> </li> '+
        '<li><a href="/template/page/weddingDresses/weddingDresses.html">page/weddingDresses/weddingDresses.html</a></li>'+
        '<li><a href="/template/widget/currency/currency.html">widget/currency/currency.html</a></li></ul>');
});

app.get('/template*', function(req, res) {
	res.writeHead(200, {
		'Content-Type': 'text/html;charset=utf-8' 
	});
	var templateName = req.params[0];
	
	var file = path.join(root,templateName);
	if(!fs.statSync(file).isFile()){
		res.end(file + ' does not exists! \n <a href="/">return</a>');
	}else{
		var dataFile = file.replace('.html','.json'),data = {};
		if(fs.existsSync(dataFile)){
			try{
				data = JSON.parse(fs.readFileSync(dataFile));
			}catch(e){
				console.error(e);
				data = {};
			}
		}
		data['cdn_base_url'] = '';
		var script = "<script>" + load() + "</script>";
		res.write(script);
		if(req.url.match(/\/pagelet\/|\/widget\//)){
			res.write('<link href="SRC" rel="stylesheet">'.replace('SRC',templateName.replace('.html','.css')));
			res.write('<script src="/base/jquery.1.8.1.js"></script>');
			res.write('<script src="SRC"></script>'.replace('SRC',templateName.replace('.html','.js')));
		}

		mu.root = root;
		var stream = mu.compileAndRender(file, data);
		util.pump(stream, res);
	}
});


app.use(express['static'](root));
app.use(express.directory(root));

console.log('please visit http://127.0.0.1:9999/');	
app.listen(9999);