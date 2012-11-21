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

todo:
 1. dev tools for extracting,merging,compressing js and css.
 2. how to publish template to backend?
 3. howto publish frontend resources?