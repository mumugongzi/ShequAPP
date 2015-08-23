<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
  		<meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<title>找回密码 - <?php echo ($CONF['shopTitle']['fieldValue']); ?></title>
      	<meta http-equiv="refresh" content="3;url=">
      	<meta name="keywords" content="<?php echo ($CONF['shopKeywords']['fieldValue']); ?>" />
      	<meta name="description" content="<?php echo ($CONF['shopTitle']['fieldValue']); ?>,忘记密码" />
      	<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css">
     	<link rel="stylesheet" href="/Apps/Home/View/default/css/footer.css">
		<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/plugins/lazyload/jquery.lazyload.min.js?v=1.9.1"></script>
<script type="text/javascript">
     var domainURL = "<?php echo WSTDomain();?>";
     var publicurl = "/Public";
     var currCityId = "<?php echo ($currArea['areaId']); ?>";
     var currCityName = "<?php echo ($currArea['areaName']); ?>";
     $(function() {
     	   $("img").lazyload({effect: "fadeIn",failurelimit : 10,threshold: 200,placeholder:'/Apps/Home/View/default/images/store_default_signlist.png'});
     });
</script>
   	</head>
   	<body>
	<div id="shortcut-2013">
		
	</div>
	<div class="main">
	    <div class="main-top">
	        <div class="forget-pwd">
	            <h5>找回密码</h5>
	            <div id="stepflex" class="stepflex">
	                <dl class="first done">
	                    <dt class="s-num">1</dt>
	                    <dd class="s-text">填写账户名<s></s><b></b></dd>
	                    <dd></dd>
	                </dl>
	                <dl class="normal done">
	                    <dt class="s-num">2</dt>
	                    <dd class="s-text">验证身份<s></s><b></b></dd>
	                </dl>
	                <dl class="normal done">
	                    <dt class="s-num">3</dt>
	                    <dd class="s-text">设置新密码<s></s><b></b></dd>
	                </dl>
	                <dl class="last doing">
	                    <dt class="s-num">&nbsp;</dt>
	                    <dd class="s-text">完成<s></s><b></b></dd>
	                </dl>
	            </div>
	            <h5 class="txt-center">修改密码成功，请记住新密码！</h5>
	            <h5 class="txt-center" style='font-size:13px'>3秒后返回首页，<a href="/index.php/Home/Orders/queryByPage.html" style='color:red;'>点击返回首页</a></h5>
	            </div>
	            <div class="clearfix"></div>
	        </div>
	    </div>
	</div>
	
	</body>
	<script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/common.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	    
	    $.formValidator.initConfig({formID:"loginForm",theme:"Default",submitOnce:true,
	        onError:function(msg,obj,errorlist){
	            console.log(msg);
	        },
	        ajaxPrompt : '有数据正在异步验证，请稍等...'
	    });
	   $("#loginPwd").formValidator({onShow:"请输入密码",onFocus:"至少5个字符,最多10个字符",onCorrect:"密码合法"}).inputValidator({min:5,max:10,onError:"你输入的密码非法,请确认"});
	    $("#repassword").formValidator({onShow:"输再次输入密码",onFocus:"至少5个字符,最多10个字符",onCorrect:"密码一致"}).compareValidator({desID:"loginPwd",operateor:"=",onError:"2次密码不一致,请确认"});   
	    
	});
	</script>
</html>