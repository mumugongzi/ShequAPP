<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE >
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo ($CONF['shopTitle']['fieldValue']); ?> </title>
<meta name="keywords" content="<?php echo ($CONF['shopKeywords']['fieldValue']); ?>" />
<meta name="description" content="<?php echo ($CONF['shopDesc']['fieldValue']); ?>" />
<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css" />
<link rel="stylesheet" href="/Apps/Home/View/default/css/index.css" />
<link rel="stylesheet" href="/Apps/Home/View/default/css/base.css" />
<link rel="stylesheet" href="/Apps/Home/View/default/css/head.css" />
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
		<div style="float:left;width:160px;" class="wst-header-car">
		  <a href='<?php echo WSTDomain();?>/index.php'>
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
				<div class='wst-reach'>
					<img src="/Apps/Home/View/default/images/sadn.jpg"  height="38" width="40"/>
					<div style="float:left;position:absolute;top:0px;left:38px;"><span style="font-weight:bolder;">闪电配送</span><br/><span style="color:#e23c3d;">最快1小时送达</span></div>
				</div>
				<div class='wst-since'>
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
		  	<div class="wst-slide-controls">
		  		<?php if(is_array($indexAds)): $k = 0; $__LIST__ = $indexAds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($k == 1): ?><span class="curr"><?php echo ($k); ?></span>
		  		  	<?php else: ?>
		  		    	<span class=""><?php echo ($k); ?></span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		    <div class="navCon-cate fl navCon_on" >
		      <div class="navCon-cate-title"> <a href="<?php echo U('Home/goods/getGoodsList');?>">全部商品分类</a></div>
		      <div class="cateMenu1" >
		      </div>
		      <div class="cateMenu1" >
		        <div style="position:relative;">
		        	<div class="wst-nvgbk" style="diplay:none;"></div>
		        	<?php if(is_array($catList)): $k1 = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><li style="border-top: none;">
				    	<div>
				            <div class="cate-tag"> 
				            <div class="listModel">
				             <p > 
				            	<strong><s<?php echo ($k1); ?>></s<?php echo ($k1); ?>>&nbsp;<a style="font-weight:bold;" href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId']));?>"><?php echo ($vo1["catName"]); ?></a></strong>
				             </p> 
				             </div>
				              <div class="listModel">
				                <p> 
				                <?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId'],'c2Id'=>$vo2['catId']));?>"><?php echo ($vo2["catName"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				                </p>
				              </div>
				            </div>
				            <div class="list-item hide">
				              <ul class="itemleft">
				              	<?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><dl>
				                  <dt><a href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId'],'c2Id'=>$vo2['catId']));?>"><?php echo ($vo2["catName"]); ?></a></dt>
				                  <dd> 
				                  <?php if(is_array($vo2['catChildren'])): $k3 = 0; $__LIST__ = $vo2['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($k3 % 2 );++$k3;?><a href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId'],'c2Id'=>$vo2['catId'],'c3Id'=>$vo3['catId']));?>"><?php echo ($vo3["catName"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				                  </dd>
				                </dl>
				                <div class="fn-clear"></div><?php endforeach; endif; else: echo "" ;endif; ?>
				              </ul>
				            </div>
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
		        <li <?php if($nvg_mk == 'brands'): ?>class="curMenu"<?php endif; ?>><a href="<?php echo U('Home/Brands/index');?>"><s2 <?php if($nvg_mk == 'brands'): ?>id="curs2"<?php endif; ?>></s2>&nbsp;品牌汇</a></li>
		        <li <?php if($nvg_mk == 'shopstreet'): ?>class="curMenu"<?php endif; ?>><a href="<?php echo U('Home/Shops/toShopStreet');?>"><s3 <?php if($nvg_mk == 'shopstreet'): ?>id="curs3"<?php endif; ?>></s3>&nbsp;店铺街</a></li>
		      	<?php if($selfShop['shopId'] > 0): ?><li <?php if($selfShop['shopId'] == $shopId): ?>class="curMenu"<?php endif; ?>><a href="<?php echo U('Home/Shops/toShopHome',array('shopId'=>$selfShop['shopId']));?>"><s4 <?php if($selfShop['shopId'] == $shopId): ?>id="curs4"<?php endif; ?>></s4>&nbsp;自营店铺</a></li><?php endif; ?>
		      </ul>
		    </div>
		    <li id="wst-nvg-cart">
		    	<div class='wst-nvg-cart-cost'>
		       		&nbsp;<span class="wst-nvg-cart-cnt">0</span>件&nbsp;|&nbsp;<span class="wst-nvg-cart-price">0.00</span>元
		       	</div>
			</li>
			<div class="wst-cart-box"><div class="wst-nvg-cart-goods">购物车中暂无商品</div></div>
		  </div>
		</div>
	<!----加载广告start----->
	<div class="wst-ad">
		<div class="wst-slide" id="wst-slide">
			<ul class="wst-slide-items">
				<?php if(is_array($indexAds)): $k = 0; $__LIST__ = $indexAds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li style="z-index: 1;"><a target="_blank"
					href="/index.php/Home/Index/access/?id=<?php echo ($vo['adId']); ?>&url=<?php echo ($vo['adURL']); ?>">
						<img src="/<?php echo ($vo['adFile']); ?>" height="360" width="60%" title="<?php echo ($vo['adName']); ?>" />
				</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
	<div class='wst-clear'></div>
	<!----加载商品楼层start----->
	<div class="wst-container">
		<!-------------F1层---------------->
		<?php if(is_array($catList)): $k1 = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><div class="wst-floor">
			<div class="wst-fl-left wst-fl<?php echo ($k1); ?>" style="position: relative;">
				<div
					style="position: absolute; top: 40px; width: 210px; height: 180px;">
					<?php if(is_array($catAds[$vo1['catId']])): $kv = 0; $__LIST__ = $catAds[$vo1['catId']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($kv % 2 );++$kv;?><a
						href="/index.php/Home/Index/access/?id=<?php echo ($vo['adId']); ?>&url=<?php echo ($vo['adURL']); ?>"
						target="_blank"> <img data-original="/<?php echo ($vo['adFile']); ?>"
						height="180" width="210" title="<?php echo ($vo['adName']); ?>" />
					</a><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div
					style="position: absolute; top: 0px; left: 0px; width: 99%; height: 40px; padding-left: 10px; color: #ffffff; line-height: 38px; font-weight: bolder; background: url(/Apps/Home/View/default/images/<?php echo ($k1); ?>fhd.png) no-repeat 100% 100%;">
					<a
						href="/index.php/Home/goods/getGoodsList/?c1Id=<?php echo ($vo1['catId']); ?>">
						<span style="font-size: 18px;">F<?php echo ($k1); ?></span> <?php echo ($vo1["catName"]); ?>
					</a>
				</div>
				<div class='wst-cat' style="height: 300px; overflow: hidden;">
					<?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2; if(is_array($vo2['catChildren'])): $k3 = 0; $__LIST__ = $vo2['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($k3 % 2 );++$k3;?><a
						href="/index.php/Home/goods/getGoodsList/?c1Id=<?php echo ($vo1['catId']); ?>&c2Id=<?php echo ($vo2['catId']); ?>&c3Id=<?php echo ($vo3['catId']); ?>"><li
						class="wst-cat-left"><?php echo ($vo3["catName"]); ?></li></a><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

				</div>
			</div>
			<div class="wst-fl-right">
				<div class="wst-fl-nvg<?php echo ($k1); ?>">
					<ul>
						<li id="fl_<?php echo ($k1); ?>_0" style="line-height: 32px; width: 100px;"
							onmouseover="gpanelOver(this);">精品推荐</li>
						<?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><li id="fl_<?php echo ($k1); ?>_<?php echo ($k2); ?>" style="line-height: 32px; width: 100px;"
							onmouseover="gpanelOver(this);"><?php echo ($vo2["catName"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<div>

					<div id="fl_<?php echo ($k1); ?>_0_pl" class="wst-goods-container">
						<?php if(is_array($vo1['jpgoods'])): $k2 = 0; $__LIST__ = $vo1['jpgoods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><li class="wst-goodsbox">
							<div class="wst-goods-thumb">
								<a
									href="/index.php/Home/Goods/getGoodsDetails/?goodsId=<?php echo ($vo2['goodsId']); ?>">
									<img data-original="/<?php echo ($vo2['goodsThums']); ?>" width="180" />
								</a>
							</div>
							<div class="wst-goods-thumb-des">
								<div class="goodsname">
								<a class="wst-goods-name"
									href="/index.php/Home/Goods/getGoodsDetails/?goodsId=<?php echo ($vo2['goodsId']); ?>"><?php echo ($k2); echo ($vo2['goodsName']); ?></a>
								</div>
								<div>
									<em class="wst-left wst-goods-price">￥<?php echo (number_format($vo2['shopPrice'],2)); ?></em>
									<a href="javascript:addCart(<?php echo ($vo2['goodsId']); ?>,0,'<?php echo ($vo2['goodsThums']); ?>')" class="wst-right btnCart"> <img
										data-original="/Apps/Home/View/default/images/btn_addcart.png"
										width="85" />
									</a>
									<div class='wst-clear'></div>
								</div>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
						<div class='wst-clear'></div>
					</div>


					<?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><div id="fl_<?php echo ($k1); ?>_<?php echo ($k2); ?>_pl" class="wst-goods-container"
						style="display: none;">
						<?php if(is_array($vo2['goods'])): $k3 = 0; $__LIST__ = $vo2['goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($k3 % 2 );++$k3;?><li class="wst-goodsbox">
							<div class="wst-goods-thumb">
								<a
									href="/index.php/Home/Goods/getGoodsDetails/?goodsId=<?php echo ($vo3['goodsId']); ?>">
									<img data-original="/<?php echo ($vo3['goodsThums']); ?>" width="180" />
								</a>
							</div>
							<div class="wst-goods-thumb-des">
								<div class="goodsname">
									<a class="wst-goods-name"
										href="/index.php/Home/Goods/getGoodsDetails/?goodsId=<?php echo ($vo3['goodsId']); ?>"><?php echo ($vo3['goodsName']); ?></a>
								</div>
								<div>
									<em class="wst-left wst-goods-price">￥<?php echo (number_format($vo3['shopPrice'],2)); ?></em>
									<a href="javascript:addCart(<?php echo ($vo3['goodsId']); ?>,0,'<?php echo ($vo3['goodsThums']); ?>')"
										class="wst-right btnCart"> <img
										data-original="/Apps/Home/View/default/images/btn_addcart.png"
										width="85" />
									</a>
									<div class='wst-clear'></div>
								</div>
							</div>
							
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
						<div class='wst-clear'></div>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<div style="float: right; width: 180px; height: 180px;">
						<?php if(is_array($vo1['recommendShops'])): $k2 = 0; $__LIST__ = $vo1['recommendShops'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><div style="width: 180px; margin-top: 10px;">
							<div style="width: 180px;">
								<a
									href="/index.php/Home/Shops/toShopHome/?shopId=<?php echo ($vo2['shopId']); ?>">
									<img  data-original="/<?php echo ($vo2['shopImg']); ?>" height="120" width="180" />
								</a>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</div>
			<div style="clear: both; font-size: 0px;"></div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
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

	<link rel="stylesheet" type="text/css" href="/Apps/Home/View/default/css/cart.css" />
<script src="/Apps/Home/View/default/js/login.js"></script>
<script type="text/javascript" src="/Apps/Home/View/default/js/cart/common.js?v=725"></script>
<script type="text/javascript" src="/Apps/Home/View/default/js/cart/quick_links.js"></script>
<!--[if lte IE 8]>
<script src="/Apps/Home/View/default/js/cart/ieBetter.js"></script>
<![endif]-->
<script src="/Apps/Home/View/default/js/cart/parabola.js"></script>
<!--右侧贴边导航quick_links.js控制-->
	<div id="flyItem" class="fly_item" style="display:none;">
		<p class="fly_imgbox">
		<img src="/Apps/Home/View/default/images/item-pic.jpg"
			width="30" height="30">
		</p>
	</div>
	<div class="mui-mbar-tabs">
		<div class="quick_link_mian">
			<div class="quick_links_panel">
				<div id="quick_links" class="quick_links">
					<li><a href="#" class="my_qlinks"><i class="setting"></i></a>
						<div class="ibar_login_box status_login">
							<?php if($WST_USER['userId'] > 0): ?><div class="avatar_box">
								<p class="avatar_imgbox">
									<img
										src="/Apps/Home/View/default/images/no-img_mid_.jpg" />
								</p>
								<?php if($WST_USER['userId'] > 0): ?><ul class="user_info">
									<li>用户名：<?php echo ($WST_USER['loginName']); ?></li>
									<li>级&nbsp;别：普通会员</li>
								</ul><?php endif; ?>
							</div>
							
							<div class="ibar_recharge-btn">
								<input type="button" value="我的订单" onclick="getMyOrders();"/>
							</div>
							<i class="icon_arrow_white"></i>
						</div> <?php else: ?>
							<div style="margin: 0 auto;padding: 15px 0; width: 220px;">
							<div class="ibar_recharge-field">
								<label>帐号</label>
								<div class="ibar_recharge-fl">
									<div class="ibar_recharge-iwrapper">
										<input id="loginName" name="loginName" value="<?php echo ($loginName); ?>" type="text" name="19" placeholder="用户名/手机号/邮箱" />
									</div>
									<i class="ibar_username-contact"></i>
								</div>
							</div>
							<div class="ibar_recharge-field">
								<label>密码</label>
								<div class="ibar_recharge-fl">
									<div class="ibar_recharge-iwrapper">
										<input id="loginPwd" name="loginPwd" type="password" name="19" placeholder="密码" />
									</div>
									<i class="ibar_password-contact"></i>
								</div>
							</div>
							<div class="ibar_recharge-field">
								<label>验证码</label>
								<div class="ibar_recharge-fl" style="width:80px;">
									<div class="ibar_recharge-iwrapper">
										<input id="verify" style="ime-mode:disabled;width:80px;" name="verify" class="text text-1" tabindex="6" autocomplete="off" maxlength="6" type="text" placeholder="验证码"/>
									</div>
								</div>
								<label class="img" onclick="javascript:getVerify()">
				                	<img style='vertical-align:middle;cursor:pointer;height:30px;width:93px;' class='verifyImg' src='/Apps/Home/View/default/images/clickForVerify.png' title='刷新验证码' onclick='javascript:getVerify()'/> 
								</label>
							</div>
							<div class="ibar_recharge-btn">
								<input type="button" value="登录" onclick="checkLoginInfo();"/>
							</div>
							</div><?php endif; ?></li>
					<li id="shopCart"><a href="#" class="message_list"><i class="message"></i>
					<div class="span">购物车</div> <span class="cart_num"><?php echo ($cartcnt); ?></span></a></li>
				</div>
				<div class="quick_toggle">
					<li><a href="#none"><i class="mpbtn_qrcode"></i></a>
						<div class="mp_qrcode" style="display: none;">
							<img
								src="/Apps/Home/View/default/images/wstmall_weixin.png"
								width="148"  /><i class="icon_arrow_white"></i>
						</div></li>
					<li><a href="#top" class="return_top"><i class="top"></i></a></li>
				</div>
			</div>
			<div id="quick_links_pop" class="quick_links_pop hide"></div>
		</div>
	</div>
	<script type="text/javascript">
	var numberItem = <?php echo ($cartcnt); ?>;
	$(".quick_links_panel li").mouseenter(function() {
		$(this).children(".mp_tooltip").animate({
			left : -92,
			queue : true
		});
		$(this).children(".mp_tooltip").css("visibility", "visible");
		$(this).children(".ibar_login_box").css("display", "block");
	});
	$(".quick_links_panel li").mouseleave(function() {
		$(this).children(".mp_tooltip").css("visibility", "hidden");
		$(this).children(".mp_tooltip").animate({
			left : -121,
			queue : true
		});
		$(this).children(".ibar_login_box").css("display", "none");
	});
	$(".quick_toggle li").mouseover(function() {
		$(this).children(".mp_qrcode").show();
	});
	$(".quick_toggle li").mouseleave(function() {
		$(this).children(".mp_qrcode").hide();
	});

	// 元素以及其他一些变量
	var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document
			.querySelector("#shopCart");
	eleFlyElement.style.visibility = "hidden";
	
	var numberItem = 0;
	// 抛物线运动
	var myParabola = funParabola(eleFlyElement, eleShopCart, {
		speed : 100, //抛物线速度
		curvature : 0.0012, //控制抛物线弧度
		complete : function() {
			eleFlyElement.style.visibility = "hidden";
			jQuery.post(domainURL +"/index.php/Home/Cart/getCartInfo/" ,{"axm":1},function(data) {
				var cart = WST.toJson(data);
				eleShopCart.querySelector("span").innerHTML = cart.cartgoods.length;
			});
			
		}
	});
	// 绑定点击事件
	if (eleFlyElement && eleShopCart) {
		[].slice
				.call(document.getElementsByClassName("btnCart"))
				.forEach(
						function(button) {
							button
									.addEventListener(
											"click",
											function(event) {
												// 滚动大小
												var scrollLeft = document.documentElement.scrollLeft
														|| document.body.scrollLeft
														|| 0, scrollTop = document.documentElement.scrollTop
														|| document.body.scrollTop
														|| 0;
												eleFlyElement.style.left = event.clientX
														+ scrollLeft + "px";
												eleFlyElement.style.top = event.clientY
														+ scrollTop + "px";
												eleFlyElement.style.visibility = "visible";
												$(eleFlyElement).show();
												// 需要重定位
												myParabola.position().move();
											});
						});
	}

	function getMyOrders(){
		document.location.href = "/index.php/Home/Orders/queryByPage";
	}
</script>
	<script src="/Public/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/index.js"></script>
    <script src="/Apps/Home/View/default/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/global.js" type="text/javascript"></script>
    <script src="/Apps/Home/View/default/js/head.js" type="text/javascript"></script>
    <script src="/Apps/Home/View/default/js/goods.js" type="text/javascript"></script>
</body>

</html>