<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <textarea rows="10" cols="68"  name="Content" id="Content" style="width:90%;height:500px;"></textarea>
        <script type="text/javascript" charset="utf-8" src="/js/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="/js/ueditor/ueditor.all.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="/js/ueditor/lang/zh-cn/zh-cn.js"></script>
        <script>
           var editor = UE.getEditor("Content", {
               serverUrl: "<?=\ez\core\Route::createUrl('uedtserv')?>"
           });
        </script>
    </body>
</html>
