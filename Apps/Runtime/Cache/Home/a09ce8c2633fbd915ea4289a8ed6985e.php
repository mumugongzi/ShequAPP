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
<script>
$(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
			   setShop();
			   return false;
			},onError:function(msg){
		}});
	   
	   //$("#shopTitle").formValidator({onShow:"",onFocus:"请输入店铺SEO标题",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"店铺SEO标题不能为空,请确认"});
	   $("#shopKeywords").formValidator({onShow:"",onFocus:"请输入店铺SEO关键字",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError:"店铺SEO关键字不能为空,请确认"});
		$("#shopImgUpload").uploadify({
		    formData      : {'dir':'shopads','width':1400,'height':120},
		    buttonText    : '选择图标',
		    fileTypeDesc  : 'Image Files',
	        fileTypeExts  : '*.gif; *.jpg; *.png',
	        swf           : publicurl+'/plugins/uploadify/uploadify.swf',
	        uploader      : domainURL +'/index.php/Home/shops/uploadPic',
	        onUploadSuccess : function(file, data, response) {
	        	var json = WST.toJson(data);
	        	$('#preview').attr('src',domainURL+"/"+json.Filedata.savepath+json.Filedata.savethumbname).show();
	        	$('#shopBanner').val(json.Filedata.savepath+json.Filedata.savename);
        }
	    });
		
		$("#galleryImgUpload").uploadify({
		    formData      : {'dir':'shopads','width':1400,'height':350},
		    buttonText    : '选择店铺广告图片',
		    fileTypeDesc  : 'Image Files',
	        fileTypeExts  : '*.gif; *.jpg; *.png',
	        swf           : publicurl+'/plugins/uploadify/uploadify.swf',
	        uploader      : domainURL +'/index.php/Home/shops/uploadPic',
	        onUploadSuccess : function(file, data, response) {
	        	var json = WST.toJson(data);
	        	if(json.status && json.status==1){
	        		$('<div class="wst-gallery-img" onmouseover="imgmouseover(this);" onmouseout="imgmouseout(this);" style="height:132px;"><span class="wst-gallery-del" onclick="javascript:delImg(this)"></span><img width="140" height="100" class="gallery-img" iv="'+json.Filedata.savepath+json.Filedata.savethumbname+'" v="'+json.Filedata.savepath+json.Filedata.savename+'" src="'+domainURL+"/"+json.Filedata.savepath+json.Filedata.savethumbname+'"/><input class="gallery-img-url" placeholder="广告路径" type="text" style="width:118px;"/></div>').appendTo('#galleryImgs');
	        	}
       }
	   });
		
});
function imgmouseover(obj){

	$(obj).find('.wst-gallery-del').show();
}
function imgmouseout(obj){
	$(obj).find('.wst-gallery-del').hide();
}
function delImg(obj){
	  $(obj).parent().remove();
}
</script>
   <div class="wst-body"> 
       <div class='wst-page-header'>卖家中心 > 店铺设置</div>
       <div class='wst-page-content'>
       <form name="myform" method="post" id="myform">
       	<input type='hidden' id='id' value='0'/>
        <input type='hidden' id='shopBanner' value='<?php echo ($object["shopBanner"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
            <!-- tr >
             <th width='120' align='right'>店铺SEO标题<font color='red'>*</font>：</th>
             <td><input type='text' id='shopTitle' class="form-control wst-ipt" value='<?php echo ($object["shopTitle"]); ?>' style='width:250px;' maxLength='25'/></td>
           </tr -->
           <tr>
             <th width='120' align='right'>店铺SEO关键字<font color='red'>*</font>：</th>
             <td><input type='text' id='shopKeywords' class="form-control wst-ipt" value='<?php echo ($object["shopKeywords"]); ?>' style='width:350px;' maxLength='25'/></td>
           </tr>
           <tr>
	         <th width='120'>店铺SEO描述：</th>
	         <td colspan='3'>
	             <textarea rows="2" style='width:350px;' id='shopDesc' name='shopDesc' ><?php echo ($object["shopDesc"]); ?></textarea>
	         </td>
	      </tr>
           <tr>
             <th width='120' align='right'>顶部广告<font color='red'>*</font>：</th>
             <td>
             <div style="position:relative;">
             <input type='text' id='shopImgUpload' class="form-control wst-ipt"/>
             <span style="position:absolute;top:4px;left:140px;">图片大小:1400 x 120 (px)</span></div>
             <div style="padding-top:4px;">
             	<img id='preview' src='/<?php echo ($object["shopBanner"]); ?>' width='140' height="100" <?php if($object['shopBanner'] =='' ): ?>style='display:none'<?php endif; ?> />
             </div>
             </td>
           </tr>
           <tr>
             <th width='120' align='right'>滚动广告<font color='red'>*</font>：</th>
             <td>
             	<div style="position:relative;"><input type='text' id='galleryImgUpload'/><span style="position:absolute;top:4px;left:140px;">图片大小:1400 x 350 (px)</span></div>
	       
		       <div id='galleryImgs' class='wst-gallery-imgs' style="width:600px;">
		           <?php if(is_array($object['shopAds'])): $i = 0; $__LIST__ = $object['shopAds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="wst-gallery-img" onmouseover="imgmouseover(this);" onmouseout="imgmouseout(this);" style="height:132px;">
				       <span class="wst-gallery-del" onclick="javascript:delImg(this)"></span>
				       <img width="140" height="100" class="gallery-img" iv="<?php echo ($vo["adImg_thumb"]); ?>" v="<?php echo ($vo["adImg"]); ?>" src="/<?php echo ($vo["adImg_thumb"]); ?>"/>
			       	   <input class="gallery-img-url"  placeholder="广告路径" type="text" style="width:118px;" value="<?php echo ($vo["adUrl"]); ?>"/>
			       </div><?php endforeach; endif; else: echo "" ;endif; ?>
		       </div>
		       <div style='clear:both;'></div>
             </td>
           </tr>
           <tr>
             <td colspan='2' style='text-align:center;padding:20px;'>
                 <button type="submit" class='wst-btn-query'>保&nbsp;存</button>&nbsp;&nbsp;
                 <button type="button" class='wst-btn-query' onclick='javascript:location.reload();'>重&nbsp;置</button>
             </td>
           </tr>
        </table>
       </form>
       </div>
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