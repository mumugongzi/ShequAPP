<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script src="/Public/plugins/kindeditor/kindeditor.js"></script>
      <script src="/Public/plugins/kindeditor/lang/zh_CN.js"></script>
   </head>
   <style>
    .wst-tab-box{width:100%; height:auto; margin:0px auto;}
	.wst-tab-nav{margin:0; padding:0; height:25px; line-height:24px;position: relative;top:2px;left:3px;}
	.wst-tab-nav li{cursor:pointer;float:left; margin:0 0px; list-style:none; border:1px solid #ddd; border-bottom:none; height:24px; width:100px; text-align:center; background:#eeeeee;color:#000000;}
	.wst-tab-nav .on{background:#ffffff;color:#000000;border-bottom:0 none;}
	.wst-tab-content{padding:5px;width:99%; height:auto; border:1px solid #ddd;background:#FFF;}
    .wst-gallery-imgs{width:770px;height:auto;}
    .wst-gallery-img{width:140px;height:100px;float:left;overflow:hidden;margin:10px 5px 5px 5px;}
   </style>
   <script>
   $(function () {
	   $('#tab').TabPanel({tab:0});
	   KindEditor.ready(function(K) {
			editor1 = K.create('textarea[name="goodsDesc"]', {
				height:'250px',
				allowFileManager : false,
				allowImageUpload : true,
				items:[
				        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
				        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
				        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
				        'anchor', 'link', 'unlink', '|', 'about'
				],
				afterBlur: function(){ this.sync(); }
			});
		});
	   <?php if($object['goodsId'] !=0 ): ?>getCatList("goodsCatId2",<?php echo ($object["goodsCatId1"]); ?>,0,<?php echo ($object["goodsCatId2"]); ?>);
	   getCatList("goodsCatId3",<?php echo ($object["goodsCatId2"]); ?>,1,<?php echo ($object["goodsCatId3"]); ?>);
	   getShopCatList(<?php echo ($object["shopCatId1"]); ?>,<?php echo ($object["shopCatId2"]); ?>);<?php endif; ?>
   });
   function getCatList(objId,parentId,t,id){
	   var params = {};
	   params.id = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#goodsCatId3').empty();
		   $('#goodsCatId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post("/index.php/Admin/goodsCats/queryByList",params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.catId+'" '+((id==opts.catId)?'selected':'')+'>'+opts.catName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
   }
   function getShopCatList(v,id){
	   var params = {};
	   params.id = v;
	   params.shopId = $('#shopId').val();
	   $('#shopCatId2').empty();
	   var html = [];
	   $.post("/index.php/Admin/ShopsCats/queryByList",params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.catId+'" '+((id==opts.catId)?'selected':'')+'>'+opts.catName+'</option>');
				}
			}
			$('#shopCatId2').html(html.join(''));
	   });
   }
   function changeStatus(id,v){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("/index.php/Admin/Goods/changeGoodsStatus",{id:id,status:v},function(data,textStatus){
				var json = WST.toJson(data);
				if(json.status=='1'){
					Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
						location.href="/index.php/Admin/Goods";
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
       <div id='tab' class="wst-tab-box">
		<ul class="wst-tab-nav">
	    	<li>商品信息</li>
	        <li>商品相册</li>
	    </ul>
    	<div class="wst-tab-content" style='width:98%;'>
    	<div class='wst-tab-item'>
	        <form name="myform" method="post" id="myform">
	        <input type='hidden' id='id' value='<?php echo ($object["goodsId"]); ?>'/>
	        <input type='hidden' id='shopId' value='<?php echo ($object["shopId"]); ?>'/>
	        <table class="table table-hover table-striped table-bordered wst-form">
	           <tr>
	             <th width='120'>商品编号：</th>
	             <td width='300'>
	             <input type='text' id='goodsSn' name='goodsSn' class="form-control wst-ipt" value='<?php echo ($object["goodsSn"]); ?>' maxLength='25'/>
	             </td>
	             <td rowspan='6' style='padding:5px;'>
	             <img id='goodsImgPreview' src='<?php if($object['goodsImg'] =='' ): ?>/Apps/Home/View/default/img/store_default_sign.png<?php else: ?>/<?php echo ($object['goodsImg']); endif; ?>' width='160' height='160'/><br/>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品名称<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsName' name='goodsName' class="form-control wst-ipt" value='<?php echo ($object["goodsName"]); ?>' maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>市场价<font color='red'>*</font>：</th>
	             <td><input type='text' id='marketPrice' name='marketPrice' class="form-control wst-ipt" value='<?php echo ($object["marketPrice"]); ?>' maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>门店价格<font color='red'>*</font>：</th>
	             <td><input type='text' id='shopPrice' name='shopPrice' class="form-control wst-ipt" value='<?php echo ($object["shopPrice"]); ?>' maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>市场库存<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsStock' name='goodsStock' class="form-control wst-ipt" value='<?php echo ($object["goodsStock"]); ?>' maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>单位<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsUnit' name='goodsUnit' class="form-control wst-ipt" value='<?php echo ($object["goodsUnit"]); ?>' maxLength='25'/></td>
	           </tr>
	           <tr>
	             <th width='120'>规格：</th>
	             <td colspan='3'>
	             <textarea rows="2" cols="50" id='goodsSpec' name='goodsSpec'><?php echo ($object["goodsSpec"]); ?></textarea>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品状态<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <label>
	             <input type='radio' id='isSale1' name='isSale' <?php if($object['isSale'] ==1 ): ?>checked<?php endif; ?> value='1'/>上架
	             </label>
	             <label>
	             <input type='radio' id='isSale0' name='isSale' <?php if($object['isSale'] ==0 ): ?>checked<?php endif; ?> value='0'/>下架
	             </label>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>所属分类<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <select id='goodsCatId1' onchange='javascript:getCatList("goodsCatId2",this.value,0)'>
	                <option value=''>请选择</option>
	                <?php if(is_array($goodsCatsList)): $i = 0; $__LIST__ = $goodsCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['goodsCatId1'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	             </select>
	             <select id='goodsCatId2' onchange='javascript:getCatList("goodsCatId3",this.value,1);'>
	                <option value=''>请选择</option>
	             </select>
	             <select id='goodsCatId3'>
	                <option value=''>请选择</option>
	             </select>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>门店分类<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <select id='shopCatId1' onchange='javascript:getShopCatList(this.value,"<?php echo ($object['shopCatId2']); ?>")'>
	                <option value='0'>请选择</option>
	                <?php if(is_array($shopCatsList)): $i = 0; $__LIST__ = $shopCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['shopCatId1'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	             </select>
	             <select id='shopCatId2'>
	                <option value='0'>请选择</option>
	             </select>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品描述<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <textarea rows="2" cols="50" id='goodsDesc' name='goodsDesc'><?php echo ($object["goodsDesc"]); ?></textarea>
	             </td>
	           </tr>
	           <tr>
	             <td colspan='3' style='padding-left:250px;'>
	                 <button type="button" class="btn btn-danger" onclick='javascript:changeStatus(<?php echo ($object['goodsId']); ?>,0)'>禁&nbsp;售</button>
	                 <button type="button" class="btn btn-primary" onclick='javascript:location.href="/index.php/Admin/Goods"'>返&nbsp;回</button>
	             </td>
	           </tr>
	        </table>
	       </form>
	      </div>
	      <div class='wst-tab-item'>
	       <div id='galleryImgs' class='wst-gallery-imgs'>
	           <?php if(is_array($object['gallery'])): $i = 0; $__LIST__ = $object['gallery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="wst-gallery-img">
			       <img class="gallery-img" width='140' height='100' iv="<?php echo ($vo["goodsThumbs"]); ?>" v="<?php echo ($vo["goodsImg"]); ?>" src="/<?php echo ($vo["goodsThumbs"]); ?>"/>
		       </div><?php endforeach; endif; else: echo "" ;endif; ?>
	       </div>
	       <div style='clear:both;'></div>
	      </div>
       </div>
       </div>
       </form>
   </body>
</html>