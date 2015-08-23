<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  		<title>我的商铺 - <?php echo ($CONF['shopTitle']['fieldValue']); ?></title>
  		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="Cache" content="no-cache">
  		<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css" />
    	<link rel="stylesheet" href="/Apps/Home/View/default/css/shop.css">
      	
      	<script>
		var publicurl = '/Public/';
		var shopId = '<?php echo ($orderInfo["order"]["shopId"]); ?>';
		var pageCount='<?php echo ($receiveOrders["totalPage"]); ?>';
		var current='<?php echo ($receiveOrders["currPage"]); ?>';
		</script>
		<?php echo WSTLoginTarget(1);?>
    </head>
    <body>
        <div class="wst-wrap">
          <div class='wst-header'>
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
			<!-- <li class="fore4" id="biz-service" data-widget="dropdown" style='padding:0;'>&nbsp;<s></s>&nbsp;&nbsp;&nbsp;
				所在城市
				【<span class='wst-city'>&nbsp;<?php echo ($currArea["areaName"]); ?>&nbsp;</span>】
				<img src="/Apps/Home/View/default/images/icon_top_03.png"/>	
				&nbsp;&nbsp;<a href="javascript:;" onclick="changeCity();">切换城市</a><i class="triangle"></i>
			</li> -->
		</ul>
	
		<ul class="fr lh" style='float:right;'>
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='<?php echo WSTDomain();?>/index.php'><?php echo ($CONF['shopTitle']['fieldValue']); ?></a>！<s></s>&nbsp;
			<span>
				<?php if(!$WST_USER['userId']): ?><!-- <a href="<?php echo U('Home/Shops/login');?>">[登录]</a> -->
				<a href="<?php echo U('Home/Shops/toOpenShop');?>"	rel="nofollow">开店申请</a><?php endif; ?>
				<?php if($WST_USER['userId'] > 0): ?><a href="javascript:logout();">[退出]</a><?php endif; ?>
			</span>
			</li>
			<!-- <li class="fore2 ld"><s></s>
			<?php if(session('WST_USER.userId')>0){ ?>
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
			    <a href="<?php echo U('Home/Shops/toOpenShop');?>" rel="nofollow">我要开店</a>
			<?php } ?>
			</li> -->
		</ul>
		<span class="clr"></span>
	</div>
</div>


			<!-- <div class='wst-user-top'>
			<div class="wst-user-top-main">
					<div class='wst-user-top-logo'>
						<a href="<?php echo WSTDomain();?>/index.php"  title='商城首页'>
						<img src="/Apps/Home/View/default/images/logo.png" height="132" width='240'/>	
						</a>
					</div>
					<div class='wst-user-top-search'>
						<div class="search-box">
							<input id="wst-search-type" type="hidden" value="1"/>
							<input id="keyword" class="wst-search-ipt" me="q" tabindex="9" placeholder="搜索 商品" autocomplete="off" >
							<div id="btnsch" class="wst-search-btn">搜&nbsp;索</div>
						</div>
					</div>
					
				</div>
			</div> -->
			<div class="wst-shop-nav">
				<div class="wst-nav-box">
					<li class="liselect"><a href="<?php echo U('Home/Shops/index');?>" style='color:#FFFFFF;'>我的商铺</a></li>
					<div class="wst-clear"></div>
				</div>
			</div>
			<div class="wst-clear;"></div>
		</div>
          <div class='wst-nav'></div>
          <div class='wst-main'>
            <div class='wst-menu'>
            <span class='wst-menu-title' style='border-top:0px;'><span></span>商品管理</span>
            
               <a href='/index.php/Home/ShopsCats/index'><li <?php if($umark == "index"): ?>class='liselect'<?php endif; ?>>商品分类</li></a>
               <a href='/index.php/Home/Goods/queryOnSaleByPage'><li <?php if($umark == "queryOnSaleByPage"): ?>class='liselect'<?php endif; ?>>出售中的商品</li></a>
               <a href='/index.php/Home/Goods/queryPenddingByPage'><li <?php if($umark == "queryPenddingByPage"): ?>class='liselect'<?php endif; ?>>待审核商品</li></a>
               <a href='/index.php/Home/Goods/queryUnSaleByPage'><li <?php if($umark == "queryUnSaleByPage"): ?>class='liselect'<?php endif; ?>>仓库中的商品</li></a>
               <a href='/index.php/Home/Goods/toEdit/?umark=toEditGoods'><li <?php if($umark == "toEditGoods"): ?>class='liselect'<?php endif; ?>>新增商品</li></a>
               <a href='/index.php/Home/GoodsAppraises/index'><li <?php if($umark == "GoodsAppraises"): ?>class='liselect'<?php endif; ?>>评价管理</li></a>
            
            <span class='wst-menu-title'><span></span>交易管理</span>
            
              <a href='/index.php/Home/Orders/toShopOrdersList'><li <?php if($umark == "toShopOrdersList"): ?>class='liselect'<?php endif; ?>>订单管理</li></a>
              <span class='wst-menu-title'><span></span>网店设置</span>
            	<a href='/index.php/Home/Shops/toEdit'><li <?php if($umark == "toEdit"): ?>class='liselect'<?php endif; ?>>店铺资料</li></a>
              	<a href='/index.php/Home/Shops/toShopCfg'><li <?php if($umark == "setShop"): ?>class='liselect'<?php endif; ?>>店铺设置</li></a>
              	<a href='/index.php/Home/Messages/queryByPage'><li <?php if($umark == "queryMessageByPage"): ?>class='liselect'<?php endif; ?>>商城消息</li></a>
              	<a href='/index.php/Home/Shops/toEditPass'><li <?php if($umark == "toEditPass"): ?>class='liselect'<?php endif; ?>>修改密码</li></a>
            </div>
            <div class='wst-content'>
            
<link rel="stylesheet" href="/Public/plugins/uploadify/uploadify.css">
<script src="/Public/plugins/uploadify/jquery.uploadify.min.js"></script>
<script src="/Public/plugins/kindeditor/kindeditor.js"></script>
<script src="/Public/plugins/kindeditor/lang/zh_CN.js"></script>
<script>
$(function () {
	   $('#tab').TabPanel({tab:0});
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
			       editGoods('<?php echo ($umark); ?>');
			       return false;
			},onError:function(msg){
		}});
	   $("#goodsSn").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入商品编号"});
	   $("#goodsName").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入商品名称"});
	   $("#marketPrice").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入市场价格"});
	   $("#shopPrice").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入店铺价格"});
	   $("#goodsStock").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入库存"});
	   $("#goodsUnit").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"请输入商品单位"});
	   $("#goodsCatId3").formValidator({onFocus:"请选择商品分类"}).inputValidator({min:1,onError: "请选择完整商品分类"});
	   $("#shopCatId2").formValidator({onFocus:"请选择店铺分类"}).inputValidator({min:1,onError: "请选择完整店铺分类"});
	   $("#goodsImgUpload").uploadify({
		    formData      : {'dir':'goods','width':150,'height':150},
		    buttonText    : '选择商品图片',
		    fileTypeDesc  : 'Image Files',
	        fileTypeExts  : '*.gif; *.jpg; *.png',
	        swf           : publicurl+'/plugins/uploadify/uploadify.swf',
	        uploader      : domainURL +'/index.php/Home/shops/uploadPic',
	        onUploadSuccess : function(file, data, response) {
	        	var json = WST.toJson(data);
	        	if(json.status && json.status==1){
		        	$('#goodsImgPreview').attr('src',domainURL +'/'+json.Filedata.savepath+json.Filedata.savethumbname).show();
		        	$('#goodsImg').val(json.Filedata.savepath+json.Filedata.savename);
		        	$('#goodsThumbs').val(json.Filedata.savepath+json.Filedata.savename);
	        	}
        }
	    });
	   $("#galleryImgUpload").uploadify({
		    formData      : {'dir':'goods','width':150,'height':150},
		    buttonText    : '选择商品图片',
		    fileTypeDesc  : 'Image Files',
	        fileTypeExts  : '*.gif; *.jpg; *.png',
	        swf           : publicurl+'/plugins/uploadify/uploadify.swf',
	        uploader      : domainURL +'/index.php/Home/shops/uploadPic',
	        onUploadSuccess : function(file, data, response) {
	        	var json = WST.toJson(data);
	        	if(json.status && json.status==1){
	        		$('<div class="wst-gallery-img" onmouseover="imgmouseover(this);" onmouseout="imgmouseout(this);"><span class="wst-gallery-goods-del" onclick="javascript:delImg(this)"></span><img class="gallery-img" iv="'+json.Filedata.savepath+json.Filedata.savethumbname+'" v="'+json.Filedata.savepath+json.Filedata.savename+'" src="'+domainURL +'/'+json.Filedata.savepath+json.Filedata.savethumbname+'"/></div>').appendTo('#galleryImgs');
	        	}
       }
	   });
	   KindEditor.ready(function(K) {
			editor1 = K.create('textarea[name="goodsDesc"]', {
				height:'250px',
				width:"800px",
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
	   <?php if($object['goodsId'] !=0 ): ?>getCatListForEdit("goodsCatId2",<?php echo ($object["goodsCatId1"]); ?>,0,<?php echo ($object["goodsCatId2"]); ?>);
	   getCatListForEdit("goodsCatId3",<?php echo ($object["goodsCatId2"]); ?>,1,<?php echo ($object["goodsCatId3"]); ?>);
	   getShopCatListForEdit(<?php echo ($object["shopCatId1"]); ?>,<?php echo ($object["shopCatId2"]); ?>);<?php endif; ?>
	   
	  
});
function imgmouseover(obj){
	$(obj).find('.wst-gallery-goods-del').show();
}
function imgmouseout(obj){
	$(obj).find('.wst-gallery-goods-del').hide();
}
function delImg(obj){
	   $(obj).parent().remove();
}
	</script>
       <div class="wst-body"> 
       <div class='wst-page-header'>卖家中心 > <?php if($object['goodsId'] ==0 ): ?>新增<?php else: ?>编辑<?php endif; ?>商品资料</div>
       <div class='wst-page-content'>
       <div id='tab' class="wst-tab-box">
		<ul class="wst-tab-nav">
	    	<li>商品信息</li>
	        <li>商品相册</li>
	    </ul>
    	<div class="wst-tab-content" style='width:99%;margin-bottom: 10px;'>
    	<div class='wst-tab-item'>
	        <form name="myform" method="post" id="myform">
	        <input type='hidden' id='id' value='<?php echo ($object["goodsId"]); ?>'/>
	        <input type='hidden' id='goodsImg' value='<?php echo ($object["goodsImg"]); ?>'/>
	        <input type='hidden' id='goodsThumbs' value='<?php echo ($object["goodsThums"]); ?>'/>
	        <table class="wst-form" >
	           <tr>
	             <th width='120'>商品编号<font color='red'>*</font>：</th>
	             <td width='300'>
	             <input type='text' id='goodsSn' name='goodsSn' class="form-control wst-ipt" value='<?php echo ($object["goodsSn"]); ?>' maxLength='25'/>
	             </td>
	             <td rowspan='6' style='padding:5px;'>
	             <img id='goodsImgPreview' src='<?php if($object['goodsImg'] =='' ): ?>/Apps/Home/View/default/images/store_default_sign.png<?php else: ?>/<?php echo ($object['goodsImg']); endif; ?>' width='160' height='160'/><br/>
	             <input type='text' id='goodsImgUpload'/>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品名称<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsName' name='goodsName' class="form-control wst-ipt" value='<?php echo ($object["goodsName"]); ?>' maxLength='40'/></td>
	           </tr>
	            <tr>
	             <th width='120'>市场价<font color='red'>*</font>：</th>
	             <td><input type='text' id='marketPrice' name='marketPrice' class="form-control wst-ipt" value='<?php echo ($object["marketPrice"]); ?>' onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>店铺价格<font color='red'>*</font>：</th>
	             <td><input type='text' id='shopPrice' name='shopPrice' class="form-control wst-ipt" value='<?php echo ($object["shopPrice"]); ?>' onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>市场库存<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsStock' name='goodsStock' class="form-control wst-ipt" value='<?php echo ($object["goodsStock"]); ?>' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='25'/></td>
	           </tr>
	            <tr>
	             <th width='120'>单位<font color='red'>*</font>：</th>
	             <td><input type='text' id='goodsUnit' name='goodsUnit' class="form-control wst-ipt" value='<?php echo ($object["goodsUnit"]); ?>'  maxLength='25'/></td>
	           </tr>
	           <tr>
	             <th width='120'>规格：</th>
	             <td colspan='3'>
	             <textarea rows="2" style="width:788px" id='goodsSpec' name='goodsSpec'><?php echo ($object["goodsSpec"]); ?></textarea>
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
	             <th width='120'>商品属性：</th>
	             <td colspan='3'>
	             <label>
	             <input type='checkbox' id='isRecomm' name='isRecomm' <?php if($object['isRecomm'] ==1 ): ?>checked<?php endif; ?> value='1'/>推荐
	             </label>
	             <label>
	             <input type='checkbox' id='isBest' name='isBest' <?php if($object['isBest'] ==1 ): ?>checked<?php endif; ?> value='1'/>精品
	             </label>
	             <label>
	             <input type='checkbox' id='isNew' name='isNew' <?php if($object['isNew'] ==1 ): ?>checked<?php endif; ?> value='1'/>新品
	             </label>
	             <label>
	             <input type='checkbox' id='isHot' name='isHot' <?php if($object['isHot'] ==1 ): ?>checked<?php endif; ?> value='1'/>热销
	             </label>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>所属分类<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <select id='goodsCatId1' onchange='javascript:getCatListForEdit("goodsCatId2",this.value,0)'>
	                <option value=''>请选择</option>
	                <?php if(is_array($goodsCatsList)): $i = 0; $__LIST__ = $goodsCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['goodsCatId1'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	             </select>
	             <select id='goodsCatId2' onchange='javascript:getCatListForEdit("goodsCatId3",this.value,1);'>
	                <option value=''>请选择</option>
	             </select>
	             <select id='goodsCatId3'>
	                <option value=''>请选择</option>
	             </select>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>店铺分类<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <select id='shopCatId1' onchange='javascript:getShopCatListForEdit(this.value,"<?php echo ($object['shopCatId2']); ?>")'>
	                <option value='0'>请选择</option>
	                <?php if(is_array($shopCatsList)): $i = 0; $__LIST__ = $shopCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['shopCatId1'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	             </select>
	             <select id='shopCatId2'>
	                <option value='0'>请选择</option>
	             </select>
	             </td>
	           </tr>
	           <tr>
	             <th width='120' align='right'>品牌：</th>
	             <td>
	             <select id='brandId' dataVal='<?php echo ($object["brandId"]); ?>'>
	                <option value='0'>请选择</option>
	             </select>
	             </td>
	           </tr>
	           <tr>
	             <th width='120'>商品描述<font color='red'>*</font>：</th>
	             <td colspan='3'>
	             <textarea rows="2" cols="60" id='goodsDesc' name='goodsDesc'><?php echo ($object["goodsDesc"]); ?></textarea>
	             </td>
	           </tr>
	           <tr>
	             <td colspan='3' style='padding-left:320px;'>
	                 <button class='wst-btn-query' type="submit">保&nbsp;存</button>
	                 <?php if($umark !='toEdit' ): ?><button class='wst-btn-query' type="button" onclick='javascript:location.href="/index.php/Home/Goods/<?php echo ($umark); ?>"'>返&nbsp;回</button><?php endif; ?>
	             </td>
	           </tr>
	        </table>
	       </form>
	      </div>
	      <div class='wst-tab-item'>
	       <div><input type='text' id='galleryImgUpload'/></div>
	       
	       <div id='galleryImgs' class='wst-gallery-imgs'>
	           <?php if(is_array($object['gallery'])): $i = 0; $__LIST__ = $object['gallery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="wst-gallery-img" onmouseover="imgmouseover(this);" onmouseout="imgmouseout(this);">
			       <span class="wst-gallery-goods-del" onclick="javascript:delImg(this)"></span>
			       <img class="gallery-img" width='140' height='100' iv="<?php echo ($vo["goodsThumbs"]); ?>" v="<?php echo ($vo["goodsImg"]); ?>" src="/<?php echo ($vo["goodsThumbs"]); ?>"/>
		       </div><?php endforeach; endif; else: echo "" ;endif; ?>
	       </div>
	       <div style='clear:both;'></div>
	      </div>
       </div>
       </div>
       
       </div>
       <div style='clear:both;'></div>
       </div>

            </div>
          </div>
          <div style='clear:both;'></div>
          <br/>
          <!-- <div class='wst-footer'>
          	<div class="wst-footer-fl-box">
	<div class="wst-footer" >
		<div class="wst-footer-cld-box">
			<div class="wst-footer-fl">友情链接：</div>
			<div style="padding-left:30px;">
				<?php if(is_array($friendLikds)): $k = 0; $__LIST__ = $friendLikds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div style="float:left;"><a href="<?php echo ($vo["friendlinkUrl"]); ?>" target="_blank"><?php echo ($vo["friendlinkName"]); ?></a>&nbsp;&nbsp;</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wst-clear"></div>
			</div>
		</div>
	</div>
</div>

<div class="wst-footer-hp-box">
	<div class="wst-footer">
		<div class="wst-footer-hp-ck1">
			<?php if(is_array($helps)): $k1 = 0; $__LIST__ = $helps;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><div class="wst-footer-wz-ca">
				<div class="wst-footer-wz-pt">
				    <img src="/Apps/Home/View/default/images/a<?php echo ($k1); ?>.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-pn"><?php echo ($vo1["catName"]); ?></span>
					<div style='margin-left:30px;'>
						<?php if(is_array($vo1['articlecats'])): $k2 = 0; $__LIST__ = $vo1['articlecats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="/index.php/Home/Articles/index/?articleId=<?php echo ($vo2['articleId']); ?>"><?php echo ($vo2['articleTitle']); ?></a><br/><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
			
			<div class="wst-footer-wz-clt">
				<div style="padding-top:5px;line-height:25px;">
				    <img src="/Apps/Home/View/default/images/a6.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-kf">联系客服</span>
					<div style='margin-left:30px;'>
						<a href="#">订购热线</a><br/>
						<span class="wst-footer-pno">社区电话!</span><br/>
						<a href="#">在线客服</a><br/>
						<a href="#" class="wst-footer-wz-ent">点击这里进入</a><br/>
					</div>
				</div>
			</div>
			<div class="wst-clear"></div>
		</div>
	    
		
	    
	</div>
</div>

          </div> -->
        </div>
    </body>
      	<script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
     	<script src="/Public/js/common.js"></script>
      	<script src="/Apps/Home/View/default/js/shopcom.js"></script>
      	<script src="/Apps/Home/View/default/js/head.js"></script>
      	<script src="/Apps/Home/View/default/js/common.js"></script>
      	<script src="/Public/plugins/layer/layer.min.js"></script>
      	<script src="/Apps/Home/View/default/js/jquery.page.js" type="text/javascript"></script>
</html>