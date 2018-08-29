<script src="/win10ui/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="/layui/layui.all.js" type="text/javascript"></script>
<script>
var element = layui.element;
  
// 一些事件监听
element.on('tab(demo)', function(data) {
    
});

//执行操作
function handleDo(url, askSure, handleTitle, requestType) {
    if (askSure == 1) {
        layer.confirm('确定执行' + handleTitle + '吗？', function(index) {
            requestDo(url, handleTitle, requestType);
            layer.close(index);
        });
    } else {
        requestDo(url, handleTitle, requestType);
        
    }
}

//请求
function requestDo(url, handleTitle, requestType) {
    if (requestType == 1) {
        location.href = url;
    } else if (requestType == 2) {
        layer.open({
            type: 2,
            title: handleTitle,
            content: url,
            area: ['80%', '80%'],
            end: function() {
                location.reload();
            }
        });
    } else if (requestType == 2) {
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    layer.alert(res.info, {icon: 1});
                    location.reload();
                } else {
                    layer.alert(res.info, {icon: 2});
                }
            },
            error: function() {
                layer.alert('系统错误', {icon: 0});
            }
        })
    } else {
        layer.alert('此功能配置有误');
    }
}
</script>
