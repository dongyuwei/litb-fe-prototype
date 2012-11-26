/*
1.从src目录中提取page，pagelet，widget 目录下html模板；
2.压缩所有js，css；合并js，css。
3.替换src/page目录下所有html模板中script src和css link href,替换模板中?v=md5-hash 值为该资源对应的md5值。
4. 生成md5mapping.json 用于更新或者回滚。
*/
