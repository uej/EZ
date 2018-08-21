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
        <script src="/js/CryptoJS/rollups/md5.js" type="text/javascript"></script>
        <script src="/js/CryptoJS/rollups/sha1.js" type="text/javascript"></script>
        <!--<script src="/js/CryptoJS/rollups/aes.js" type="text/javascript"></script>-->
        <!--<script src="/js/CryptoJS/components/pad-zeropadding-min.js" type="text/javascript"></script>-->
        <!--<script src="/js/CryptoJS/components/aes-min.js" type="text/javascript"></script>-->
        <script>
            
        /**
         * 接口数据加密函数
         * @param str string 需加密的json字符串
         * @param key string 加密key(16位)
         * @param iv string 加密向量(16位)
         * @return string 加密密文字符串
         */
        function encrypt(str, key, iv) {
            //密钥16位
            key = CryptoJS.enc.Utf8.parse(key);
            console.log(key.toString());
            //加密向量16位
            iv = CryptoJS.enc.Utf8.parse(iv);
            console.log(iv.toString());
            var encrypted = CryptoJS.AES.encrypt(str, key, {
                iv: iv,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.ZeroPadding
            });
            return encrypted;
        }

        /**
         * 接口数据解密函数
         * @param str string 已加密密文
         * @param key string 加密key(16位)
         * @param iv string 加密向量(16位)
         * @returns {*|string} 解密之后的json字符串
         */
        function decrypt(str, key, iv) {
            //密钥16位
            key = CryptoJS.enc.Utf8.parse(key);
            //加密向量16位
            iv = CryptoJS.enc.Utf8.parse(iv);
            var decrypted = CryptoJS.AES.decrypt(str, key, {
                iv: iv,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.ZeroPadding
            });
            return decrypted.toString(CryptoJS.enc.Utf8);
        }
        
        var key_hash = CryptoJS.MD5("是的1");
        console.log(key_hash.toString());
        var sha1_hash = CryptoJS.SHA1('是的1');
        console.log(sha1_hash.toString());
//        var key = CryptoJS.enc.Utf8.parse(key_hash);
//        var iv  = CryptoJS.enc.Utf8.parse('1234567812345678');
//        var encrypted = CryptoJS.AES.encrypt("Message", key, { iv: iv,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.ZeroPadding});
////        console.log(aesEncrypt.iv.toString(CryptoJS.enc.Hex));
//        console.log(encrypted.toString());
            
        </script>
    </body>
</html>
