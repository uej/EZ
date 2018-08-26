<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <style>
        #win10-login {
            background: url('/win10ui/img/wallpapers/login.jpg') no-repeat fixed;
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
            position: fixed;
            z-index: -1;
            top: 0;
            left: 0;
        }

        #win10-login-box {
            width: 300px;
            overflow: hidden;
            margin: 0 auto;
        }

        .win10-login-box-square {
            width: 105px;
            margin: 0 auto;
            border-radius: 50%;
            background-color: darkgray;
            position: relative;
            overflow: hidden;
        }

        .win10-login-box-square::after {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .win10-login-box-square .content {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        input {
            width: 90%;
            display: block;
            border: 0;
            margin: 0 auto;
            line-height: 36px;
            font-size: 20px;
            padding: 0 1em;
            border-radius: 5px;
            margin-bottom: 11px;
        }

        .login-username, .login-password {
            width: 91%;
            font-size: 13px;
            color: #999;
        }

        .login-password {
            width: calc(91% - 54px);
            -webkit-border-radius: 2px 0 0 2px;
            -moz-border-radius: 2px 0 0 2px;
            border-radius: 5px 0 0 5px;
            margin: 0px;
            float: left;
        }
        
        .login-vcode {
            width: calc(91% - 100px);
            -webkit-border-radius: 2px 0 0 2px;
            -moz-border-radius: 2px 0 0 2px;
            border-radius: 5px 0 0 5px;
            float: left;
        }
        
        .vcode {
            margin: 0px;
            float: left;
            -webkit-border-radius: 0 5px 5px 0;
            -moz-border-radius: 0 5px 5px 0;
            border-radius: 0 5px 5px 0;
            background-color: #009688;
            width: 100px;
            display: inline-block;
            height: 36px;
            line-height: 36px;
            padding: 0 auto;
            color: #fff;
            white-space: nowrap;
            text-align: center;
            font-size: 14px;
            border: none;
            cursor: pointer;
            opacity: .9;
            filter: alpha(opacity=90);
            overflow: hidden;
        }
        .vcode img {
            width: 100%;
            height: 100%;
        }

        .login-submit {
            margin: 0px;
            float: left;
            -webkit-border-radius: 0 5px 5px 0;
            -moz-border-radius: 0 5px 5px 0;
            border-radius: 0 5px 5px 0;
            background-color: #009688;
            width: 54px;
            display: inline-block;
            height: 36px;
            line-height: 36px;
            padding: 0 auto;
            color: #fff;
            white-space: nowrap;
            text-align: center;
            font-size: 14px;
            border: none;
            cursor: pointer;
            opacity: .9;
            filter: alpha(opacity=90);
        }
    </style>
</head>
<body>
<div id="win10-login">
    <div style="height: 10%;min-height: 120px"></div>
    <div id="win10-login-box">
        <div class="win10-login-box-square">
            <img src="/win10ui/img/avatar.jpg" class="content"/>
        </div>
        <p style="font-size: 24px;color: white;text-align: center">游客</p>
        <input type="text" id="account" placeholder="请输入登录名" class="login-username">
        <?php if (ez\core\Ez::config('loginVerifyCode')) { ?>
        <input type="text" id="verifyCode" placeholder="请输入验证码" class="login-username login-vcode">
        <div class="vcode">
            <img id="vcode" src="<?= ez\core\Route::createUrl('verifyCode')?>">
        </div>
        <?php } ?>
        <input type="password" id="password" placeholder="请输入密码" class="login-password">
        <input type="submit" id="dologin" value="登录" id="btn-login" class="login-submit"/>
    </div>
</div>

<script src="/layui/layui.all.js" type="text/javascript"></script>
<script src="/win10ui/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="/js/CryptoJS/rollups/md5.js" type="text/javascript"></script>
<script src="/js/CryptoJS/rollups/sha1.js" type="text/javascript"></script>
<script>
/**
 * 刷新验证码
 */
$("#vcode").click(function() {
    $(this).attr("src", "<?=ez\core\Route::createUrl('verifyCode')?>?" + Math.random());
});

/**
 * 登录
 */
$("#dologin").click(function() {
    var account = $("#account").val();
    var passwd  = $("#password").val();
    
    if (account == '' || account == null) {
        layer.msg('请输入登录名');
        return;
    }
    <?php if (ez\core\Ez::config('loginVerifyCode')) { ?>
    var vcode   = $("#verifyCode").val();
    if (vcode == '' || vcode == null) {
        layer.msg('请输入验证码');
        return;
    }
    <?php } ?>
    if (passwd == '' || passwd == null) {
        layer.msg('请输入密码');
        return;
    }
    
    $.ajax({
        url: "<?= ez\core\Route::createUrl('salt')?>",
        type: "get",
        data: "verifyCode=" + vcode,
        dataType: "json",
        success: function(data) {
            if (data.status == 1) {
                var salt = data.data;
                var password = CryptoJS.MD5(CryptoJS.MD5(account + CryptoJS.SHA1(CryptoJS.SHA1(account+passwd).toString())) + salt).toString();
                $.ajax({
                    url: "<?= ez\core\Route::createUrl('isLogin')?>",
                    type: "post",
                    dataType: "json",
                    data: {account:account, password:password},
                    success: function(resdata) {
                        if (resdata.status == 1) {
                            location.href = resdata.info;
                        } else {
                            layer.msg(resdata.info);
                        }
                    },
                    error: function() {
                        layer.msg('请求失败，请稍后再试！');
                    }
                });
            } else {
                layer.msg(data.info);
            }
        },
        error: function() {
            layer.msg('请求失败，请稍后再试');
        }
    });
});
</script>
</body>
</html>
