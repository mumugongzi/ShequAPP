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
	                <dl class="normal doing">
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
	            <form method="post" id="loginForm" action="<?php echo U('Users/findPass'); ?>">
	            <input type="hidden" name="step" value="2">
	            <input type="hidden" name="userPhone" id="userPhone" value="<?php echo $forgetInfo['userPhone']; ?>">
	            <input type="hidden" name="loginName" id="loginName" value="<?php echo $forgetInfo['loginName']; ?>">
	            <table style="margin:0 auto;width:570px" class='forgettbl2'>
	                    <tbody>
	                        <tr>
	                            <th width='180px' nowrap>请选择验证身份方式：</th>
	                            <td><select name="type" id="type">
	                                <option value="phone">手机</option>
	                                <option value="email">邮箱</option>
	                            </select></td>
	                            <td><div id="typeTip" style="width:280px;text-align:left;"></div></td>
	                        </tr>
	                        <tr>
	                            <th>用户名：</th>
	                            <td colspan='2'><?php echo session('findPass.loginName'); ?></td>
	                        </tr>
	                        <tr class="phone-verify">
	                            <th>手机：</th>
	                            <td colspan='2'><?php echo $forgetInfo['userPhone'] == '' ? "没有预留手机号码，请尝试用邮箱找回！" : $forgetInfo['userPhone'] ; ?></td>
	                        </tr>
	                        <?php if($forgetInfo['userPhone'] != ''){ ?>
	                        <tr class="phone-verify">
	                            <th>请填写手机校验码：</th>
	                            <td>
	                                <input type="text" class='text' style='width:130px;' name="phoneVerify" id="phoneVerify">
	                            </td>
	                            <td><input style="width:100px;" class='btn-red' type="button" value="点击获取" id="getPhoneVerify"></td>
	                        </tr>
	                        <tr class="phone-verify">
	                            <td></td>
	                            <td colspan='2'><span id="phoneVerifyTip" style="width:280px;text-align:left;"></span></td>
	                        </tr>
	                        <tr class="phone-verify">
	                            <td colspan='3' style='padding-left:150px;'>
	                                <input class='btn-red' type="submit" id="goform" value="下一步">
	                            </td>
	                        </tr>
	                        <?php } ?>
	                        <tr class="email-verify">
	                            <th>邮箱地址：</th>
	                            <td colspan='2'><?php echo $forgetInfo['userEmail'] == '' ? "没有预留邮箱，请尝试用手机号码找回！" : $forgetInfo['userEmail'] ; ?></td>
	                        </tr>
	                        <?php if ($forgetInfo['userEmail'] != ''){ ?>
	                        <tr class="email-verify">
	                            <td colspan='3' style='padding-left:150px;'>
	                                <input class='btn-red' type="button" id="sendEmail" value="发送验证邮件">
	                            </td>
	                        </tr>
                            <?php } ?>
	                    </tbody></table>
	
	                </form>
	            </div>
	            <div class="clearfix"></div>
	        </div>
	    </div>
	</div>
	
	</body>
	<script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
	<script src="/Public/plugins/layer/layer.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/common.js"></script>
	<script type="text/javascript">
	var resetPassUrl = '';
	var findPassTime = 0;
	$(document).ready(function(){
	    $('#type').change(function(){
	        if ($('#type').val() == 'phone') {
	            $('.phone-verify').show();
	            $('.email-verify').hide();
	        }else{
	            $('.phone-verify').hide();
	            $('.email-verify').show();
	        }
	    })
	    $.formValidator.initConfig({formID:"loginForm",theme:"Default",debug:true,submitOnce:true,onSuccess:function(){
			   location.href=resetPassUrl;
		       return false;
		    },
	        onError:function(msg,obj,errorlist){
	            console.log(msg);
	        },
	        ajaxPrompt : '有数据正在异步验证，请稍等...'
	    });
	   $("#phoneVerify").formValidator({onShowText:"请输入手机验证码",onShow:"",onFocus:"",onCorrect:"手机验证码正确"}).inputValidator({min:6,max:6,onError:"手机验证码错误"})
	        .ajaxValidator({
	        dataType : "json",
	        async : true,
	        url : "<?php echo U('Home/Users/checkPhoneVerify'); ?>",
	        success : function(data){
	        	var json = WST.toJson(data);
	            if( json.status == "1" ) {
	            	resetPassUrl = json.url;
	                return true;
				} else {
					return "手机验证码错误,请检查！";
				}
	            return "手机验证码错误,请检查！";
	        },
	        buttons: $("#goform"),
	        error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
	        onError : "手机验证码错误！",
	        onWait : "正在对手机验证码进行合法性校验，请稍候..."
	    });
	    $("#getPhoneVerify").click(function(){
	    	if(findPassTime>0)return;
	    	if ($("#userPhone").val() == '') {
	            alert('你没有预留手机号码，不能通过手机号码找回，请尝试用邮箱找回！');
	        }else{
	            $.getJSON("<?php echo U('Home/Users/getPhoneVerify');?>", { loginName: $("#loginName").val(), time: Math.random(),userPhone:$("#userPhone").val()},
	              function(data){
	                if (data.status=='1'){
	                	findPassTime = data.time;
	                	var item = $("#getPhoneVerify");      
				        /*var flag = setInterval(function(){
				            if (findPassTime > 0) {
				                item.val(--findPassTime);
				            }else{
				                item.val("点击获取");
				                clearInterval(flag);
				            }*/
				        item.val("获取成功");
	                    $("#getPhoneVerify").val(data.time).click(function(){return false;});
	                    resetVerify();
	                }else if(data.status=='-2'){
	                	$("#phoneVerifyTip").find('div:first').html('<font color="red">您发送的短信数超过每日限额！</font>');
		            }else{
	                    $("#phoneVerifyTip").find('div:first').html('<font color="red">获取失败！请重新获取！</font');
	                }
	              });
	        }
	    });
	    $("#sendEmail").click(function(){
	    	var msg= layer.load('正在发送邮件，请稍后...', 3);
	        $.getJSON("<?php echo U('Home/Users/getEmailVerify');?>", { loginName: $("#loginName").val(), time: Math.random(),userPhone:$("#userPhone").val()},
	          function(data){
	        	layer.close(msg);
	            if (data.status==1){
	                $("#sendEmail").val('请查看邮件！并进行激活操作');
	                $("#sendEmail").click(function(){return false;});
	            }else{
	                $("#sendEmail").val('发送邮件失败！请重新发送！');
	            }
	          });
	    })
	
	    /**
	     * 重置手机验证码获取时间
	     */
	    function resetVerify(){
	        var item = $("#getPhoneVerify");      
	        var flag = setInterval(function(){
	            if (findPassTime > 0) {
	                item.val(--findPassTime);
	            }else{
	                item.val("点击获取");
	                clearInterval(flag);
	            }
	        },1000)
	    }
	});
	</script>
</html>