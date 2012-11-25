var path = require('path');
var fs = require('fs');
var util = require('util');
var express = require('express');
var mu = require('mu2'); // sudo npm install -g mu2


process.on('uncaughtException', function(err) {
	console.error('Caught exception: ', err);
});

var app = express.createServer();
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
	res.end('<div>you can preview Mustache template, such as: <br>'+
        '<a href="/template/page/demo/demo.html">page/demo/demo.html</a> or '+
        '<a href="/template/page/weddingDresses/weddingDresses.html">page/weddingDresses/weddingDresses.html</a></div>');
});

app.get('/template*', function(req, res) {
	res.writeHead(200, {
		'Content-Type': 'text/html;charset=utf-8' 
	});
	var templateName = req.params[0];
	
	var file = path.join(root,templateName);
	if(!fs.existsSync(file)){
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
		mu.root = root;
		var stream = mu.compileAndRender(file, data);
		util.pump(stream, res);
	}
});


app.use(express['static'](root));
app.use(express.directory(root));
	
app.listen(9999);