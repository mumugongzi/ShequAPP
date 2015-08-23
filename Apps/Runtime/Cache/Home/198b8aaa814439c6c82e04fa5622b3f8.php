<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
  		<meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<title>用户登录 - <?php echo ($CONF['shopTitle']['fieldValue']); ?></title>
      	<meta name="keywords" content="<?php echo ($CONF['shopKeywords']['fieldValue']); ?>" />
      	<meta name="description" content="<?php echo ($CONF['shopTitle']['fieldValue']); ?>,用户登录" />
     	<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css">
     	<link rel="stylesheet" href="/Apps/Home/View/default/css/login.css">
   	</head>
   	<body>
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
<div id="wst-shortcut">
	<div class="w">
		<ul class="fl lh">
			<li class="fore1 ld"><b></b><a href="javascript:addToFavorite()"
				rel="nofollow">收藏<?php echo ($CONF['shopTitle']['fieldValue']); ?></a></li><s></s>
			<li class="fore3 ld menu" id="app-jd" data-widget="dropdown">
				<span class="outline"></span> <span class="blank"></span> 
				<a href="#" target="_blank"><img src="/Apps/Home/View/default/images/icon_top_02.png"/>&nbsp;<?php echo ($CONF['shopTitle']['fieldValue']); ?> 手机版</a>
			</li>
			<li class="fore4" id="biz-service" data-widget="dropdown" style='padding:0;'>&nbsp;<s></s>&nbsp;&nbsp;&nbsp;
				所在城市
				【<span class='wst-city'>&nbsp;<?php echo ($currArea["areaName"]); ?>&nbsp;</span>】
				<img src="/Apps/Home/View/default/images/icon_top_03.png"/>	
				&nbsp;&nbsp;<a href="javascript:;" onclick="changeCity();">切换城市</a><i class="triangle"></i>
			</li>
		</ul>
	
		<ul class="fr lh" style='float:right;'>
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='<?php echo WSTDomain();?>'><?php echo ($CONF['shopTitle']['fieldValue']); ?></a>！<s></s>&nbsp;
			<span>
				<?php if(!$WST_USER['userId']): ?><a href="<?php echo U('Home/Users/login');?>">[用户登录]</a>
				<a href="<?php echo U('Home/Users/regist');?>"	class="link-regist">[免费注册]</a><?php endif; ?>
				<?php if($WST_USER['userId'] > 0): ?><a href="javascript:logout();">[退出]</a><?php endif; ?>
			</span>
			</li>
			<li class="fore2 ld"><s></s>
			<!-- <?php if(session('WST_USER.userId')>0){ ?>
				<?php if(session('WST_USER.userType')==0){ ?>
				    <a href="<?php echo U('Home/Shops/toOpenShopByUser');?>" rel="nofollow">我要开店</a>
				<?php }else{ ?>
				    <?php if(session('WST_USER.loginTarget')==0){ ?>
				        <a href="<?php echo U('Home/Shops/index');?>" rel="nofollow">卖家中心</a>
				    <?php }else{ ?>
				        <a href="<?php echo U('Home/Users/index');?>" rel="nofollow">买家中心</a>
				    <?php } ?>
				<?php } ?>
			<?php }else{ ?>
			    <a href="<?php echo U('Home/Shops/toOpenShop');?>" rel="nofollow">我要开店de</a>
			<?php } ?> -->
			</li>
		</ul>
		<span class="clr"></span>
	</div>
</div>


   		<!--[if lt IE 9]>
      	<script src="/Public/js/html5shiv.min.js"></script>
      	<script src="/Public/js/respond.min.js"></script>
      	<![endif]-->
   			<div class='wst-login'>
   				<div style="margin: 0 auto;padding-left:60px;">
   					<a href="/index.php">
   						<img src="/Apps/Home/View/default/images/logo.png" height="100" width="100"/>
   					</a>
   				</div>
		    	<div class="w1" id="entry">
		    	
		        	<div class="mc " id="bgDiv" style="position:relative">
		        	<div><a style="text-decoration: none;font-size:65px;color:red;position:absolute;top:160px;left:60px;" href="<?php echo U('Index/index');?>"><?php echo ($CONF['shopTitle']['fieldValue']); ?></a></div>
		            
		            <div class="form">
		                <div class="item fore1" style="position:relative;">
		                    <span>用户名/手机号/邮箱</span><span id="errmsg" style="color:red;position:absolute;top:0px;left:100px;"></span>
		                    <div class="item-ifo">
		                        <input id="loginName" name="loginName" class="text"  tabindex="1" value="<?php echo ($loginName); ?>" autocomplete="off" type="text"/>
		                        <div class="i-name ico"></div>                       
		                    </div>
		                </div>               
		                <div class="item fore2">
		                    <span>密码</span>
		                    <div class="item-ifo">                       
		                        <input id="loginPwd" name="loginPwd" value="<?php echo ($loginPwd); ?>" class="text" tabindex="2" autocomplete="off" type="password"/>                      
		                        <div class="i-pass ico"></div>            
		                    </div>
		                </div>
		                <div class="item fore3 " id="o-authcode">
		                    <span>验证码</span>
		                    <div class="item-ifo">
		                        <input id="verify" style="ime-mode:disabled" name="verify" class="text text-1" tabindex="6" autocomplete="off" maxlength="6" type="text"/>
			                    <label class="img">
			                		<img style='vertical-align:middle;cursor:pointer;height:39px;' class='verifyImg' src='/Apps/Home/View/default/images/clickForVerify.png' title='刷新验证码' onclick='javascript:getVerify()'/> 
								</label>      	
			              		<label class="ftx23">&nbsp;看不清？<a href="javascript:getVerify()" class="flk13">换一张</a></label>
		                    </div>
		                </div>
		                <div class="item fore4" id="autoentry">
		                    <div class="item-ifo">
		                        <input class="checkbox" id="rememberPwd" name="rememberPwd" checked="checked" type="checkbox"/>
		                        <label class="mar">记住密码</label>                                      
		                        <label><a href="<?php echo U('Users/forgetPass');?>">忘记密码?</a></label>
		                        <div class="clr"></div>
		                    </div>
		            	</div>
		                <div class="item login-btn2013">
		                    <input class="btn-img btn-entry" id="loginsubmit" value="登录" tabindex="8" onclick="checkLoginInfo();"/>
		                </div>
		            </div> 
		        </div>
		        <div class="free-regist">
		            <span><a href="javascript:regist();" >免费注册&gt;&gt;</a></span>
		        </div>
		    </div>
		</div><script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      	<script src="/Public/js/common.js"></script>
      	<script src="/Apps/Home/View/default/js/common.js"></script>
      	<script src="/Apps/Home/View/default/js/login.js"></script>
		
   	</body>
</html>