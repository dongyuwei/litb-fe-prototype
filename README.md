##兰亭前端现存问题：##
1. **开发模式**：前后端耦合太紧，js，css内嵌在php(html)中，模块化程度有限，代码复用度不高。
2. **模板系统**：无法有效支持快速分支的并行开发模式；在线编辑器功能太弱，缺乏全文查找和语法校验等基本功能。
3. **重复工作**：模板部分在前后端重复模块化2次；模板系统提供了widget，后端又重新封装一遍。
4. **源码版本控制**：模板系统中前端静态资源没有版本控制；前后端共用一个svn仓库导致文件数量膨胀，源码分支合并回滚等操作不方便；svn仓库中js和css源码是压缩版，但压缩比率较低。
5. **发布流程**：前后端代码一起上线，不利于快速发布，不利于快速hotfix。

##兰亭前端模块化架构设计目标：##
1. **前后端分离**：前端源码独立控制，消除页面内嵌js，css。
2. **模块化**：js，css，html均模块化，提高代码复用度。清晰的依赖关系管理，使修改更安全，扩展更容易。
3. **模板复用**：前端提供模板，后端只提供渲染模板需要的数据及接口。模板和数据是严格分离的。
4. **并行开发**：前后端可并行开发，后端只关心提供数据及接口服务。多项目可并行开发，可快速分支开发。
5. **独立发布**：前端代码（js，css，img）可独立发布上线（快速发布，频繁发布），加快功能迭代和hotfix速度。

###合理的架构可以让新手快速成长，独当一面;对多项目多任务可快速响应###

##设计规划##
1. **JS模块化**：
 	1. 组件使用jQuery（or zepto）插件方式来组织代码；
	2. 统一的namespace管理，尽量不污染全局空间；
	3. 使用require('a/b/c.js');方式引用依赖模块；上线前由构建工具合并压缩成单个文件；
	4. 使用（jQuery）自定义事件在组件之间交换信息。
	5. 所有js代码都在dom ready后执行。部分特殊代码可能需要在引用处立即运行，需要开发人员在模板特定位置引入（这种情况下需要避免代码重复引用和执行）。
2. **CSS模块化**：
	1. css使用@import url('a/b/c.css');方式引用依赖；上线前由构建工具合并压缩成单个文件；。
	2. 统一的namespace管理。
	3. 最大程度上集成，复用bootstrap这个css框架。并且在css模块化规划上借鉴其设计。
3. **HTML模块化**：采用无逻辑模板引擎 [Mustache](http://mustache.github.com/) 来组装html，强制隔离view和代码逻辑。
	1. 前端提供模板；后端只负责提供数据和数据接口。
	2. 为避免修改同步，原则上不允许后端开发人员修改前端模板。
	3. Page：单个页面，引用多个pagelet。
	4. Pagelet：单个业务逻辑相关模块（较独立的视图区块），引用多个widget。
	5. widget：业务无关的独立html片段（引用一个js和一个css）。
	6. 模板测试数据： 模板同级目录下 同名的.json 文件用于提供测试数据，以在测试期自动预览模板渲染效果。
	7. js和css引用：page模板中可引用自身对应的一个js和1个css，分别引入依赖的js和css，负责模块组装和模块通信逻辑。pagelet和widget模板文件中不直接引用对应的js和css,在测试期由测试工具引入其依赖的js，css。。
4. **I18n 国际化**： 前端在html模板上提供国际化标记，根据语言包数据来动态渲染。`{{#i18n}}test{{/i18n}}` 
5. **theme**： 提供不同皮肤样式。语言和皮肤相关样式可以单独加载，也可以由cdn服务器来合并请求，如`href="a.css&b.css&c.css"`
6. **img**：img目录位于src 根目录，按照功能模块划分目录。图片尽量不涉及国际化内容。
7. **Svn规划**：
	1. 前端使用 *独立* svn仓库(svn:svn.tbox.me/litb_ria)。
	2. **trunk**用于常规开发，上线；
	3. **branches**用于特性开发，开发完合并到主干；
	4. **tags** 用于存储上线发布的资源，可用于快速回滚。
8. **目录结构规划** 参见本项目目录结构。
9. **页面数据**
	1. 页面可以有一个通用的全局配置变量，存放常用信息，如目前的litb这个全局变量。
	2. 模块（widget，pagelet）相关的数据要求在模板渲染期间提供，或者使用模板html的自定义属性，如`<div class='widget' data-json='{...}'>` 。尽量避免全局变量。
	
##开发流程##
1. **开发&&自测**：在线预览mustache模板（包括page，pagelet，widget）。
	1. nodejs辅助预览工具：
		1. 工具提供自动化预览服务，如：
		1. 执行 `node test/nodejs/preview.js` 
		2. 访问 http://127.0.0.1:9999/template/page/weddingDresses/weddingDresses.html 即可预览 `page/weddingDresses/weddingDresses.html` 这个mustache模板；
		3. 模板数据默认从同名的 `page/weddingDresses/weddingDresses.json` json文件中读取。
		4. 计划后期增加在线编辑（模板及模板测试数据，js，css）即时预览功能。
	2. php辅助预览工具：
		1. http://127.0.0.1/litb-fe-prototype/test/php/preview.php?template=page/demo/demo.html
		2. or http://127.0.0.1/litb-fe-prototype/test/php/preview.php?template=page/weddingDresses/weddingDresses.html
		3. 模板数据默认从同名的json文件中读取
2. **前后端联调测试**：
	1. 后端配置前端资源的host，映射到前端开发机器(内网可访问)上，如 `192.168.61.7 cloud.lbox.me`
	2. 前端提供的测试环境可以按需合并后端引用的每个个js，css请求。联调阶段不压缩代码，只合并+排除重复资源引用。
	3. 模板和前端静态资源（js，css，img）都放在前端开发人员的开发机上，后端引用模板时通过HTTP请求加载模板(前端修改模板后后端开发人员立即可见更新)。
	   这个可以做成网络透明的，即后端开发人员可以根据环境配置使用相同方式引用本地或者远程模板。

3. **仿真测试**：
	1.检出代码，build（合并，压缩静态资源），提交给测试环境。和后端结合的目录结构由前后端开发人员商讨决定。

##发布流程##
1. 前端代码单独发布到cdn：
	1. 仿真测试通过的静态资源可直接提交到前端svn tags目录中。
	2. 构建工具会计算静态资源（js，css）文件内容的md5 hash，生成一个mapping.json 映射文件 (内容形如 ` { "page/demo/demo.css": "3e52e156b50b8080",...}`)。后端引用时需要从该映射文件中取对应的资源版本号,
	形如`<script src="http://cloud.lbox.me/ria/page/demo/demo.css?v=3e52e156b50b8080"></script>` 。
	3. 前端代码上线或者回滚后，提供最新的 mapping.json 映射文件给后端，以更新资源引用版本号，从而去掉旧版本号的缓存。
	4. 前端静态资源发布到cdn。
2. 模板文件也可以单独上线（也可以按照传统模式与后端代码一起上线）。模板单独上线的好处在于：构建工具可以动态更新模板中对js，css等静态资源的引用版本号（以文件内容md5值来控制缓存）。注意：模板文件与前端代码使用同一svn仓库；后端svn仓库不再重复存储模板文件。


#[visit the prototype demo](http://session.im:9999/)#



