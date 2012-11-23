 1. nodejs/preview.js或者php/preview.php 可提供在线预览服务：可预览任意page，pagelet，widget模板。
    1. 模板文件同级目录下如果有data.json，则可自动渲染用户选定的mustache模板。
    2. 也可以在线输入模板需要的数据来查看渲染效果。
    3. 自动引入widget和pagelet依赖的js，css；page需要的js和css原则上由模板自己引入，也可以自动引入。

 2. 后期可增加在线编辑模板html，js，css功能。引入cloud9 IDE?
