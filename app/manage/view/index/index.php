<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>系统后台</title>
    <script type="text/javascript" src="/win10ui/js/jquery-2.2.4.min.js"></script>
    <link href="/win10ui/css/animate.css" rel="stylesheet">
    <script type="text/javascript" src="/win10ui/component/layer-v3.0.3/layer/layer.js"></script>
    <link rel="stylesheet" href="/win10ui/component/font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="/win10ui/css/default.css" rel="stylesheet">
    <script type="text/javascript" src="/win10ui/js/win10.js"></script>
    <style>
        * {
            font-family: "Microsoft YaHei", 微软雅黑, "MicrosoftJhengHei", 华文细黑, STHeiti, MingLiu
        }
        /*磁贴自定义样式*/
        .win10-block-content-text {
            line-height: 44px;
            text-align: center;
            font-size: 16px;
        }
    </style>
    <script>
        Win10.onReady(function () {

            //设置壁纸
            Win10.setBgUrl({
                main:'/win10ui/img/wallpapers/main.jpg',
                mobile:'/win10ui/img/wallpapers/mobile.jpg',
            });

            Win10.setAnimated([
                'animated flip',
                'animated bounceIn',
            ], 0.01);
        });

        //该函数可删除 Orz
        function win10_forgive_me() {
            Win10.enableFullScreen();
            layer.alert('点击展示下一版本特性', {}, function(index){
                var blue=$('<img src="/win10ui/img/presentation/bluescreen.jpg" style="position: fixed;width: 100%;height:100%;top:0;z-index:9999999999" />');
                setTimeout(function () {
                    $('body').append(blue);
                },3000);
                setTimeout(function () {
                    blue.remove();
                    Win10.disableFullScreen();
                    setTimeout(function () {
                        layer.msg('开个玩笑，别打我');

                    },1000);
                },7000);
                layer.close(index);
            });
        }
    </script>
</head>
<body>
<div id="win10">
    <div class="desktop">
        <div id="win10-shortcuts" class="shortcuts-hidden">
            <?php 
            foreach ($apps as $val) {
                if (strpos($val['logo'], '/') !== FALSE) {
                    $icon   = "<img class='icon' src='". SITE_URL . $val['logo'] ."' />";
                } else {
                    $icon   = "<i class='fa ". $val['logo'] .' icon '. $val['logoColor'] ."'></i>";
                }
                $onclick    = empty($val['manageEntryUrl']) ? '' : "Win10.openUrl('".ez\core\Route::createUrl($val['manageEntryUrl'])."','".addslashes($icon)."{$val['title']}')";
            ?>
            <div class="shortcut" onclick="<?=$onclick?>">
                <?=$icon?>
                <div class="title"><?=$val['title']?></div>
            </div>
            <?php } ?>
        </div>
        <div id="win10-desktop-scene"></div>
    </div>
    <div id="win10-menu" class="hidden">
        <div class="list win10-menu-hidden animated animated-slideOutLeft">
            <div class="item" onclick="Win10.aboutUs()"><i class="purple icon fa fa-info-circle fa-fw"></i>关于</div>
            <div class="item" onclick="layer.open({
                title:'领红包',
                type: 1,
                area:'300px',
                offset:'50px',
                shadeClose:true,
                content: '<img width=\'300\' src=\'/win10ui/img/presentation/hongbao.jpg\' />'
            })"><i class="red icon fa fa-envelope fa-fw"></i>领红包</div>
            <div class="item" onclick="Win10.exit();"><i class="black icon fa fa-power-off fa-fw"></i>退出</div>
        </div>
        <div class="blocks">
            <div class="menu_group">
                <div class="title">
                    应用
                </div>
                <div loc="1,1" size="2,2" class="block" onclick="win10_forgive_me()">
                    <div class="content red">
                        <div style="text-align: center;font-size: 30px;line-height: 44px"><i class="fa fa-bug fa-fw"></i></div>
                        <div style="text-align: center;font-size: 16px;line-height: 44px">别点我</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="win10-menu-switcher"></div>
    </div>
    <div id="win10_command_center" class="hidden_right">
        <div class="title">
            <h4 style="float: left">消息中心 </h4>
            <span id="win10_btn_command_center_clean_all">全部清除</span>
        </div>
        <div class="msgs"></div>
    </div>
    <div id="win10_task_bar">
        <div id="win10_btn_group_left" class="btn_group">
            <div id="win10_btn_win" class="btn"><span class="fa fa-windows"></span></div>
            <div class="btn" id="win10-btn-browser"><span class="fa fa-internet-explorer"></span></div>
        </div>
        <div id="win10_btn_group_middle" class="btn_group"></div>
        <div id="win10_btn_group_right" class="btn_group">
            <div class="btn" id="win10_btn_time">
                <!--0:00<br/>-->
                <!--1993/8/13-->
            </div>
            <div class="btn" id="win10_btn_command"><span id="win10-msg-nof" class="fa fa-comment-o"></span></div>
            <div class="btn" id="win10_btn_show_desktop"></div>
        </div>
    </div>
</div>
</body>
</html>
