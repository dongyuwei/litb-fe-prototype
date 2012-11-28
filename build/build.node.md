see: https://github.com/dongyuwei/ria-packager

1.从src目录中提取page，pagelet，widget 目录下html模板；
2.压缩所有js，css；合并js，css。模板最终只需要引用page目录下对应的js，css；但按照目前的规划，从小组件到完整页面整合的方式来开发，pagelet和widget也可能单独被引用上线，这些目录下的静态资源也要打包上线。
3.替换src/page目录下所有html模板中script src和css link href,替换模板中?v=md5-hash 值为该资源对应的md5值。
4. 生成md5mapping.json 用于更新或者回滚。

