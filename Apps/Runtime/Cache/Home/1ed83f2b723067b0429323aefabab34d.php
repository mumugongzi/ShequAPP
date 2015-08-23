<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
  		<meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<title>忘记密码 - <?php echo ($CONF['shopTitle']['fieldValue']); ?></title>
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
	                <dl class="first doing">
	                    <dt class="s-num">1</dt>
	                    <dd class="s-text">填写账户名<s></s><b></b></dd>
	                    <dd></dd>
	                </dl>
	                <dl class="normal">
	                    <dt class="s-num">2</dt>
	                    <dd class="s-text">验证身份<s></s><b></b></dd>
	                </dl>
	                <dl class="normal">
	                    <dt class="s-num">3</dt>
	                    <dd class="s-text">设置新密码<s></s><b></b></dd>
	                </dl>
	                <dl class="last">
	                    <dt class="s-num">&nbsp;</dt>
	                    <dd class="s-text">完成<s></s><b></b></dd>
	                </dl>
	            </div>
	            <form method="post" id="forgetPwdForm" action="<?php echo U('Users/findPass'); ?>">
	            <input type="hidden" name="step" value="1">
	                <table style="margin:0 auto;">
	                    <tbody>
	                        <tr>
	                            <th>用户名：</th>
	                            <td><input class="text" type="text" name="loginName" id="loginName" value=''></td>
	                            <td><div id="loginNameTip" style="width:280px;text-align:left;"></div></td>
	                        </tr>
	                        <tr>
	                            <th>验证码：</th>
	                            <td><input class="text" type="text" name="code" id="verify" maxlength="12" value=''></td>
	                            <td><div id="verifyTip" style="width:280px;text-align:left;"></div></td>
	                        </tr>
	                        <tr>
	                            <th></th>
	                            <td>
	                            <label class="img">
	                                    <img style='vertical-align:middle;cursor:pointer;height:39px;' class='verifyImg' src='/Apps/Home/View/default/images/clickForVerify.png' title='刷新验证码' onclick='javascript:getVerify()'/> 
									 </label>      	
	                                 <label class="ftx23">&nbsp;看不清？<a href="javascript:getVerify()" class="flk13">换一张</a></label>
	                            </td>
	                            <td></td>
	                        </tr>
	                        <tr>
	                            <th>&nbsp;</th>
	                            <td>
	                                <input class='btn-red' type="submit" id="goform" value="下一步">
	                            </td>
	                        </tr>
	                    </tbody></table>
	                </form>
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
		getVerify();
		$.formValidator.initConfig({formID:"forgetPwdForm",theme:"Default",submitOnce:true,
	        onError:function(msg,obj,errorlist){
	        }
	    });
		
	   $("#loginName").formValidator({onShowText:"请输入用户名",onShow:"",onFocus:"账户名不能为空",onCorrect:"&nbsp;"}).inputValidator({min:5,max:50,onError:"你输入的用户名非法,请确认"})
	        .ajaxValidator({
	        dataType : "json",
	        async : true,
	        url : "<?php echo U('Users/checkLoginKey'); ?>",
	        success : function(data){
	            if( data.status == -1) return true;
	            return "该用户不存在,请检查！";
	        },
	        buttons: $("#goform"),
	        error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
	        onError : "该用户不存在！",
	        onWait : "正在对用户名进行合法性校验，请稍候..."
	    });
	    $("#verify").formValidator({onShow:"",onFocus:"请输入正确的验证码！",onCorrect:"输入正确！",defaultValue:""})
	        .ajaxValidator({
	        dataType : "json",
	        async : true,
	        url : "<?php echo U('Users/checkCodeVerify'); ?>",
	        success : function(data){
	            if( data.status == 1) return true;
	            return "验证码错误";
	        },
	        buttons: $("#button"),
	        error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
	        onError : "验证码错误",
	        onWait : "正在对验证码进行合法性校验，请稍候..."
	    });
	});
	</script>
</html>