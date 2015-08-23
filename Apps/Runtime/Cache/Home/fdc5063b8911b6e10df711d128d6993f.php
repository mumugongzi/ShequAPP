<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
  		<meta content="text/html; charset=utf-8" />

		<meta name="robots" content="noindex,nofollow" />
		<meta name="googlebot" content="noimageindex" /> 

		<meta name="copyright" content="" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=yes" />
		<meta name="format-detection" content="email=no" />

		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>

      	<title>用户注册 - <?php echo ($CONF['shopTitle']['fieldValue']); ?></title>
      	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/> -->
      	<meta name="keywords" content="<?php echo ($CONF['shopKeywords']['fieldValue']); ?>" />
      	<meta name="description" content="<?php echo ($CONF['shopTitle']['fieldValue']); ?>,用户注册" />
      	<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css">
      	<link rel="stylesheet" href="/Apps/Home/View/default/css/regist.css">
     	<link rel="stylesheet" href="/Apps/Home/View/default/css/passport.css">
     	<link rel="stylesheet" href="/Apps/Home/View/default/css/footer.css">	
   	</head>

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
	
   	var userProtocolUrl = "<?php echo U('Home/Index/toUserProtocol');?>";
   	</script>
   	<body>
	
	<div class="wst-regist" id="registhd">
	    <div style="margin-top:10px;"> 
	    <a href="#">
	    	<span style="font-size:30px;color:black;">欢迎注册</span>
   		 </a>
	    </div>
	</div>
	
	<div class="wst-regist" id="regist">	    
	    <div class="mc">
	    	<?php if(!$WST_USER['userId']): ?><form id="register" method="post" >
	            <input name="regType" id="regType" value="person" type="hidden"/>
	            <input name="nameType" id="nameType" value="2"  type="hidden" />
	            <div class="form">
	                <div class="item" id="select-regName">
	                    <span class="label"><b class="ftx04">*</b>账户名：</span>	
	                    <div class="fl item-ifo">
	                        <div class="o-intelligent-regName" style="position:relative;">	                       
	                            <input id="loginName" name="loginName" class="text text-1" tabindex="1" maxlength="30" autocomplete="off" onpaste="return false;" style="ime-mode:disabled;" onblur="onblurName(this);" onfocus="onfocusName(this);" value="邮箱/用户名/手机号"  type="text"/>
	                           <div id="loginNameTip" style="display: inline-block; "></div>
								<div id="namelist" style="display:none;position:absolute;width:268px;top:36px;left:0px;border:1px solid #CCCCCC;"></div>
	                        </div>	                        
	                    </div>
	                </div>	                
	                <div id="o-password">
	                    <div class="item">
	                        <span class="label"><b class="ftx04">*</b>请设置密码：</span>	
	                        <div class="fl item-ifo">
	                            <input id="loginPwd" name="loginPwd"  class="text text-1" class="text" tabindex="2" style="ime-mode:disabled;" autocomplete="off" type="password"/>
	                            <label id="pwd_succeed" class="pwdblank"></label>	                           
	                        </div>
	                    </div>	
	                    <div class="item">
	                        <span class="label"><b class="ftx04">*</b>请确认密码：</span>	
	                        <div class="fl item-ifo">
	                            <input id="reUserPwd" name="reUserPwd" class="text text-1" tabindex="3" autocomplete="off" type="password"/>	                            
	                            <label id="pwdRepeat_succeed" class="pwdblank"></label>	                           
	                        </div>
	                    </div>
						<div class="item" style="display:none;">
	                        <span class="label">电子邮箱：</span>	
	                        <div class="fl item-ifo">
	                            <input id="userEmail" name="userEmail" class="text" tabindex="3" autocomplete="off" style="ime-mode:disabled;" type="text"/>	                           
	                            <label id="pwdRepeat_succeed" ></label>	                           
	                        </div>
	                    </div>     
	                    <div class="item" style="display:none;">
	                        <span class="label"><b class="ftx04">*</b>手机号码：</span>	
	                        <div class="fl item-ifo">
	                            <input id="userPhone" name="userPhone" class="text" tabindex="3" autocomplete="off" type="text" maxlength="11"/>	                           
	                            <label id="pwdRepeat_succeed" ></label>	                           
	                        </div>
	                    </div> 
	                               
	                    <div class="item" id="mobileCodeDiv" style="display:none;">
	                        <span class="label"><b class="ftx04">*</b>短信验证码：</span>	
	                        <div class="fl item-ifo">
	                            <input maxlength="6" autocomplete="off" tabindex="6" class="text text-1" name="mobileCode" style="ime-mode:disabled" id="mobileCode" type="text"/>
	                            <label class="blank invisible"></label>
	                            <a class="btn" href="javascript:void(0);" onclick="getVerifyCode();" id="sendMobileCode">
	                                <span id="timeTips">获取短信验证码</span>
	                           	</a>
	                        </div>
	                        <span class="clr"></span>
	                    </div>
	                     
	                  	<div class="item" id="authcodeDiv">
	                            <span class="label"><b class="ftx04">*</b>验证码：</span>	
	                            <div class="fl item-ifo">
	                                <input id="authcode" style="ime-mode:disabled" name="authcode" class="text text-1" tabindex="6" autocomplete="off" maxlength="6" type="text"/>
	                                <label class="img">
	                                    <img style='vertical-align:middle;cursor:pointer;height:39px;' class='verifyImg' src='/Apps/Home/View/default/images/clickForVerify.png' title='刷新验证码' onclick='javascript:getVerify()'/> 
									 </label>      	
	                                <label class="ftx23">&nbsp;看不清？<a href="javascript:getVerify()" class="flk13">换一张</a></label>
	                            </div>
	                 	</div>	
	                 	 
	                </div>
	                <input name="qVoCgWxtvu" value="EqaRK" type="hidden"/>	
	                
	                <div class="item">
	                    
	                    <div class="fl item-ifo">
	                        <label>
	                        <input class="checkbox" id="protocol" name="protocol" type="checkbox"/>
	                              我已阅读并同意</label><a href="<?php echo U('Home/Users/protocol');?>" class="blue" id="protocolInfo" >《用户注册协议》</a>                                                                 
	                        <label id="protocol_error" class="error hide">请接受服务条款</label>
	                    </div>
	                </div>

	                <div class="item">
	                    <span class="label">&nbsp;</span>
	                    <input class="btn-img btn-regist" id="registsubmit" value="立即注册" tabindex="8"  type="submit"/>
	                </div>
	                
	            </div>
	            
	        </form>
	        <?php else: ?>
	        <div style="line-height:150px;text-align: center;font-size:18px;">请先退出当前帐号再进行注册 !</div><?php endif; ?>
	    </div>
	</div>
	
	
	<script src="/Public/plugins/layer/layer.min.js"></script>
   	<script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/regist.js"></script>
   
</body>
</html>