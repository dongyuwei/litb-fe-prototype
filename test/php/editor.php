<!DOCTYPE html>
<html>
    <head>
        <title>
            {{ mustache }} online editor(by mustache.php)
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        
        <link href="static/highlight.css" rel="stylesheet" type="text/css" />
        <style>
            form{
                width:100%;
                margin:0;
                padding:0;
            }
            textarea{
                margin: 10px auto;
                width:90%;
            }
            #html{
                margin: 10px auto;
            }
            #html{
                border:solid 1px red;
            }
            #html:empty{
                display:none;
            }

        </style>
    </head>
    <body>
        <h1>mustache online editor(by <a href='https://github.com/bobthecow/mustache.php'>mustache.php</a>) </h1>
        <form id="mustache" method='POST'>
            <textarea name="template" rows="7" placeHolder="input your mustache html template here..." value="">{{test}}</textarea>
            <textarea name="json" rows="7" placeHolder="input your JSON data here..." value="">{"test":"mustache"}</textarea>
            <p><input type="submit" id="render" value="Render Template" /></p>
        </form>

        <div>
            <p>rendered html:</p>
            <pre id="html" class="html sh_html"></pre>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
        </script>
        <script src="static/highlight.js">
        </script>
        <script>
            var button = $('#render'), form = $('#mustache'), box = $('#html');
            form.submit(function(e){
                e.preventDefault();
                try{
                    JSON.parse($('[name="json"]').val())
                }catch(e){
                    box.text("Error when parsing JSON " + e);
                    return;
                }
                button.attr('disabled',true);
                $.ajax({
                    type        : "POST",
                    url         : window.location.href.replace('editor.php','render.php'),
                    dataType    : "html",
                    data        : form.serialize(),
                    complete    : function(){
                        button.attr('disabled',false);
                    },
                    success     : function(data){
                        box.html(data);
                        Highlight.highlightDocument();
                    },
                    error       : function(){

                    }
                });
            });
        </script>
    </body>
</html>
