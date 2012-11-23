##兰亭前端模块化架构设计目标：##
###前端模块化，前后端分离，前端可独立发布上线，加快迭代开发进度。理想情况下，后端只需要提供模块数据及数据接口。###
 1. bootstrap css + html template+js ： View central(View drive)
 2. 不自动加载pagelet， js，css，手动管理依赖及顺序。
 3. build 时生成模板和debug，release版静态资源。自动替换资源引用，以 src=http://cloud.lbox.me/fe/test.js?v=md5-hash 控制版本号更新。
 4. test 目录从src目录独立出来，存放所有测试文件。
 5. build 目录从src目录中独立出来，存放build脚本工具，开发联调期调用。测试通过后发布到tags目录，上线。
 6. 开发测试期，js，css直接配置cdn host。
 7. js以require or $import管理依赖；css以@import 管理依赖。
 8. js组件以jQuery插件方式组织代码，业务代码以task方式组织代码，dom ready时依次执行。
 9. css以bootstrap模块化为参考标准，namespace统一管理。
 10. html以Mustache模板来组织，每个页面page包含一到多个pagelet，每个pagelet包含一到多个widget。widget是业务无关组件。pagelet是按照相对独立的html视图区块来划分,具有一定可复用性。
 11. i18n目录用于多国语言包，根据页面配置动态加载。国际化处理尽量在后端处理。
 12. img目录存放所有图片。尽量采用无图化设计。img按照功能划分目录，尽量不涉及国际化内容或者文字。
 13. 每个page，pagelet，widget目录下都有一个相同前缀的js，css，html（mustache模板），php（demo文件）。其中pagelet和widget的html模板文件不能引用对应的js和css，php测试文件可以引用它们，附加在头尾部分。
 14. use jQuery custom event for communication


