##兰亭前端模块化架构设计目标：##
###前端模块化，前后端分离，前端可独立发布上线，加快迭代开发进度。理想情况下，后端只需要提供模块数据及数据接口。###
 1. bootstrap css + html template+js ： View central(View drive)
 2. 根据模块html路径自动加载pagelet和widget对应的js css。约定胜于配置（合理的目录结构约定）。
    重载 mustache loadPartial方法就可以实现自动加载Partial HTML 对应的JS和CSS等资源，https://github.com/bobthecow/mustache.php/blob/master/src/Mustache/Engine.php#L440
 3. page js css只引入自身需要的js模块，不再需要手动引用pagetlet和widget对应的js和css模块。特殊模块依然可以手动引入。
 4. 后端允许垮域ajax请求以方便测试。
 5. interface get or post api 统一管理起来。
 6. 开发测试期，js，css直接配置cdn host。
 7. js以require or $import管理依赖；css以@import 管理依赖。
 8. js组件以jQuery插件方式组织代码，业务代码以task方式组织代码，dom ready时依次执行。
 9. css以bootstrap模块化为参考标准，namespace统一管理。
 10. html以Mustache模板来组织，每个页面page包含一到多个pagelet，每个pagelet包含一到多个widget。widget是业务无关组件。pagelet是按照相对独立的html视图区块来划分,具有一定可复用性。
 11. i18n目录用于多国语言包，根据页面配置动态加载。国际化处理尽量在后端处理。
 12. img目录存放所有图片。尽量采用无图化设计。img按照功能划分目录。

todo:
 1. dev tools for extracting,merging,compressing js and css.
 2. how to publish template to backend?
 3. howto publish frontend resources?
 
问题：
 1. html(page,pagelet,widget模板)是否分离为独立版本控制的项目？ 
 2. 模板传统上由php工程师制作，新开发模式下前端fe和phper如何分工合作？
 3. litb，mini，mobile及将来新网站项目如何划分项目及目录结构？如何共享代码且避免文件膨胀？
