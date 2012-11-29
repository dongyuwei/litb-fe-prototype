var path = require('path');
var fs = require('fs');
var util = require('util');
var express = require('express');
var Mustache = require('mustache');

process.on('uncaughtException', function(err) {
    console.error('Caught exception: ', err);
});

var app = express();
app.use(express.bodyParser());
app.use(app.router);

var root = path.resolve(__dirname, '..', '..', 'src');

function load() {
    function require(src) {
        window['_jsLibs_'] = window['_jsLibs_'] || {};
        if (window['_jsLibs_'][src] !== 1) {
            window['_jsLibs_'][src] = 1;

            var script = document.createElement('script');
            script.src = '/' + src;
            document.body && document.body.appendChild(script);
        }
    }
    return require.toString();
}
function merge(source,target){
	for(var k in source){
		target[k] = source[k];
	}
	return target;
}

app.get('/', function(req, res) {
    res.writeHead(200, {
        'Content-Type': 'text/html;charset=utf-8'
    });
    res.end('<ul>you can preview any mustache template(in `/template/x/y/z.html` forms ), such as: '
     + '<li><a href="/template/page/demo/demo.html">page/demo/demo.html</a> </li> ' 
     + '<li><a href="/template/page/weddingDresses/weddingDresses.html">page/weddingDresses/weddingDresses.html</a></li>' 
     + '<li><a href="/template/widget/currency/currency.html">widget/currency/currency.html</a></li></ul>');
});

app.get('/template*', function(req, res) {
    res.writeHead(200, {
        'Content-Type': 'text/html;charset=utf-8'
    });
    var templateName = req.params[0];

    var file = path.join(root, templateName);
    if (!fs.existsSync(file) || !fs.statSync(file).isFile()) {
        res.end(file + ' does not exists! \n <a href="/">return</a>');
    } else {
        var dataFile = file.replace('.html', '.json'),data = {};
        if (fs.existsSync(dataFile)) {
            try {
                data = JSON.parse(fs.readFileSync(dataFile));
            } catch (e) {
                console.error(e);
            }
        }

        var script = "<script>" + load() + "</script>";
        res.write(script);
        if (req.url.match(/\/pagelet\/|\/widget\//)) {
            res.write('<link href="SRC" rel="stylesheet">'.replace('SRC', templateName.replace('.html', '.css')));
            res.write('<script src="/base/jquery.1.8.1.js"></script>');
            res.write('<script src="SRC"></script>'.replace('SRC', templateName.replace('.html', '.js')));
        }

        var I18N = {
        	'hello world!' : '你好，世界!'
        };
        data = merge(data,{
        	'cdn_base_url':'',
            "name": "dongyuwei",
            "i18n": function() {
                return function(text, render) {
                    text = I18N[text] || text;
                    return render(text);
                }
            }
        });
        var output = Mustache.render(fs.readFileSync(file, 'utf8'), data, function(partial) {//auto load partial template
            return fs.readFileSync(path.join(root, partial), 'utf8');
        });
        res.end(output);
    }
});


app.use(express['static'](root));
app.use(express.directory(root));

console.log('please visit http://127.0.0.1:9999/');
app.listen(9999);