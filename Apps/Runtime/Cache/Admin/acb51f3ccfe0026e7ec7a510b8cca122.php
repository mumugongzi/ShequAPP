<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="/Apps/Admin/View/css/daterangepicker/daterangepicker-bs3.css">
      <link rel="stylesheet" href="/Public/plugins/uploadify/uploadify.css">
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Apps/Admin/View/js/daterangepicker.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script src="/Public/plugins/uploadify/jquery.uploadify.min.js"></script>
   </head>
   <script>
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#adfileUpload").uploadify({
		    formData      : {'dir':'ads','width':1400,'height':1400},
		    buttonText    : '选择图标',
		    fileTypeDesc  : 'Image Files',
	        fileTypeExts  : '*.gif; *.jpg; *.png',
	        swf           : '/Public/plugins/uploadify/uploadify.swf',
	        uploader      : '/index.php/Admin/Ads/uploadPic',
	        onUploadSuccess : function(file, data, response) {
	        	var json = WST.toJson(data);
	        	$('#preview').attr('src','/'+json.Filedata.savepath+json.Filedata.savethumbname).show();
	        	$('#adFile').val(json.Filedata.savepath+json.Filedata.savename);
            }
	    });
	   $("#adPositionId").formValidator({onFocus:"请选择广告位置"}).inputValidator({min:1,onError: "请选择广告位置"});
	   $("#adName").formValidator({empty:false,onFocus:"请输入广告标题"}).inputValidator({min:1,onError: "请输入广告标题"});
	   $('#adDateRange').daterangepicker({format:'YYYY-MM-DD',separator:' -> '});
	   <?php if($object['adId'] !=0 ): ?>getAreaList("areaId2",<?php echo ($object["areaId1"]); ?>,0,<?php echo ($object["areaId2"]); ?>);<?php endif; ?>
   });
   function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post("/index.php/Admin/Areas/queryByList",params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
   }
   function edit(){
	   var params = {};
	   params.id = $('#id').val();
	   params.areaId1 = $('#areaId1').val();
	   params.areaId2 = $('#areaId2').val();
	   params.areaId3 = $('#areaId3').val();
     params.adPositionId = $('#adPositionId').val();
	   params.adSort = $('#adSort').val();
	   params.adName = $.trim($('#adName').val());
	   params.adFile = $.trim($('#adFile').val());
	   params.adURL = $.trim($('#adURL').val());
	   var date = $('#adDateRange').val().split(' -> ');
	   params.adStartDate = date[0];
	   params.adEndDate = date[1];
	   if(params.adFile==''){
		   Plugins.Tips({title:'信息提示',icon:'error',content:'请上传广告图片!',timeout:1000});
		   return;
	   }
	   Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
		$.post("/index.php/Admin/Ads/edit",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
				   location.href='/index.php/Admin/Ads/';
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
		});
   }
   </script>
   <body class="wst-page">
       <form name="myform" method="post" id="myform">
        <input type='hidden' id='id' value='<?php echo ($object["adId"]); ?>'/>
        <input type='hidden' id='adFile' value='<?php echo ($object["adFile"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th align='right'>广告城市：</th>
             <td>
             <select id='areaId1' onchange='javascript:getAreaList("areaId2",this.value,0)'>
                <option value=''>请选择</option>
                <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($object['areaId1'] == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
             </select>
             <select id='areaId2'>
               <option value=''>请选择</option>
             </select>
             (不选则默认整个商城)
             </td>
           </tr>
           <tr>
             <th align='right'>广告位置<font color='red'>*</font>：</th>
             <td>
             <select id='adPositionId'>
                <option value=''>请选择</option>
                <option value='-1' <?php if($object['adPositionId'] == -1 ): ?>selected<?php endif; ?>>首页主广告</option>
                <option value='-2' <?php if($object['adPositionId'] == -2 ): ?>selected<?php endif; ?>>品牌汇广告</option>
                <option value='-3' <?php if($object['adPositionId'] == -3 ): ?>selected<?php endif; ?>>店铺街广告</option>
                <?php if(is_array($goodsCatList)): $i = 0; $__LIST__ = $goodsCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['adPositionId'] == $vo['catId'] ): ?>selected<?php endif; ?>>(商品分类)<?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
             </select>
             </td>
           </tr>
           <tr>
             <th width='120' align='right'>广告标题<font color='red'>*</font>：</th>
             <td><input type='text' id='adName' class="form-control wst-ipt" value='<?php echo ($object["adName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th align='right'>广告图片<font color='red'>*</font>：</th>
             <td><input type='text' id='adfileUpload' class="form-control wst-ipt"/></td>
           </tr>
           <tr>
             <th align='right'>预览图：</th>
             <td height='40'>
               <img id='preview' src='/<?php echo ($object["adFile"]); ?>' height='150' width='500' <?php if($object['adFile'] =='' ): ?>style='display:none'<?php endif; ?>/>
             </td>
           </tr>
           <tr>
             <th align='right'>广告网址：</th>
             <td>
             <input type='text' id='adURL' class="form-control wst-ipt" value='<?php echo ($object["adURL"]); ?>'/>
             </td>
           </tr>
           <tr>
             <th align='right'>广告日期<font color='red'>*</font>：</th>
             <td>
             <input type='text' id='adDateRange' class="form-control" readonly='true' style='width:300px' value='<?php echo ($object["adStartDate"]); ?> -> <?php echo ($object["adEndDate"]); ?>'/>
             </td>
           </tr>
           <tr>
             <th align='right'>广告排序号：</th>
             <td>
             <input type='text' id='adSort' class="form-control"  value='<?php echo ($object["adSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/>
             </td>
           </tr>
           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                 <button type="button" class="btn btn-primary" onclick='javascript:location.href="/index.php/Admin/Ads/"'>返&nbsp;回</button>
             </td>
           </tr>
        </table>
       </form>
   </body>
</html>