
var curRowIndex = 0;
var emailList = new Array("","163.com","126.com","qq.com","sina.com","gmail.com","sohu.com","vip.126.com","188.com","139.com");


function optionsOver(idx){	
	$(".options").css("background-color","white");
	//obj.style.backgroundColor = "#E9E5E1";	
//alert(document.getElementById("nopt"+idx));
	$("#nopt"+idx).css("background-color","#E9E5E1");
	curRowIndex = idx;	
	//jQuery("#tt").val(curRowIndex);
}

function selectOpt(optionId){
	$("#loginName").val($("#nopt"+optionId).html());
	$("#namelist").hide();
}

var orgva = "";
	function onfocusName(obj){
		var keywords = jQuery.trim(obj.value);
		
		if(keywords=='邮箱/用户名/手机号'){
			obj.value='';
			obj.style.color='#333';
		}else{
			if(keywords.length>0){
				var html = new Array();
				if(keywords.indexOf("@")>=0){
					var works = keywords.split("@");
					var rworks = keywords.split("@")[0];
					var lworks = keywords.split("@")[1];					
					for(var i=0;i<emailList.length;i++){
						if(emailList[i].indexOf(lworks)==0){
							html.push("<div class='options' idx='"+i+"' id='nopt"+i+"' onmouseover='optionsOver("+i+");' onclick='selectOpt("+i+")'>"+rworks+(i==0?"":"@")+emailList[i]+"</div>");
						}
					}
				}else{
					for(var i=0;i<emailList.length;i++){						
						html.push("<div class='options' idx='"+i+"' id='nopt"+i+"' onmouseover='optionsOver("+i+");' onclick='selectOpt("+i+")'>"+keywords+(i==0?"":"@")+emailList[i]+"</div>");		
					}
				}				
				$("#namelist").show();
				$("#namelist").html(html.join(""));
				optionsOver(0);
			}
		}
		orgva = obj.value;
		jQuery("#loginNameTip").removeClass();
		jQuery("#loginNameTip").addClass("onFocus");
		jQuery("#loginNameTip").html("<span>请输入邮箱/用户名/手机号</span>");
	}

	function onblurName(obj){
		if(document.getElementById("nopt"+curRowIndex)){
			$("#loginName").val($("#nopt"+curRowIndex).html())
		}
		$("#namelist").hide();
		var uname = $.trim(obj.value);
		if(uname=='') {
			obj.value='邮箱/用户名/手机号';
			obj.style.color='#999999';
			jQuery("#loginNameTip").removeClass();
			jQuery("#loginNameTip").addClass("onError");
			jQuery("#loginNameTip").html("<span>请输入邮箱/用户名/手机号</span>");
			jQuery("#nameType").val(2);
			return;
		}else{
		
			if(uname.indexOf("@")>=0){
				jQuery("#loginNameTip").removeClass();			
				if(new RegExp(regexEnum.email).test(uname)){
					jQuery("#userEmail").val(uname);
					jQuery("#userPhone").val("");
					jQuery("#nameType").val(1);
					jQuery("#loginNameTip").removeClass();
					if(uname==orgva){
						//jQuery("#loginNameTip").addClass("onCorrect");
						//jQuery("#loginNameTip").html("<span>输入正确</span>");
						
					}else{
						jQuery("#loginNameTip").addClass("onFocus");
						jQuery("#loginNameTip").html("<span>请稍候...</span>");
					}
					jQuery("#authcodeDiv").show();
					jQuery("#mobileCodeDiv").hide();
					changeName();
					
				}else{
					jQuery("#loginNameTip").addClass("onError");
					jQuery("#loginNameTip").html("<span>输入的邮箱格式不正确</span>");
					return;
				}			
			}else if(new RegExp(regexEnum.mobile).test(uname) && uname.length==11){
				jQuery("#userEmail").val("");
				jQuery("#userPhone").val(uname);
				jQuery("#loginNameTip").removeClass();
				jQuery("#nameType").val(3);
				if(uname==orgva){
					//jQuery("#loginNameTip").addClass("onCorrect");
					//jQuery("#loginNameTip").html("<span>输入正确</span>");
					
				}else{
					jQuery("#loginNameTip").addClass("onFocus");
					jQuery("#loginNameTip").html("<span>请稍候...</span>");
				}
				changeName();
				jQuery("#authcodeDiv").hide();
				jQuery("#mobileCodeDiv").show();
			}else if(new RegExp(regexEnum.num).test(uname)){
				jQuery("#loginNameTip").addClass("onError");
				jQuery("#loginNameTip").html("<span>用户名不能是纯数字,请确认输入的是手机号或者重新输入</span>");
				return;
			}else{
				jQuery("#userEmail").val("");
				jQuery("#userPhone").val("");
				jQuery("#nameType").val(2);
				jQuery("#loginNameTip").removeClass();
				if(uname==orgva){
					//jQuery("#loginNameTip").addClass("onCorrect");
					//jQuery("#loginNameTip").html("<span>输入正确</span>");
					changeName();
				}else{
					jQuery("#loginNameTip").addClass("onFocus");
					jQuery("#loginNameTip").html("<span>请稍候...</span>");
				}
				changeName();
				jQuery("#authcodeDiv").show();
				jQuery("#mobileCodeDiv").hide();
			}
		}
		
	}
function changeName(){
		var params = {};
			params.loginName = $.trim($('#loginName').val());
			
			if(params.loginName!="" && params.loginName!="邮箱/用户名/手机号"){
				jQuery.post(domainURL +"/index.php/Home/Users/checkLoginName/" ,params,function(rsp) {
					var json = WST.toJson(rsp);
					if( json.status == "1" ) {
						jQuery("#loginNameTip").removeClass();
						jQuery("#loginNameTip").addClass("onCorrect");
						jQuery("#loginNameTip").html("输入正确");
						return true;
					} else {
						jQuery("#loginNameTip").removeClass();
						jQuery("#loginNameTip").addClass("onError");
						jQuery("#loginNameTip").html("账号已存在");
						return false;
					}
				});	
			}
	}
$(function(){
	getVerify();
	 $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"register",debug:true,submitOnce:true,onSuccess:function(){
				if(jQuery("#loginNameTip").attr("class")=="onCorrect"){
				
					regist();
				}
			    return false;
			},onerror:function(msg){
			var uname = jQuery("#loginName").val();		
			if(uname=="邮箱/用户名/手机号"){
				jQuery("#loginNameTip").removeClass();			
				jQuery("#loginNameTip").addClass("onError");
				jQuery("#loginNameTip").html("请输入邮箱/用户名/手机号");
			}
		}});
	
	
	
	$("#loginPwd").formValidator({
		onShow:"",onFocus:"6-20位之间"
		}).inputValidator({
			min:6,max:20,onError:"6-20位之间"
		});
	$("#reUserPwd").formValidator({
		onShow:"",onFocus:"密码不一致。",onCorrect:"密码一致"
		}).inputValidator({
			min:6,max:20,onError:"6-20位之间"
		}).compareValidator({
			desID:"loginPwd",operateor:"=",onError:"两次密码不同。"
		});
	
	
	
	loadSearchList("loginName","namelist");
	
	
});





var time = 0;
var isSend = false;
var isUse = false;
function getVerifyCode(){
		
		if($.trim($("#userPhone").val())==''){
			WST.msg('请输入手机号码!', {icon: 5});
			return;
		}
		if(isSend )return;
		isSend = true;
		
		var params = {};
		params.userPhone = $.trim($("#userPhone").val());
		$.post(domainURL +"/index.php/Home/Users/getPhoneVerifyCode/",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status==-4){
				WST.msg('手机号码格式错误!', {icon: 5});
				time = 0;
				isSend = false;
			}else if(json.status==-3){
				WST.msg('该手机号码已注册!', {icon: 5});
				time = 0;
				isSend = false;
			}else if(json.status==-2){
				WST.msg('您的手机已超过每日最大短信验证数!', {icon: 5});
				time = 0;
				isSend = false;
			}else if(json.status==-1){
				WST.msg('短信發送失敗!', {icon: 5});
				time = 0;
				isSend = false;
			}else if(json.status==1){
				time = 120;
				$('#timeTips').css('width','100px');
				$('#timeTips').html('获取验证码(120)');
				$('#mobileCode').val(json.phoneVerifyCode);
				var task = setInterval(function(){
					time--;
					$('#timeTips').html('获取验证码('+time+")");
					if(time==0){
						isSend = false;						
						clearInterval(task);
						$('#timeTips').html("重新获取验证码");
					}
				},1000);
			}
		});
	}

function regist(){	
	
	if($("#nameType").val()==3){
		if($.trim($("#mobileCode").val())==""){		
			WST.msg('请输入验证码!', {icon: 5});
			$("#mobileCode").focus();
			return;
		}
	}else{
	
		if($.trim($("#authcode").val())==""){		
			WST.msg('请输入验证码!', {icon: 5});
			$("#mobileCode").focus();
			return;
		}
	}

	if(!document.getElementById("protocol").checked){		
		WST.msg('必须同意使用协议才允许注册!', {icon: 5});
		return;
	}
  	var params = {};
	params.loginName = $.trim($('#loginName').val());
	params.loginPwd = $.trim($('#loginPwd').val());
	params.reUserPwd = $.trim($('#reUserPwd').val());
	params.userEmail = $.trim($('#userEmail').val());
	
	params.userTaste = $('#userTaste').val();
	//params.userQQ = $.trim($('#userQQ').val());
	params.userPhone = $.trim($('#userPhone').val());
	params.mobileCode = $.trim($('#mobileCode').val());
	
	params.verify = $.trim($('#authcode').val());
	params.nameType = $("#nameType").val();
	params.protocol = document.getElementById("protocol").checked?1:0;	
	
	$.post(domainURL +"/index.php/Home/Users/toRegist/",params,function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status>0){
			WST.msg('注册成功，正在跳转登录!', {icon: 6}, function(){
				location.href=domainURL +'/index.php';
   			});
		}else if(json.status==-2){
			WST.msg('用户名已存在!', {icon: 5});
		}else if(json.status==-3){
			WST.msg('两次输入密码不一致!', {icon: 5});
		}else if(json.status==-4){
			WST.msg('验证码错误!', {icon: 5});
		}else if(json.status==-6){
			WST.msg('必须同意使用协议才允许注册!', {icon: 5});
		}else if(json.status==-5){
			WST.msg('验证码已超过有效期!', {icon: 5});
		}else if(json.status==-7){
			WST.msg('注册信息不完整!', {icon: 5});
		}else{
			WST.msg('注册失败!', {icon: 5});
		}
		getVerify();
	});
}


function showXiey(id){
	layer.open({
	    type: 2,
	    title: '用户注册协议',
	    shadeClose: true,
	    shade: 0.8,
	    area: ['1000px', ($(window).height() - 50) +'px'],
	    content: [userProtocolUrl],
	    btn: ['同意并注册'],
	    yes: function(index, layero){
	    	layer.close(index);
	    }
	});
}	    