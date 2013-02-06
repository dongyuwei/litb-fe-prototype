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
6. **提高性能**：消除大部分页面内嵌js和css，提高静态资源缓存利用率和浏览器解析渲染html的性能。

###合理的架构可以让新手快速成长，独当一面;对多项目多任务可快速响应###

##设计规划##
部分文档根据内部lightsource工程做调整。

1. **JS模块化**：
 	1. 组件使用jQuery（or zepto）插件方式来组织代码；
	2. 使用`require('a/b/c.js');`方式引用依赖模块；上线前由构建工具合并压缩成单个文件；
	3. 所有js代码都在`dom ready`后执行。部分特殊代码可能需要在引用处立即运行，可特殊处理。
	4. js代码中如果涉及到大段html字符串拼接，要使用mustache.js模板来替换之，保证代码的结构化和可读性。
	5. 页面全局配置变量只有一个：`litb`。由后端打印出前端需要的通用信息。
	6. 使用（jQuery） **自定义事件** 在组件之间交换信息。发布的主题以`widget-xxx-topic` 形式，数据统一为单个Object类型变量. `on(bind)`和`trigger`的主体均为全局window,即$(window)。触发事件时只提供一个 Object 类型数据;
	     1.  **bind**  custom event：
	     ```
		$(window).on('widget-custom-event-name', function(event, data) {
			console.log(event, data);
		});
             ```
	     2.  **trigger**  custom event:
	     ```
		$(window).trigger('widget-custom-event-name',{'a' : 1, 'b' : 'str','list':[1,2,3]});
	     ```
	     3.  **unbind**  custom event:
	     ```
		$(window).off('widget-custom-event-name',[handler]);
	     ```
	
2. **CSS模块化**：
	1. 统一使用less来开发基础组件和业务代码，使用`@import-once 'a/b/c.less';`方式来引用依赖(注意要使用 **@import-once** 保证只引入一次)；上线前由构建工具合并压缩成单个文件。
	2. 统一的namespace管理，每个widget的最外层容器附加`class="widget widget-name"`,内部css均在`.widget-name`选择器内定义组件样式。
	3. 最大程度上集成，复用bootstrap这个css框架； **按需引用** 其组件.less源码(注意，bootstrap单个组件均依赖 **variables.less** 和 **mixins.less** 这2个基础文件，需要和特定组件一起引入)。
3. **HTML模块化**：采用无逻辑模板引擎 [Mustache](http://mustache.github.com/) 来组装html，强制隔离view和代码逻辑。
	1. 前端提供模板；后端只负责提供数据和数据接口。
	2. 为避免修改同步，原则上不允许后端开发人员修改前端模板。
	3. Page：单个页面，引用多个pagelet。
	4. Pagelet：单个业务逻辑相关模块（较独立的视图区块），引用多个widget。
	5. widget：业务无关的独立html片段。
	6. 同一widget被多次引用时需要提供不同上下文环境的数据.
	7. js和css引用：
		1. page模板中可引用自身对应的一个js和1个css，分别引入依赖的js和css，负责模块组装和模块通信逻辑。
		2. pagelet和widget模板文件中不直接引用对应的js和css,在测试期由测试工具自动引入其依赖的js，css。
	8. 每个widget组件容器DOM都要包含一个`class="widget widget-name"` 
	9. **模板数据**：
		1. 与html模板文件同名的json文件用于提供模板测试数据（_test/main.json, 其他_test/*.json 可在线切换，以测试不同模板数据测试效果）。
		2. 模板同名文件中I18N这个数据项（HashMap）提供测试国际化数据，可测试模板国际化效果。
		3.  **js脚本需要的数据** : 通过模板html的自定义属性，如`<div class='widget test' data-json='{{{jsonData}}}'>`；
		然后由js脚本来获取。注意， **jsonData** 在模板json数据中必须是已经经过json编码的 **字符串**.
                ```
                {"detail":"hahahh","jsonData":"{\"a\":[1,2,3],\"b\":{\"bb\":22}}"} 
                ```
		<br/>mustache模板渲染出来是：<br/>
		```
                <div class='widget test' data-json='{"a":[1,2,3],"b":{"bb":22}}'> 
                ```
                <br/>而下面就是错误的，mustache渲染出来的data-json无法被js解析利用：<br/>
                ```
                {"detail":"hahahh","jsonData":{"a":[1,2,3],"b":{"bb":22}}} 
                ```
		<br/>mustache模板渲染出来是<br/>
		```
                <div class='widget test' data-json='[object Object]'>
		```<br/>
		
4. **I18n 国际化**： 前端在html模板上提供国际化标记，后端根据语言包数据来动态渲染。
 1. 如`{{#i}}test{{/i}}`，无语言包数据时默认输出英文内容。前端模板只做英语版，其他版本由后台提供国际化语言包。前端可以创建特定testcase来测试某个特定语言。
 2. 语言相关的css加载在页面主要css和皮肤css之后。
 3. 语言相关的js如果单独加载，需要 **放在页面主js之前** ，如form表单的报错信息等。
5. **theme**： 提供不同皮肤样式。
	1. theme加载在主体css **之后** ;
	2. 语言和皮肤相关样式可以单独加载；
	2. 也可以由cdn服务器来合并请求，如`<link rel="stylesheet" type="text/css" href="http://cloud.lbox.me/mobile/??page/checkout_address_process/checkout_address_process.css?v=dbdd7e7721287c19,theme/blue/skin.css?v=99129a3f2430cb5a" />`则自动合并3个css文件，应答给浏览器。
6. **img**：img目录位于src 根目录，按照功能模块划分目录。图片尽量不涉及国际化内容。
7. **Svn规划**：
	1. 前端使用 *独立* svn仓库(svn:svn.tbox.me/litb_ria)。
	2. **trunk**用于常规开发，上线；
	3. **branches**用于特性开发，开发完合并到主干；
	4. **tags** 用于存储上线发布的资源，可用于快速回滚。
8. **目录结构规划** 参见本项目目录结构。	
9. 工程根目录下增加一个_tests目录，用于测试插件等独立代码（不适合放在widget，pagelet，page目录下的测试html）。
10. `lightsource` 工程为widget组件库，其他工程使用svn 外链引用它。
11. **ajax接口**：
      1. ajax请求附带上content-type参数，后端根据其值为 **json** 或者 **html** 而返回对应类型的数据。这样一个接口可供多个产品使用，有自定义模板的产品可以只请求json数据。
      2. 所有ajax请求后端接口均允许跨域访问，以方便开发测试---及开发与线上代码ajax接口地址可保持一致，不用为测试而修改。
12. 第三方外链脚本统一管理起来：原则是尽量延迟懒加载，避免阻塞主页面的加载和渲染，特殊情况可提前加载。
	1. img，script，iframe这3种类型的外链请求。
	2. head内和footer内加载的；
	3. document.write 和普通方式加载的；
	4. dom ready和window onload后加载的。
##开发流程##
1. **开发&&自测**：在线预览mustache模板（包括page，pagelet，widget）。
	1. 访问 mustache html模板文件 即可预览；
	2. 模板数据默认从 *同名的.json文件* 中读取。
	3. 可使用模板文件同级目录下_test/_layout.html包装widget和pagelet。
	4. 可使用模板文件同级目录下_test/xyz.json来做多模板测试数据。默认数据从模板同名json文件中读取。
	5. 可在线切换皮肤样式，语言包，模板数据。测试不同效果。
	6. page，pagelet引用widget模板时，widget模板对应的js和css需要开发者手动引入，以方便打包发布（后续可考虑自动引入）。
	7. 计划后期增加在线编辑（模板及模板测试数据，js，css）和即时预览功能。
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
	形如`<script src="http://cloud.lbox.me/ria/mobile/demo/demo.css?v=3e52e156b50b8080"></script>` 。
	3. 前端代码上线或者回滚后，提供最新的 mapping.json 映射文件给后端，以更新资源引用版本号，从而去掉旧版本号的缓存。
	4. 前端静态资源发布到cdn。
2. 模板文件也可以单独上线（也可以按照传统模式与后端代码一起上线）。模板单独上线的好处在于：构建工具可以动态更新模板中对js，css等静态资源的引用版本号（以文件内容md5值来控制缓存）。注意：模板文件与前端代码使用同一svn仓库；后端svn仓库不再重复存储模板文件。


##实施步骤##
1. 现在mobile部分页面实施，可与老代码并存。使用zepto.js代替jquery.js.
2. 兰亭主站主导航模块引入mustache模板，使用新开发模式。

##前端辅助工具##
开发环境，打包工具：https://github.com/dongyuwei/ria-packager

##部分规范##
1. 前端文件及目录均统一使用下划线和小写字母的组合。
2. css名称以a-b-c格式命名
3. html中id，name等以驼峰格式命名
4. js注释规范以jsDoc为标准
5. theme和language相关js，css单独请求。后期cdn支持动态合并静态资源时可与页面级静态资源合并为一个请求（最终为1个js+1个css）。
6. page名称需要与php共同约定。
7. 前端使用纯json数据+nodejs的mustache引擎来渲染mustache模板，php端的mustache引擎不可使用Lambdas这一特殊模板语法，目的是彻底避免数据中出现复杂ui逻辑。
8. 超长文本显示...,title显示完整文本。
9. less文件中使用`@body-background`，而不使用 `@bodyBackground`这种变量形式。


