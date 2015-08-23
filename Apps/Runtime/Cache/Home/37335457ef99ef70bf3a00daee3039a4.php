<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($CONFIG['shopTitle']); ?>-系统提示</title>
	<meta name="description" content="<?php echo ($CONFIG['shopDesc']); ?>" />
	<meta name="Keywords" content="<?php echo ($CONFIG['shopKeywords']); ?>" />

	<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css" />
    <link rel="stylesheet" href="/Apps/Home/View/default/css/ordersuccess.css" />
    <link rel="stylesheet" href="/Apps/Home/View/default/css/base.css" />
	<link rel="stylesheet" href="/Apps/Home/View/default/css/head.css" />
    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/index.js"></script>      	
    <script src="/Apps/Home/View/default/js/common.js"></script>
</head>

<body class="root61">
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
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='#'><?php echo ($CONF['shopTitle']['fieldValue']); ?></a>！<s></s>&nbsp;
			<span>
				<?php if(!$WST_USER['userId']): ?><a href="<?php echo U('Home/Users/login');?>">[用户登录]</a>
				<a href="<?php echo U('Home/Users/regist');?>"	class="link-regist">[免费注册]</a><?php endif; ?>
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


<div style="height:132px;">
<div id="mainsearchbox" style="text-align:center;">
	<div id="wst-search-pbox">
		<div style="float:left;width:132px;" class="wst-header-car">
		  <a href='#'>
			<img id="wst-logo" src="/Apps/Home/View/default/images/logo.png" height="132" width="132"/>
		  </a>	
		</div>
		<div id="wst-search-container">
			<div id="wst-search-type-box">
				<input id="wst-search-type" type="hidden" value="<?php echo ($searchType); ?>"/>
				<div id="wst-panel-goods" class="<?php if($searchType == 1): ?>wst-panel-curr<?php else: ?>wst-panel-notcurr<?php endif; ?>">商品</div>
				<div id="wst-panel-shop" class="<?php if($searchType == 2): ?>wst-panel-curr<?php else: ?>wst-panel-notcurr<?php endif; ?>">店铺</div>
				<div class="wst-clear"></div>
			</div>
			<div id="wst-searchbox">
				<input id="keyword" placeholder="<?php if($searchType == 2): ?>搜索 店铺<?php else: ?>搜索 商品<?php endif; ?>" autocomplete="off"  value="<?php echo ($keyWords); ?>">
				<div id="btnsch" class="wst-search-button">搜&nbsp;索</div>
			</div>
		</div>
		<div id="wst-search-des-container">
			<div class="des-box">
				<div style="position:relative;float:left;width:130px;margin-left:10px;">
					<img src="/Apps/Home/View/default/images/sadn.jpg"  height="38" width="40"/>
					<div style="float:left;position:absolute;top:0px;left:38px;"><span style="font-weight:bolder;">闪电配送</span><br/><span style="color:#e23c3d;">最快1小时送达</span></div>
				</div>
				<div style="position:relative;float:left;width:120px;margin-left:20px;">
					<img src="/Apps/Home/View/default/images/sqzt.jpg"  height="38" width="40"/>
					<div style="float:left;position:absolute;top:0px;left:38px;"><span style="font-weight:bolder;">社区自提</span><br/><span style="color:#e23c3d;">330家自提点</span></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="headNav">
		  <div class="navCon w1020">
		    <div class="navCon-cate fl navCon_on" >
		      <div class="navCon-cate-title"> <a href="/index.php/Home/goods/getGoodsList">全部商品分类</a></div>
		      <div class="cateMenu2" style="display:none;" >
		        <div style="position:relative;">
		        	<div class="wst-nvgbk" style="diplay:none;"></div>
		        	<?php if(is_array($catList)): $k1 = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><li style="border-top: none;">
				            <div class="cate-tag"> 
				            <div class="listModel">
				             <p > 
				            	<strong><s<?php echo ($k1); ?>></s<?php echo ($k1); ?>>&nbsp;<a style="font-weight:bold;" href="/index.php/Home/goods/getGoodsList/?c1Id=<?php echo ($vo1['catId']); ?>"><?php echo ($vo1["catName"]); ?></a></strong>
				             </p> 
				             </div>
				              <div class="listModel">
				                <p> 
				                <?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="/index.php/Home/goods/getGoodsList/?c1Id=<?php echo ($vo1['catId']); ?>&c2Id=<?php echo ($vo2['catId']); ?>"><?php echo ($vo2["catName"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				                </p>
				              </div>
				            </div>
				            <div class="list-item hide">
				              <ul class="itemleft">
				              	<?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><dl>
				                  <dt><a href="/index.php/Home/goods/getGoodsList/?c1Id=<?php echo ($vo1['catId']); ?>&c2Id=<?php echo ($vo2['catId']); ?>"><?php echo ($vo2["catName"]); ?></a></dt>
				                  <dd> 
				                  <?php if(is_array($vo2['catChildren'])): $k3 = 0; $__LIST__ = $vo2['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($k3 % 2 );++$k3;?><a href="/index.php/Home/goods/getGoodsList/?c1Id=<?php echo ($vo1['catId']); ?>&c2Id=<?php echo ($vo2['catId']); ?>&c3Id=<?php echo ($vo3['catId']); ?>"><?php echo ($vo3["catName"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				                  </dd>
				                </dl>
				                <div class="fn-clear"></div><?php endforeach; endif; else: echo "" ;endif; ?>
				              </ul>
				            </div>
				  	        </li><?php endforeach; endif; else: echo "" ;endif; ?>
		          <li style="display:none;"></li>
		        </div>
		      </div>
		    </div>
		    <div class="navCon-menu fl">
		      <ul class="fl">
		       	<li ><a class="" href="/index.php"><s1></s1>&nbsp;&nbsp;&nbsp;&nbsp;商城首页</a></li>
		        <li style='display:none'><a href=""><s2></s2>&nbsp;自营超市</a></li>
		        <li <?php if($nvg_mk == 'brands'): ?>class="curMenu"<?php endif; ?>><a href="/index.php/Home/Brands/index"><s2 <?php if($nvg_mk == 'brands'): ?>id="curs2"<?php endif; ?>></s2>&nbsp;品牌汇</a></li>
		        <li <?php if($nvg_mk == 'shopstreet'): ?>class="curMenu"<?php endif; ?>><a href="/index.php/Home/Shops/toShopStreet"><s3 <?php if($nvg_mk == 'shopstreet'): ?>id="curs3"<?php endif; ?>></s3>&nbsp;店铺街</a></li>
		      	<?php if($selfShop['shopId'] > 0): ?><li <?php if($selfShop['shopId'] == $shopId): ?>class="curMenu"<?php endif; ?>><a href="/index.php/Home/Shops/toShopHome/?shopId=<?php echo ($selfShop['shopId']); ?>"><s4 <?php if($selfShop['shopId'] == $shopId): ?>id="curs4"<?php endif; ?>></s4>&nbsp;自营店铺</a></li><?php endif; ?>
		      </ul>
		    </div>
		    <li id="wst-nvg-cart">
		    	<div style="line-height:36px;padding-left:56px;margin-top:8px;">
		       		&nbsp;<span class="wst-nvg-cart-cnt">0</span>件&nbsp;|&nbsp;<span class="wst-nvg-cart-price">0.00</span>元
		       	</div>
			</li>
			<div class="wst-cart-box"><div style="line-height:100px;text-align:center;font-size:18px;">购物车中暂无商品</div></div>
		  </div>
		</div>
	<div class="w">
		<div>
			<div class="wst-sys-msg-pb">
					<div class="wst-sys-msg-cb">
						<div class="wst-sys-msg-vb">
							<?php if(count($orderInfos) > 0): ?><img src="/Apps/Home/View/default/images/icon-succ.png" alt="" /><?php endif; ?>
						</div>
						<div class="wst-sys-msg-cb">
							<div class="wst-sys-msg-l25">				
	   							<div class="wst-sys-msg-ub"><?php echo ($msg); ?></div>
	   						</div>							
						</div>
						<div style="clear: both;"></div>
					</div>					
					
					<div style="clear: both;"></div>
					<div style="margin-top:15px; ">			
						<div id="checkout" class="wst-checkout" >							
							<a class="btn-submit" href="/index.php">
								<span id="saveConsigneeTitleDiv" class="wst_btn-continue"></span>
							</a>
							<div style="clear: both;"></div>
						</div>
					</div>				
				</div>							
			</div>			
		</div>
	<div style="clear: both;"></div>
    <div style="height: 20px;"></div>
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

</body>
</html>